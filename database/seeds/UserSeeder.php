<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;
use App\Models\User;

class UserSeeder extends AbstractSeed
{
    /**
     * Write your database seeder
     */
    public function run(): void
    {
        User::create([
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => bcrypt('password')
        ]);
    }
}
