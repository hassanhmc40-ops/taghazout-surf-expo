<?php

class Config {
    private static string $host = 'localhost';
    private static string $dbName = 'taghazout_surf';
    private static string $user = 'root';
    private static string $pass = '';

    public static function getHost(): string {
        return self::$host;
    }

    public static function getDbName(): string {
        return self::$dbName;
    }

    public static function getUser(): string {
        return self::$user;
    }

    public static function getPass(): string {
        return self::$pass;
    }
}