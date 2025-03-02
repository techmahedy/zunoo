<?php

declare(strict_types=1);

use Zuno\Migration\Migration;

final class User extends Migration
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
        $this->table('users')
            ->addColumn('username', 'string', ['limit' => 20])
            ->addColumn('password', 'string', ['limit' => 60])
            ->addColumn('email', 'string', ['limit' => 100])
            ->addColumn('first_name', 'string', ['limit' => 30])
            ->addColumn('last_name', 'string', ['limit' => 30])
            ->addTimestamps()
            ->addIndex(['username', 'email'], ['unique' => true])
            ->create();
    }
}
