<?php

declare(strict_types=1);

use Zuno\Migration\Migration;

final class User extends Migration
{
    /**
     * Define the up method, which is used to define the changes to the database schema.
     * This method creates a new table with timestamp columns for creation and update times.
     */
    public function up(): void
    {
        $this->table('user')
            ->addColumn('name', 'string', ['limit' => 50])
            ->addColumn('email', 'string', ['limit' => 50])
            ->addColumn('password', 'string', ['limit' => 100])
            ->addColumn('remember_token', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('created_at', 'timestamp', ['null' => true])
            ->addColumn('updated_at', 'timestamp', ['null' => true])
            ->addIndex(['email'], ['unique' => true])
            ->create();
    }

    /**
     * Define the down method, which reverses the changes made by the up method.
     * This method drops the table created in the up method.
     */
    public function down()
    {
        $this->table('user')->drop()->save();
    }
}
