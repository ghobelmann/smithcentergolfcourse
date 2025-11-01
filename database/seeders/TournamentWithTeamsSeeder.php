<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\User;
use App\Models\TournamentEntry;
use Carbon\Carbon;

class TournamentWithTeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test tournament
        $tournament = Tournament::create([
            'name' => '2025 Test Scramble Tournament',
            'description' => 'Test tournament with 30 teams for card assignment testing',
            'format' => 'scramble',
            'team_size' => 2,
            'start_date' => Carbon::now()->addDays(7),
            'end_date' => Carbon::now()->addDays(7),
            'entry_fee' => 50.00,
            'max_participants' => 60, // 30 teams x 2 players each
            'holes' => 18,
            'status' => 'upcoming'
        ]);

        // Create 60 users (30 teams x 2 players each) or use existing ones
        $users = [];
        for ($i = 1; $i <= 60; $i++) {
            $email = "testplayer$i@scramble.test";
            $user = User::where('email', $email)->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => "Test Player $i",
                    'email' => $email,
                    'email_verified_at' => now(),
                    'password' => bcrypt('password123'),
                    'handicap' => rand(5, 25),
                ]);
            }
            
            $users[] = $user;
        }

        // Create 30 teams with 2 players each
        for ($teamNum = 1; $teamNum <= 30; $teamNum++) {
            $team = Team::create([
                'name' => "Team $teamNum",
                'tournament_id' => $tournament->id,
                'captain_id' => $users[($teamNum - 1) * 2]->id,
                'entry_fee_paid' => 50.00,
                'checked_in' => rand(0, 1) == 1,
                'registered_at' => Carbon::now()->subDays(rand(1, 20)),
            ]);

            // Add 2 players to each team
            $player1 = $users[($teamNum - 1) * 2];
            $player2 = $users[($teamNum - 1) * 2 + 1];

            // Create team memberships
            $team->members()->attach([$player1->id, $player2->id]);

            // Create tournament entries for both players
            TournamentEntry::create([
                'tournament_id' => $tournament->id,
                'user_id' => $player1->id,
                'handicap' => $player1->handicap,
                'entry_fee_paid' => 25.00, // Split entry fee
                'checked_in' => rand(0, 1) == 1,
                'registered_at' => Carbon::now()->subDays(rand(1, 20)),
            ]);

            TournamentEntry::create([
                'tournament_id' => $tournament->id,
                'user_id' => $player2->id,
                'handicap' => $player2->handicap,
                'entry_fee_paid' => 25.00, // Split entry fee
                'checked_in' => rand(0, 1) == 1,
                'registered_at' => Carbon::now()->subDays(rand(1, 20)),
            ]);
        }

        $this->command->info("Created test tournament '{$tournament->name}' with 30 teams (60 players)");
        $this->command->info("Tournament ID: {$tournament->id}");
        $this->command->info("Visit: /tournaments/{$tournament->id} to test card assignments");
    }
}
