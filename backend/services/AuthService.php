<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/AuthDao.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService extends BaseService {
    private $auth_dao;

    public function __construct() {
        $this->auth_dao = new AuthDao();
        parent::__construct($this->auth_dao);
    }

    public function register($entity) {  
    if (empty($entity['email']) || empty($entity['password'])) {
        return ['success' => false, 'error' => 'Email and password are required.'];
    }

    $email_exists = $this->auth_dao->get_user_by_email($entity['email']);
    if ($email_exists) {
        return ['success' => false, 'error' => 'Email already registered.'];
    }

    $entity['password'] = password_hash($entity['password'], PASSWORD_BCRYPT);

    $created_user = $this->create($entity); // ✅ calls BaseService::create()


    // Fix: unset password from original $entity (optional), or from $created_user if it's an array
    if (is_array($created_user)) {
        unset($created_user['password']);
    }

    return ['success' => true, 'data' => $created_user];             
}


    public function login($entity) {
        if (empty($entity['email']) || empty($entity['password'])) {
            return ['success' => false, 'error' => 'Email and password are required.'];
        }

        $user = $this->auth_dao->get_user_by_email($entity['email']);
        if (!$user || !password_verify($entity['password'], $user['password'])) {
            return ['success' => false, 'error' => 'Invalid email or password.'];
        }

        unset($user['password']);
        $payload = [
            'user' => $user,
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24) // 24 hours
        ];

        $token = JWT::encode($payload, Config::JWT_SECRET(), 'HS256');

        return ['success' => true, 'data' => array_merge($user, ['token' => $token])];
    }
}
?>
