<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Chirp;
use Illuminate\Database\Seeder;

class ChirpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::count() < 3 
            ? collect([
                User::create([
                    "name"=> "Alice dev",
                    "email"=> "allice@mail.com",
                    "password" => bcrypt("password"), 
                ]), 
                User::create([
                    "name"=> "Bob builder",
                    "email"=> "bob@mail.ccom",
                    "password"=> bcrypt("password"),
                ]),
                User::create([
                    "name"=> "Coder",
                    "email"=> "coder.mail.com",
                    "password"=> bcrypt("password"),
                ])

            ])
            : User::take(3)->get();

        
        $chirps = [ 
            'Just discovered Laravel - where has this been all my life? 🚀',
            'Building something cool with Chirper today!',
            'Laravel\'s Eloquent ORM is pure magic ✨',
            'Deployed my first app with Laravel Cloud. So smooth!',
            'Who else is loving Blade components?',
            'Friday deploys with Laravel? No problem! 😎',
        ];
        
        foreach ($chirps as $message) {
            $users->random()->chirps()->create([
                'message' => $message,
                'created_at' => now()->subMinutes(rand(5,1440)),
            ]);
        }

    }
}
