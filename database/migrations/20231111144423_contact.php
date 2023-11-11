<?php

declare(strict_types=1);

use App\Core\Migration\Migration;

final class Contact extends Migration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('posts');

        $table->addColumn('title', 'string', ['limit' => 20])
            ->addColumn('body', 'text')
            ->addColumn('cover_image', 'string')
            ->addTimestamps()
            ->addIndex(['title'], ['unique' => true]);

        $table->create();
    }
}
