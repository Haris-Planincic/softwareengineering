<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/BookingDao.php';

class BookingService extends BaseService {
    public function __construct() {
        parent::__construct(new BookingDao());
    }

    public function getByUserId($userId) {
        return $this->dao->getByUserId($userId);
    }

    public function createBooking($data) {
        if (strtotime($data['checkInDate']) >= strtotime($data['checkOutDate'])) {
            throw new Exception("Check-out date must be after check-in date.");
        }
        return $this->create($data);
    }
}
?>
