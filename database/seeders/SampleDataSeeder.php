<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tournament;
use App\Models\TournamentEntry;
use App\Models\Score;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create sample users
        $users = [
            [
                'name' => 'John Smith',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'phone' => '555-0101',
                'handicap' => 12,
                'home_course' => 'Pebble Beach Golf Links'
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@example.com',
                'password' => Hash::make('password'),
                'phone' => '555-0102',
                'handicap' => 8,
                'home_course' => 'Augusta National Golf Club'
            ],
            [
                'name' => 'Mike Wilson',
                'email' => 'mike@example.com',
                'password' => Hash::make('password'),
                'phone' => '555-0103',
                'handicap' => 15,
                'home_course' => 'St. Andrews Links'
            ],
            [
                'name' => 'Lisa Brown',
                'email' => 'lisa@example.com',
                'password' => Hash::make('password'),
                'phone' => '555-0104',
                'handicap' => 6,
                'home_course' => 'Oakmont Country Club'
            ]
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        // Create sample tournaments
        $tournaments = [
            [
                'name' => 'Spring Championship 2025',
                'description' => 'Annual spring golf tournament featuring 18 holes of challenging play.',
                'start_date' => '2025-10-26',
                'end_date' => '2025-10-26',
                'holes' => 18,
                'entry_fee' => 75.00,
                'max_participants' => 32,
                'status' => 'active'
            ],
            [
                'name' => 'Weekend Warriors Cup',
                'description' => 'A fun 9-hole tournament for weekend golfers.',
                'start_date' => '2025-11-02',
                'end_date' => '2025-11-02',
                'holes' => 9,
                'entry_fee' => 35.00,
                'max_participants' => 20,
                'status' => 'upcoming'
            ],
            [
                'name' => 'October Classic',
                'description' => 'Completed tournament from last month.',
                'start_date' => '2025-09-15',
                'end_date' => '2025-09-15',
                'holes' => 18,
                'entry_fee' => 50.00,
                'max_participants' => 24,
                'status' => 'completed'
            ]
        ];

        foreach ($tournaments as $tournamentData) {
            Tournament::create($tournamentData);
        }

        // Register users for tournaments
        $tournament1 = Tournament::where('name', 'Spring Championship 2025')->first();
        $tournament3 = Tournament::where('name', 'October Classic')->first();
        
        $allUsers = User::all();

        // Register all users for the active tournament
        foreach ($allUsers as $user) {
            TournamentEntry::create([
                'tournament_id' => $tournament1->id,
                'user_id' => $user->id,
                'handicap' => $user->handicap,
                'registered_at' => now()->subDays(2),
                'checked_in' => true
            ]);
        }

        // Register users for completed tournament and add scores
        foreach ($allUsers as $user) {
            $entry = TournamentEntry::create([
                'tournament_id' => $tournament3->id,
                'user_id' => $user->id,
                'handicap' => $user->handicap,
                'registered_at' => now()->subDays(30),
                'checked_in' => true
            ]);

            // Add complete scorecard for each player
            $totalScore = 0;
            for ($hole = 1; $hole <= 18; $hole++) {
                $par = $this->getDefaultPar($hole);
                $strokes = $this->generateRealisticScore($par, $user->handicap);
                $totalScore += $strokes;

                Score::create([
                    'tournament_entry_id' => $entry->id,
                    'hole_number' => $hole,
                    'strokes' => $strokes,
                    'par' => $par,
                    'notes' => $strokes < $par ? 'Great shot!' : ($strokes > $par + 1 ? 'Tough hole' : null)
                ]);
            }
        }

        // Add partial scores for active tournament
        $activeEntries = TournamentEntry::where('tournament_id', $tournament1->id)->get();
        foreach ($activeEntries->take(2) as $entry) {
            // Add scores for first 9 holes
            for ($hole = 1; $hole <= 9; $hole++) {
                $par = $this->getDefaultPar($hole);
                $strokes = $this->generateRealisticScore($par, $entry->user->handicap);

                Score::create([
                    'tournament_entry_id' => $entry->id,
                    'hole_number' => $hole,
                    'strokes' => $strokes,
                    'par' => $par
                ]);
            }
        }
    }

    private function getDefaultPar($hole)
    {
        // Typical par distribution for 18 holes
        $parLayout = [4, 4, 3, 5, 4, 4, 3, 4, 5, 4, 4, 3, 5, 4, 4, 3, 4, 4];
        return $parLayout[$hole - 1] ?? 4;
    }

    private function generateRealisticScore($par, $handicap)
    {
        // Generate realistic scores based on par and handicap
        $baseScore = $par;
        
        // Adjust for handicap (lower handicap = better scores)
        $handicapFactor = ($handicap - 10) / 10; // Normalize around handicap 10
        
        // Add some randomness
        $random = rand(-2, 3);
        
        // Calculate final score
        $score = $baseScore + $handicapFactor + $random;
        
        // Ensure minimum of 1 and reasonable maximum
        return max(1, min($score, $par + 4));
    }
}
