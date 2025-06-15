<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware {
    public function verifyToken($token){
    if (!$token)
        Flight::halt(401, "Missing authentication header");

    if (str_starts_with($token, "Bearer ")) {
        $token = substr($token, 7);
    }

    try {
        $decoded_token = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));
        Flight::set('user', $decoded_token->user);
        Flight::set('jwt_token', $token);
        error_log("Decoded user: " . json_encode($decoded_token->user));
        return TRUE;
    } catch (Exception $e) {
        Flight::halt(401, "Invalid or expired token: " . $e->getMessage());
    }
}


    public function authorizeRole($requiredRole) {
        $user = Flight::get('user');
        if (!$user || $user->role !== $requiredRole) {
            Flight::halt(403, 'Access denied: insufficient privileges');
        }
    }

    public function authorizeRoles($roles) {
        $user = Flight::get('user');
        if (!$user || !in_array($user->role, $roles)) {
            Flight::halt(403, 'Forbidden: role not allowed');
        }
    }

    public function authorizePermission($permission) {
        $user = Flight::get('user');
        if (!isset($user->permissions) || !in_array($permission, $user->permissions)) {
            Flight::halt(403, 'Access denied: permission missing');
        }
    }
}
