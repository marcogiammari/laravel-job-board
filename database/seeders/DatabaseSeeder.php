<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Employer;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Marco Giammari',
            'email' => 'marco@mail.com',
        ]);

        User::factory(300)->create();
        $users = User::all()->shuffle();

        for ($i = 0; $i < 20; $i++) {
            Employer::factory()->create([
                // pop estrae e cancella uno user da $user
                // in questo modo siamo sicuri che non ci siano più employer associati allo stesso user 
                'user_id' => $users->pop()->id
            ]);
        }

        $employers = Employer::all();

        for ($i = 0; $i < 100; $i++) {
            Job::factory()->create([
                // qui usiamo random() perché va bene che un employer offra più lavori
                'employer_id' => $employers->random()
            ]);
        }

        foreach ($users as $user) {
            // prende da 0 a 4 lavori in ordine casuale
            $jobs = Job::inRandomOrder()->take(rand(0, 4))->get();

            foreach ($jobs as $job) {
                JobApplication::factory()->create([
                    'job_id' => $job->id,
                    'user_id' => $user->id
                ]);
            }
        }
    }
}
