<?php
require '../vendor/autoload.php';

require_once __DIR__ . '/./dao/config.php';
require_once __DIR__ . '/./services/UserService.php';
require_once __DIR__ . '/./services/AccommodationService.php';
require_once __DIR__ . '/./services/BookingService.php';
require_once __DIR__ . '/./services/PaymentService.php';
require_once __DIR__ . '/./services/ContactMessageService.php';
require_once __DIR__ . '/./services/AuthService.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Register services to Flight container
Flight::register('userService', 'UserService');
Flight::register('accommodationService', 'AccommodationService');
Flight::register('bookingService', 'BookingService');
Flight::register('paymentService', 'PaymentService');
Flight::register('contactMessageService', 'ContactMessageService');
Flight::register('auth_service', 'AuthService');

// JWT Middleware (protect all except /auth)
Flight::route('/*', function () {
    $path = Flight::request()->url;

    if (
        strpos($path, '/auth/login') === 0 ||
        strpos($path, '/auth/register') === 0
    ) {
        return TRUE;
    }

    $token = Flight::request()->getHeader("Authentication");
    if (!$token) {
        Flight::halt(401, "Missing authentication header");
    }

    try {
        $decoded = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));
        Flight::set('user', $decoded->user);
        Flight::set('jwt_token', $token);
    } catch (Exception $e) {
        Flight::halt(401, "Invalid or expired token: " . $e->getMessage());
    }
});

// Load routes
require_once __DIR__ . '/./routes/UserRoutes.php';
require_once __DIR__ . '/./routes/AccommodationRoutes.php';
require_once __DIR__ . '/./routes/BookingRoutes.php';
require_once __DIR__ . '/./routes/PaymentRoutes.php';
require_once __DIR__ . '/./routes/ContactRoutes.php';
require_once __DIR__ . '/./routes/AuthRoutes.php'; // ✅ Include authentication routes

Flight::start();
