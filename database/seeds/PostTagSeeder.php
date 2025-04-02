<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class PostTagSeeder extends AbstractSeed
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
                'post_id' => 1,
                'tag_id' => 1
            ],
            [
                'post_id' => 1,
                'tag_id' => 2
            ],
            [
                'post_id' => 2,
                'tag_id' => 3
            ],
            [
                'post_id' => 3,
                'tag_id' => 3
            ],
        ];

        $this->table('post_tag')
            ->insert($data)
            ->saveData();
    }
}
