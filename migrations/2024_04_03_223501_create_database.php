<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Migrations\Migration;
use Hyperf\DbConnection\Db;

class CreateDatabase extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
        CREATE SEQUENCE notifications_id_seq START 1;

        CREATE TABLE "notifications" (
            id INTEGER DEFAULT nextval(\'notifications_id_seq\') PRIMARY KEY,
            user_id VARCHAR NOT NULL,
            application_id VARCHAR NOT NULL,
            message VARCHAR NOT NULL
        );
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Db::unprepared('
        DROP SEQUENCE [IF EXISTS] notifications_id_seq;
        DROP TABLE IF EXISTS "notifications";
       ');
    }
}
