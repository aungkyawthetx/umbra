<?php

class Database
{
    public static function connect()
    {
        $config = require __DIR__ . '/../../config/database.php';

        return new PDO(
            "mysql:host={$config['host']};dbname={$config['dbname']}",
            $config['user'],
            $config['pass'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
}
