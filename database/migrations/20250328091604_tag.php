<?php

declare(strict_types=1);

use Zuno\Migration\Migration;

final class Tag extends Migration
{
    // Define the change method, which is used to define the changes to the database schema
    public function up(): void
    {
        $this->table('tag')
            ->addColumn('name', 'string', ['limit' => 50])
            ->addColumn('created_at', 'timestamp', ['null' => true])
            ->addColumn('updated_at', 'timestamp', ['null' => true])
            ->create();
    }

    public function down()
    {
        $this->table('tag')->drop()->save();
    }
}
