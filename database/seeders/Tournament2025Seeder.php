<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tournament;
use Carbon\Carbon;

class Tournament2025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing 2025 tournaments
        Tournament::whereYear('start_date', 2025)->delete();

        $tournaments = [
            [
                'name' => 'Home on the Range 4-Person',
                'start_date' => Carbon::parse('2025-04-19'), // TBD - using placeholder date
                'end_date' => Carbon::parse('2025-04-19'),
                'holes' => 18,
                'entry_fee' => 50.00,
                'max_participants' => 120, // 30 teams x 4
                'description' => 'Start the season with our Home on the Range tournament! 4-Person Scramble format.',
                'status' => 'upcoming',
            ],
            [
                'name' => '18 Hole 3-Man',
                'start_date' => Carbon::parse('2025-05-24'),
                'end_date' => Carbon::parse('2025-05-24'),
                'holes' => 18,
                'entry_fee' => 45.00,
                'max_participants' => 90, // 30 teams x 3
                'description' => 'Three-man team competition across 18 holes.',
                'status' => 'upcoming',
            ],
            [
                'name' => 'Women\'s 2-Lady Scramble',
                'start_date' => Carbon::parse('2025-06-07'),
                'end_date' => Carbon::parse('2025-06-07'),
                'holes' => 18,
                'entry_fee' => 40.00,
                'max_participants' => 48, // 24 teams x 2
                'description' => 'Ladies-only two-person scramble tournament.',
                'status' => 'upcoming',
            ],
            [
                'name' => 'Par 3 1-Man Scramble',
                'start_date' => Carbon::parse('2025-07-04'),
                'end_date' => Carbon::parse('2025-07-04'),
                'holes' => 9,
                'entry_fee' => 30.00,
                'max_participants' => 40,
                'description' => 'Independence Day individual scramble on our par 3 course.',
                'status' => 'upcoming',
            ],
            [
                'name' => '2-Day, 2-Man',
                'start_date' => Carbon::parse('2025-07-19'),
                'end_date' => Carbon::parse('2025-07-20'),
                'holes' => 18,
                'entry_fee' => 60.00,
                'max_participants' => 60, // 30 teams x 2
                'description' => 'Two-day tournament for two-man teams running July 19-20.',
                'status' => 'upcoming',
            ],
            [
                'name' => 'Couples',
                'start_date' => Carbon::parse('2025-08-02'),
                'end_date' => Carbon::parse('2025-08-02'),
                'holes' => 18,
                'entry_fee' => 50.00,
                'max_participants' => 48, // 24 teams x 2
                'description' => 'Couples tournament - bring your partner!',
                'status' => 'upcoming',
            ],
            [
                'name' => '4-Man Scramble',
                'start_date' => Carbon::parse('2025-08-23'),
                'end_date' => Carbon::parse('2025-08-23'),
                'holes' => 18,
                'entry_fee' => 50.00,
                'max_participants' => 120, // 30 teams x 4
                'description' => 'Classic four-man scramble format.',
                'status' => 'upcoming',
            ],
            [
                'name' => 'Labor Day Shootout 1-Man Scramble',
                'start_date' => Carbon::parse('2025-09-01'),
                'end_date' => Carbon::parse('2025-09-01'),
                'holes' => 18,
                'entry_fee' => 35.00,
                'max_participants' => 40,
                'description' => 'Labor Day individual scramble tournament.',
                'status' => 'upcoming',
            ],
            [
                'name' => 'Bargman Open 1-Man',
                'start_date' => Carbon::parse('2025-09-28'),
                'end_date' => Carbon::parse('2025-09-28'),
                'holes' => 18,
                'entry_fee' => 40.00,
                'max_participants' => 40,
                'description' => 'Season finale individual tournament.',
                'status' => 'upcoming',
            ],
        ];

        foreach ($tournaments as $tournament) {
            Tournament::create($tournament);
        }

        $this->command->info('2025 Tournament Schedule created successfully!');
    }
}
