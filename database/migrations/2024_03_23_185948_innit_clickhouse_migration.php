<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $db = new ClickHouseDB\Client(config('database.connections.clickhouse'));

        $db->database('default');
        $db->write(
            'CREATE TABLE orders (
                uuid UUID,
                company_uuid UUID,
                user_uuid UUID,
                client_uuid UUID,
                action_id Int32,
                status_id Int32,
                type_id Int32,
                count Int32,
                created_at DateTime DEFAULT now(),
                updated_at DateTime DEFAULT now()
            ) ENGINE = MergeTree()
            ORDER BY (uuid);'
        );
        $db->write(
            'CREATE TABLE apps (
                uuid String,
                order_uuid UUID,
                company_uuid UUID,
                user_uuid UUID,
                client_uuid UUID,
                action_id Int32,
                status_id Int32,
                type_id Int32,
                order_weight Int32,
                created_at DateTime DEFAULT now(),
                updated_at DateTime DEFAULT now()
            ) ENGINE = MergeTree()
            ORDER BY (uuid);'
        );

        $db->write(
            'CREATE TABLE done_apps (
                uuid UUID,
                order_uuid UUID,
                user_uuid UUID,
                company_uuid UUID,
                action_id Int32,
                created_at DateTime DEFAULT now(),
                updated_at DateTime DEFAULT now()
            ) ENGINE = MergeTree()
            ORDER BY (uuid);'
        );

    }

    public function down(): void
    {

    }
};
