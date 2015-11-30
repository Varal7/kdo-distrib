<?php
$db = new SQLite3('gifts.db');

$db->exec("CREATE TABLE IF NOT EXISTS users (
    `id`        INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE,
    `firstname` TEXT UNIQUE,
    `hash`      TEXT UNIQUE,
    `target`    INTEGE
)");
?>
