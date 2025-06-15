<?php
require_once __DIR__ . '/config.php';

class Database {
    private static $connection = null;

    public static function connect() {
        if (self::$connection === null) {
            try {
                $host = Config::DB_HOST();
                $port = Config::DB_PORT();
                $dbname = Config::DB_NAME();
                $user = Config::DB_USER();
                $password = Config::DB_PASSWORD();

                $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

                $sslCaPath = __DIR__ . '/../certs/ca-certificate.crt'; // ✅ Fixed the path

                if (!file_exists($sslCaPath)) {
                    error_log("❌ SSL CA certificate not found at: $sslCaPath");
                    die("SSL certificate missing. Check path or upload the file.");
                }

                $options = [
                    PDO::MYSQL_ATTR_SSL_CA => $sslCaPath,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ];

                // 🔍 Debug: Print sanitized connection info
                error_log("📡 Attempting DB connection...");
                error_log("Host: $host");
                error_log("Port: $port");
                error_log("DB Name: $dbname");
                error_log("User: $user");

                self::$connection = new PDO($dsn, $user, $password, $options);

                error_log("✅ DB connection successful.");
            } catch (PDOException $e) {
                error_log("❌ PDO Exception: " . $e->getMessage());
                die("Database connection failed. Please check logs or try again later.");
            } catch (Exception $e) {
                error_log("❌ General Exception: " . $e->getMessage());
                die("An unexpected error occurred.");
            }
        }

        return self::$connection;
    }
}
?>
