<?php

declare(strict_types=1);

use Zuno\Migration\Migration;

final class User extends Migration
{
    // Define the change method, which is used to define the changes to the database schema
    public function change(): void
    {
        $this->table('users')
            ->addColumn('name', 'string', ['limit' => 50])
            ->addColumn('email', 'string', ['limit' => 100])
            ->addColumn('password', 'string', ['limit' => 260])
            ->addColumn('remember_token', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('created_at', 'timestamp', ['null' => true])
            ->addColumn('updated_at', 'timestamp', ['null' => true])
            ->addIndex(['email'], ['unique' => true])
            ->create();
    }
}
