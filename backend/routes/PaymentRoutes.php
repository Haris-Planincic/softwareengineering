<?php

Flight::route('GET /payments', function () {
    Flight::json(Flight::paymentService()->getAll());
});

Flight::route('GET /payments/@id', function ($id) {
    Flight::json(Flight::paymentService()->getById($id));
});

Flight::route('GET /payments/user/@userId', function ($userId) {
    Flight::json(Flight::paymentService()->getByUserId($userId));
});

Flight::route('POST /payments', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::paymentService()->createPayment($data));
});

Flight::route('PUT /payments/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::paymentService()->update($id, $data));
});

Flight::route('DELETE /payments/@id', function ($id) {
    Flight::json(Flight::paymentService()->delete($id));
});
