<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoload dependencies via Composer
require 'vendor/autoload.php';

// Load configuration and services
require_once __DIR__ . '/dao/config.php';
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/services/AccommodationService.php';
require_once __DIR__ . '/services/BookingService.php';
require_once __DIR__ . '/services/PaymentService.php';
require_once __DIR__ . '/services/ContactMessageService.php';
require_once __DIR__ . '/services/AuthService.php';

// Load middleware and roles
require_once __DIR__ . '/middleware/AuthMiddleware.php';
require_once __DIR__ . '/data/Roles.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Register services to Flight
Flight::register('userService', 'UserService');
Flight::register('accommodationService', 'AccommodationService');
Flight::register('bookingService', 'BookingService');
Flight::register('paymentService', 'PaymentService');
Flight::register('contactMessageService', 'ContactMessageService');
Flight::register('auth_service', 'AuthService');
Flight::register('auth_middleware', 'AuthMiddleware');


Flight::before('start', function (&$params, &$output) {
    $path = Flight::request()->url;

    // Allow public auth routes
    if (
        strpos($path, '/auth/login') === 0 ||
        strpos($path, '/auth/register') === 0 ||
        preg_match('#^/accommodations($|/)#', $path) ||
        strpos($path, '/contacts') === 0 ||
        preg_match('#^/contacts($|/)#', $path) ||
        preg_match('#^/bookings($|/)#', $path)

    ) {
        return; 
    }

    $headers = getallheaders();
    $token = $headers['Authorization'] ?? $headers['authorization'] ?? null;

    if (!$token) {
        Flight::halt(401, "Missing authentication header");
    }

    try {
        Flight::auth_middleware()->verifyToken($token);
    } catch (Exception $e) {
        Flight::halt(401, "Authentication failed: " . $e->getMessage());
    }
});

// Load route files 
require_once __DIR__ . '/routes/UserRoutes.php';
require_once __DIR__ . '/routes/AccommodationRoutes.php';
require_once __DIR__ . '/routes/BookingRoutes.php';
require_once __DIR__ . '/routes/PaymentRoutes.php';
require_once __DIR__ . '/routes/ContactRoutes.php';
require_once __DIR__ . '/routes/AuthRoutes.php';

// Start the Flight engine
Flight::start();
