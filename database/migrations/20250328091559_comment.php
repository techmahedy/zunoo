<?php

declare(strict_types=1);

use Zuno\Migration\Migration;

final class Comment extends Migration
{
    // Define the change method, which is used to define the changes to the database schema
    public function up(): void
    {
        $this->table('comment')
            ->addColumn('comment', 'string', ['limit' => 50])
            ->addColumn('user_id', 'biginteger')
            ->addColumn('post_id', 'biginteger')
            ->addColumn('created_at', 'timestamp', ['null' => true])
            ->addColumn('updated_at', 'timestamp', ['null' => true])
            ->create();
    }

    public function down()
    {
        $this->table('comment')->drop()->save();
    }
}
