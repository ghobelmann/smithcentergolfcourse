<?php

namespace App\Services;

use App\Models\League;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Score;
use App\Models\LeagueStanding;
use Illuminate\Support\Facades\DB;

class MatchPlayScoringService
{
    /**
     * Calculate match play standings for a league tournament
     * Uses four-ball best ball match play format
     * Each hole is worth 1 point, 9 holes = 9 points total
     */
    public function calculateWeeklyStandings(Tournament $tournament, League $league): void
    {
        if (!$tournament->isLeagueTournament() || $tournament->league_id !== $league->id) {
            throw new \Exception('Tournament does not belong to this league.');
        }

        $teams = $tournament->teams()->with(['members.user', 'scores'])->get();

        if ($teams->isEmpty()) {
            throw new \Exception('No teams found for this tournament.');
        }

        DB::beginTransaction();
        try {
            // Get all team matchups and calculate hole-by-hole results
            $teamResults = $this->calculateTeamPoints($teams, $league->holes);

            // Update standings for each team member
            foreach ($teamResults as $teamId => $result) {
                $team = $teams->firstWhere('id', $teamId);
                
                foreach ($team->members as $member) {
                    $standing = LeagueStanding::firstOrNew([
                        'league_id' => $league->id,
                        'user_id' => $member->user_id,
                        'week_number' => $tournament->week_number,
                    ]);

                    // Update weekly stats
                    $standing->tournament_id = $tournament->id;
                    $standing->position = $result['position'];
                    $standing->flight = $team->flight;
                    $standing->position_in_flight = $team->position_in_flight ?? null;
                    $standing->total_score = $result['total_score'] ?? null;
                    $standing->score_vs_par = null; // Not applicable in match play
                    $standing->points_earned = $result['points'];
                    $standing->participated = true;

                    // Update cumulative stats
                    $previousStandings = LeagueStanding::where('league_id', $league->id)
                        ->where('user_id', $member->user_id)
                        ->where('id', '!=', $standing->id ?? 0)
                        ->get();

                    $standing->total_points = $previousStandings->sum('points_earned') + $result['points'];
                    $standing->weeks_played = $previousStandings->where('participated', true)->count() + 1;

                    $allScores = $previousStandings->where('participated', true)->pluck('total_score')->filter()->push($result['total_score']);
                    if ($allScores->isNotEmpty()) {
                        $standing->best_score = $allScores->min();
                        $standing->worst_score = $allScores->max();
                        $standing->average_score = $allScores->average();
                    }

                    $standing->save();
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Calculate points for each team based on hole-by-hole match play
     * In a round-robin or multiple matchups format
     */
    private function calculateTeamPoints($teams, int $holes): array
    {
        $teamResults = [];

        foreach ($teams as $team) {
            // Get best ball scores for each hole
            $teamBestBall = $this->calculateTeamBestBall($team, $holes);
            
            // Calculate total points against all other teams
            $totalPoints = 0;
            $matchesPlayed = 0;
            
            foreach ($teams as $opponent) {
                if ($team->id === $opponent->id) {
                    continue;
                }
                
                $opponentBestBall = $this->calculateTeamBestBall($opponent, $holes);
                
                // Calculate match play points for this matchup
                $matchResult = $this->calculateMatchResult($teamBestBall, $opponentBestBall);
                $totalPoints += $matchResult['points'];
                $matchesPlayed++;
            }

            $teamResults[$team->id] = [
                'team_id' => $team->id,
                'points' => round($totalPoints, 1),
                'matches_played' => $matchesPlayed,
                'total_score' => array_sum($teamBestBall), // Total strokes
                'best_ball_scores' => $teamBestBall,
                'position' => 0, // Will be set after sorting
            ];
        }

        // Sort teams by points (descending)
        uasort($teamResults, function($a, $b) {
            if ($b['points'] !== $a['points']) {
                return $b['points'] <=> $a['points'];
            }
            // Tiebreaker: lowest total score
            return $a['total_score'] <=> $b['total_score'];
        });

        // Assign positions
        $position = 1;
        foreach ($teamResults as &$result) {
            $result['position'] = $position++;
        }

        return $teamResults;
    }

    /**
     * Calculate best ball scores for a team (hole-by-hole)
     * Returns array of best scores for each hole
     */
    private function calculateTeamBestBall(Team $team, int $holes): array
    {
        $bestBallScores = array_fill(0, $holes, 999); // Initialize with high values

        // Get scores for both team members
        foreach ($team->members as $member) {
            $playerScores = Score::where('tournament_entry_id', $member->id)
                ->orderBy('hole_number')
                ->pluck('strokes', 'hole_number')
                ->toArray();

            // For each hole, keep the lower score (best ball)
            for ($hole = 1; $hole <= $holes; $hole++) {
                if (isset($playerScores[$hole])) {
                    $bestBallScores[$hole - 1] = min(
                        $bestBallScores[$hole - 1],
                        $playerScores[$hole]
                    );
                }
            }
        }

        // Replace 999s with null if no score recorded
        return array_map(function($score) {
            return $score === 999 ? null : $score;
        }, $bestBallScores);
    }

    /**
     * Calculate match play result for one team vs another
     * Each hole won = 1 point, halved = 0.5 points each
     */
    private function calculateMatchResult(array $team1Scores, array $team2Scores): array
    {
        $team1Points = 0;
        $holesWon = 0;
        $holesLost = 0;
        $holesHalved = 0;

        $holes = min(count($team1Scores), count($team2Scores));

        for ($i = 0; $i < $holes; $i++) {
            $score1 = $team1Scores[$i];
            $score2 = $team2Scores[$i];

            // Skip holes where either team has no score
            if ($score1 === null || $score2 === null) {
                continue;
            }

            if ($score1 < $score2) {
                // Team 1 wins the hole
                $team1Points += 1;
                $holesWon++;
            } elseif ($score2 < $score1) {
                // Team 1 loses the hole
                $holesLost++;
            } else {
                // Hole is halved
                $team1Points += 0.5;
                $holesHalved++;
            }
        }

        return [
            'points' => $team1Points,
            'holes_won' => $holesWon,
            'holes_lost' => $holesLost,
            'holes_halved' => $holesHalved,
        ];
    }

    /**
     * Get detailed match play report for a team
     */
    public function getTeamMatchReport(Team $team, int $holes): array
    {
        $bestBallScores = $this->calculateTeamBestBall($team, $holes);
        
        return [
            'team_id' => $team->id,
            'team_name' => $team->name,
            'best_ball_scores' => $bestBallScores,
            'total_strokes' => array_sum(array_filter($bestBallScores)),
            'holes_completed' => count(array_filter($bestBallScores, fn($s) => $s !== null)),
        ];
    }
}
