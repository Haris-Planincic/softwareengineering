<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED));
class Config {
    public static function DB_HOST() {
        return '127.0.0.1';
    }

    public static function DB_NAME() {
        return 'BooknStay';
    }

    public static function DB_USER() {
        return 'root';
    }

    public static function DB_PASSWORD() {
        return 'haris';
    }

    public static function JWT_SECRET() {
        return 'zlatka';
    }
}
?>
