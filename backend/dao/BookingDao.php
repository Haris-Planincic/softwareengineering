<?php
require_once 'BaseDao.php';

class BookingDao extends BaseDao {
    public function __construct() {
        parent::__construct("Bookings");
    }

    public function getByUserId($userId) {
        $stmt = $this->connection->prepare("SELECT * FROM Bookings WHERE userId = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByAccommodationId($accommodationId) {
        $stmt = $this->connection->prepare("SELECT * FROM Bookings WHERE accommodationId = :id AND status = 'Booked'");
        $stmt->bindParam(':id', $accommodationId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteByBookingId($bookingId) {
        $stmt = $this->connection->prepare("DELETE FROM Bookings WHERE bookingId = :id");
        $stmt->bindParam(':id', $bookingId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
