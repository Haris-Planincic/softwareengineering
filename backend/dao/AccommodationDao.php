<?php
require_once 'BaseDao.php';

class AccommodationDao extends BaseDao {
    public function __construct() {
        parent::__construct("Accommodations", "id"); // ✅ Specify table and PK
    }
}
?>
