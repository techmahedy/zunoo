<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class CommentSeeder extends AbstractSeed
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
                'comment' => fake()->title(),
                'user_id' => 1,
                'post_id' => 1
            ],
            [
                'comment' => fake()->title(),
                'user_id' => 2,
                'post_id' => 2
            ],
            [
                'comment' => fake()->title(),
                'user_id' => 1,
                'post_id' => 1
            ],
        ];

        $this->table('comment')
            ->insert($data)
            ->saveData();
    }
}
