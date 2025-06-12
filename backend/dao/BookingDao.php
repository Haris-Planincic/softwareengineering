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
}
?>
