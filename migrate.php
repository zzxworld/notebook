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
$db->exec('CREATE INDEX IF NOT EXISTS idx_deleted ON posts (deleted_at)');

$db->exec('CREATE TABLE IF NOT EXISTS post_versions(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    post_id INTEGER,
    created_at TIMESTAMP
)');
$db->exec('CREATE INDEX IF NOT EXISTS idx_post ON post_versions (post_id)');

$db->exec('CREATE TABLE IF NOT EXISTS post_contents(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    post_id INTEGER,
    version_id INTEGER,
    fragment VARCHAR(512)
)');
$db->exec('CREATE INDEX IF NOT EXISTS idx_post_content on post_contents (post_id, version_id)');
