<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/AccommodationDao.php';

class AccommodationService extends BaseService {
    public function __construct() {
        parent::__construct(new AccommodationDao());
    }

    public function createAccommodation($data) {
        if ($data['pricePerNight'] <= 0) {
            throw new Exception("Price per night must be a positive number.");
        }
        return $this->create($data);
    }
}
?>
