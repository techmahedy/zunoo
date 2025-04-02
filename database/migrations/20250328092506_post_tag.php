<?php

declare(strict_types=1);

use Zuno\Migration\Migration;

final class PostTag extends Migration
{
    // Define the change method, which is used to define the changes to the database schema
    public function up(): void
    {
        $this->table('post_tag')
            ->addColumn('post_id', 'biginteger')
            ->addColumn('tag_id', 'biginteger')
            ->addColumn('created_at', 'timestamp', ['null' => true])
            ->addColumn('updated_at', 'timestamp', ['null' => true])
            ->create();
    }

    public function down()
    {
        $this->table('post_tag')->drop()->save();
    }
}
