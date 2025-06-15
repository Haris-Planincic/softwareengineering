<?php

Flight::route('GET /contacts', function () {
    Flight::json(Flight::contactMessageService()->getAll());
});

Flight::route('GET /contacts/@id', function ($id) {
    Flight::json(Flight::contactMessageService()->getById($id));
});

Flight::route('POST /contacts', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::contactMessageService()->submitMessage($data));
});

Flight::route('DELETE /contacts/@id', function ($id) {
    Flight::json(Flight::contactMessageService()->delete($id));
});
