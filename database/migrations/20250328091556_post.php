<?php

declare(strict_types=1);

use Zuno\Migration\Migration;

final class Post extends Migration
{
    public function up(): void
    {
        $this->table('post')
            ->addColumn('title', 'string', ['limit' => 150])
            ->addColumn('user_id', 'biginteger')
            ->addColumn('created_at', 'timestamp', ['null' => true])
            ->addColumn('updated_at', 'timestamp', ['null' => true])
            ->create();
    }

    public function down()
    {
        $this->table('post')->drop()->save();
    }
}
