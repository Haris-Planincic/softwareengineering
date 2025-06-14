<?php

Flight::route('GET /accommodations', function () {
    $data = Flight::accommodationService()->getAll();
    Flight::json($data);
});


Flight::route('GET /accommodations/@id', function ($id) {
    Flight::json(Flight::accommodationService()->getById($id));
});

Flight::route('POST /accommodations', function () {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::accommodationService()->createAccommodation($data));
});

Flight::route('PUT /accommodations/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::accommodationService()->update($id, $data));
});

Flight::route('DELETE /accommodations/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::accommodationService()->delete($id));
});
