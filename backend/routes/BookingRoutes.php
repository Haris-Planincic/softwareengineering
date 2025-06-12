<?php

Flight::route('GET /bookings', function () {
    Flight::json(Flight::bookingService()->getAll());
});

Flight::route('GET /bookings/@id', function ($id) {
    Flight::json(Flight::bookingService()->getById($id));
});

Flight::route('GET /bookings/user/@userId', function ($userId) {
    Flight::json(Flight::bookingService()->getByUserId($userId));
});

Flight::route('POST /bookings', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::bookingService()->createBooking($data));
});

Flight::route('PUT /bookings/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::bookingService()->update($id, $data));
});

Flight::route('DELETE /bookings/@id', function ($id) {
    Flight::json(Flight::bookingService()->delete($id));
});
