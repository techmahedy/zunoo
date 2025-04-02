<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class PostSeeder extends AbstractSeed
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
                'title' => fake()->word(),
                'user_id' => 1
            ],
            [
                'title' => fake()->word(),
                'user_id' => 2
            ],
            [
                'title' => fake()->word(),
                'user_id' => 2
            ],
        ];

        $this->table('post')
            ->insert($data)
            ->saveData();
    }
}
