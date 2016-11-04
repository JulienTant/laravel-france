<?php

use Illuminate\Database\Migrations\Migration;

class MovingToUtf8mb4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $default = config("database.default");
        $db = config("database.connections." . $default . ".database");
        DB::unprepared('ALTER DATABASE ' . $db . ' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');


        DB::unprepared('ALTER TABLE `failed_jobs` CHANGE `failed_at` `failed_at` TIMESTAMP  NULL;');
        DB::unprepared('ALTER TABLE `failed_jobs` CHANGE `connection` `connection` TEXT  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NOT NULL;');
        DB::unprepared('ALTER TABLE `failed_jobs` CHANGE `queue` `queue` TEXT  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NOT NULL;');
        DB::unprepared('ALTER TABLE `failed_jobs` CHANGE `payload` `payload` LONGTEXT  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NOT NULL;');


        DB::unprepared('ALTER TABLE `forums_categories` 
CHANGE `created_at` `created_at` TIMESTAMP  NULL,
CHANGE `updated_at` `updated_at` TIMESTAMP  NULL;
');
        DB::unprepared("ALTER TABLE `forums_categories` CHANGE `name` `name` VARCHAR(191)  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NOT NULL  DEFAULT '';");
        DB::unprepared("ALTER TABLE `forums_categories` CHANGE `slug` `slug` VARCHAR(191)  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NOT NULL  DEFAULT '';");
        DB::unprepared("ALTER TABLE `forums_categories` CHANGE `background_color` `background_color` VARCHAR(191)  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NOT NULL  DEFAULT '';");
        DB::unprepared("ALTER TABLE `forums_categories` CHANGE `font_color` `font_color` VARCHAR(191)  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NOT NULL  DEFAULT '';");
        DB::unprepared("ALTER TABLE `forums_categories` CHANGE `description` `description` TEXT  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NULL;");


        DB::unprepared('ALTER TABLE `forums_messages` 
CHANGE `created_at` `created_at` TIMESTAMP  NULL,
CHANGE `updated_at` `updated_at` TIMESTAMP  NULL;
');
        DB::unprepared('ALTER TABLE `forums_messages` CHANGE `markdown` `markdown` TEXT  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NOT NULL;');



        DB::unprepared('ALTER TABLE `forums_topics` 
CHANGE `created_at` `created_at` TIMESTAMP  NULL,
CHANGE `updated_at` `updated_at` TIMESTAMP  NULL;
');

        DB::unprepared("ALTER TABLE `forums_topics` CHANGE `title` `title` VARCHAR(191)  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NOT NULL  DEFAULT '';");
        DB::unprepared("ALTER TABLE `forums_topics` CHANGE `slug` `slug` VARCHAR(191)  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NOT NULL  DEFAULT '';");


        DB::unprepared('ALTER TABLE `users` 
CHANGE `created_at` `created_at` TIMESTAMP  NULL,
CHANGE `updated_at` `updated_at` TIMESTAMP  NULL;
');

        DB::unprepared("ALTER TABLE `users` CHANGE `username` `username` VARCHAR(191)  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NOT NULL  DEFAULT '';");
        DB::unprepared("ALTER TABLE `users` CHANGE `email` `email` VARCHAR(191)  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NOT NULL  DEFAULT '';");
        DB::unprepared("ALTER TABLE `users` CHANGE `remember_token` `remember_token` VARCHAR(191)  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NOT NULL  DEFAULT '';");
        DB::unprepared("ALTER TABLE `users` CHANGE `groups` `groups` TEXT  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NOT NULL  DEFAULT '';");
        DB::unprepared("ALTER TABLE `users` CHANGE `forums_preferences` `forums_preferences` TEXT  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NOT NULL  DEFAULT '';");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $default = config("database.default");
        $db = config("database.connections." . $default . ".database");
        DB::unprepared('ALTER DATABASE ' . $db . ' CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        DB::unprepared('ALTER TABLE `failed_jobs` CHANGE `connection` `connection` TEXT  CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL');
        DB::unprepared('ALTER TABLE `failed_jobs` CHANGE `queue` `queue` TEXT  CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL');
        DB::unprepared('ALTER TABLE `failed_jobs` CHANGE `payload` `payload` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL');

        DB::unprepared("ALTER TABLE `forums_categories` CHANGE `name` `name` VARCHAR(255)  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NOT NULL  DEFAULT '';");
        DB::unprepared("ALTER TABLE `forums_categories` CHANGE `slug` `slug` VARCHAR(255)  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NOT NULL  DEFAULT '';");
        DB::unprepared("ALTER TABLE `forums_categories` CHANGE `background_color` `background_color` VARCHAR(255)  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NOT NULL  DEFAULT '';");
        DB::unprepared("ALTER TABLE `forums_categories` CHANGE `font_color` `font_color` VARCHAR(255)  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NOT NULL  DEFAULT '';");
        DB::unprepared("ALTER TABLE `forums_categories` CHANGE `description` `description` TEXT  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL;");

    }
}
