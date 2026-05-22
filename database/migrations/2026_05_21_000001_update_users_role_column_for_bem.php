<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            DB::unprepared(<<<'SQL'
PRAGMA foreign_keys=off;

CREATE TABLE users_new (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    name VARCHAR NOT NULL,
    nim VARCHAR NOT NULL UNIQUE,
    jurusan VARCHAR NOT NULL,
    prodi VARCHAR NOT NULL,
    password VARCHAR NOT NULL,
    role VARCHAR NOT NULL DEFAULT 'user',
    remember_token VARCHAR,
    created_at DATETIME,
    updated_at DATETIME
);

INSERT INTO users_new (id, name, nim, jurusan, prodi, password, role, remember_token, created_at, updated_at)
SELECT id, name, nim, jurusan, prodi, password, role, remember_token, created_at, updated_at
FROM users;

DROP TABLE users;
ALTER TABLE users_new RENAME TO users;

PRAGMA foreign_keys=on;
SQL);

            return;
        }

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE users MODIFY role VARCHAR(255) NOT NULL DEFAULT 'user'");
            return;
        }

        if ($driver === 'pgsql') {
            DB::statement("ALTER TABLE users ALTER COLUMN role TYPE VARCHAR(255) USING role::varchar(255)");
            DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'user'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            DB::unprepared(<<<'SQL'
PRAGMA foreign_keys=off;

CREATE TABLE users_old (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    name VARCHAR NOT NULL,
    nim VARCHAR NOT NULL UNIQUE,
    jurusan VARCHAR NOT NULL,
    prodi VARCHAR NOT NULL,
    password VARCHAR NOT NULL,
    role VARCHAR NOT NULL DEFAULT 'user' CHECK(role IN ('admin', 'user')),
    remember_token VARCHAR,
    created_at DATETIME,
    updated_at DATETIME
);

INSERT INTO users_old (id, name, nim, jurusan, prodi, password, role, remember_token, created_at, updated_at)
SELECT id, name, nim, jurusan, prodi, password, role, remember_token, created_at, updated_at
FROM users;

DROP TABLE users;
ALTER TABLE users_old RENAME TO users;

PRAGMA foreign_keys=on;
SQL);

            return;
        }

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'user') NOT NULL DEFAULT 'user'");
            return;
        }

        if ($driver === 'pgsql') {
            DB::statement("ALTER TABLE users ALTER COLUMN role TYPE VARCHAR(255) USING role::varchar(255)");
            DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'user'");
        }
    }
};
