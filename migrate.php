<?php

$db = new PDO('sqlite:data.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$db->exec('CREATE TABLE IF NOT EXISTS posts(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    deleted_at TIMESTAMP
)');

$db->exec('CREATE TABLE IF NOT EXISTS post_versions(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    post_id INTEGER,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
)');

$db->exec('CREATE TABLE IF NOT EXISTS post_contents(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    post_id INTEGER,
    version_id INTEGER,
    fragment VARCHAR(1000),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
)');
