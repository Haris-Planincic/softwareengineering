<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::route('POST /auth/login', function () {
    $data = Flight::request()->data->getData();
    $response = Flight::auth_service()->login($data);

    if ($response['success']) {
        Flight::json([
            'message' => 'Login successful',
            'data' => $response['data']
        ]);
    } else {
        Flight::halt(401, $response['error']);
    }
});

Flight::route('POST /auth/register', function () {
    $data = Flight::request()->data->getData();
    $response = Flight::auth_service()->register($data);

    if ($response['success']) {
        Flight::json([
            'message' => 'Registration successful',
            'data' => $response['data']
        ]);
    } else {
        Flight::halt(400, $response['error']);
    }
});

?>
