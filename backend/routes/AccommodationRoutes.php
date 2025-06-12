<?php

Flight::route('GET /accommodations', function () {
    $data = Flight::accommodationService()->getAll();
    var_dump($data); // 👈 show raw output
    die();           // 👈 stop further execution
});


Flight::route('GET /accommodations/@id', function ($id) {
    Flight::json(Flight::accommodationService()->getById($id));
});

Flight::route('POST /accommodations', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::accommodationService()->createAccommodation($data));
});

Flight::route('PUT /accommodations/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::accommodationService()->update($id, $data));
});

Flight::route('DELETE /accommodations/@id', function ($id) {
    Flight::json(Flight::accommodationService()->delete($id));
});
