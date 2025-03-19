<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

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
                'name' => fake()->name(),
                'email' => 'hello@zuno.com',
                'password' => '$argon2id$v=19$m=65536,t=4,p=1$YUhEMzAycmJ3QnkyWFpVbQ$22mqZRiUoSDBehig20+GLjRpYQmQBIqQ41Y/Mhtde7k' // password
            ]
        ];

        $user = $this->table('users');
        $user->insert($data)->saveData();
    }
}
