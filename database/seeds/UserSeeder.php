<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;
use Zuno\Auth\Security\Hash;

class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            [
                'username' => str_replace(' ', '_', fake()->name()),
                'email' => fake()->email(),
                'first_name' => fake()->word(),
                'last_name' => fake()->word(),
                'password' => Hash::make('password')
            ]
        ];

        // Truncate the table
        // $user->truncate();

        $user = $this->table('users');
        $user->insert($data)->saveData();
    }
}
