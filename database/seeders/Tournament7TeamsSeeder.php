<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Score;
use App\Models\CourseHole;
use App\Models\User;

class Tournament7TeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // Try to find tournament id 7, otherwise create a minimal one
            $tournament = Tournament::find(7);

            if (! $tournament) {
                $tournament = Tournament::create([
                    'name' => 'Seeded Tournament 7',
                    'description' => 'Auto-seeded tournament for testing flights and leaderboards',
                    'start_date' => now()->toDateString(),
                    'end_date' => now()->toDateString(),
                    'holes' => 18,
                    'format' => 'scramble',
                    'team_size' => 4,
                    'status' => 'upcoming',
                ]);
            }

            $tournamentId = $tournament->id;

            // Determine hole count and pars from linked course if available
            $holeCount = $tournament->holes ?? ($tournament->course?->hole_count ?? 18);
            $courseHoles = [];
            if ($tournament->course) {
                $tournament->course->load('holes');
                foreach ($tournament->course->holes as $ch) {
                    $courseHoles[$ch->hole_number] = $ch->par;
                }
            }

            // Get or create a seed user to be captain for all teams
            $captain = User::firstOrCreate(
                ['email' => 'seed-captain@scgolf.com'],
                [
                    'name' => 'Seed Captain',
                    'password' => bcrypt('password'),
                    'handicap' => 15,
                ]
            );

            // Remove existing teams (and cascade delete scores)
            Team::where('tournament_id', $tournamentId)->delete();

            // Create 18 teams with deterministic score patterns so ties/variation appear
            for ($t = 1; $t <= 18; $t++) {
                $team = Team::create([
                    'name' => "Seed Team {$t}",
                    'tournament_id' => $tournamentId,
                    'captain_id' => $captain->id,
                    'registered_at' => now(),
                ]);

                for ($h = 1; $h <= $holeCount; $h++) {
                    $par = $courseHoles[$h] ?? 4;

                    // More varied scoring pattern to create different totals and better flight separation
                    $baseAdjustment = ($t % 5) - 2; // Teams get -2, -1, 0, +1, +2 base adjustments
                    $holeVariation = (($h + $t) % 3) - 1; // Per-hole variation: -1, 0, +1
                    $strokes = $par + $baseAdjustment + $holeVariation;
                    
                    // Ensure realistic minimum score
                    if ($strokes < 1) {
                        $strokes = 1;
                    }

                    Score::create([
                        'team_id' => $team->id,
                        'tournament_entry_id' => null,
                        'hole_number' => $h,
                        'strokes' => $strokes,
                        'par' => $par,
                        'notes' => null,
                    ]);
                }
            }

            $this->command->info("Seeded 18 teams with {$holeCount} hole scores for tournament id {$tournamentId}.");
        });
    }
}
