<?php
require_once 'BaseDao.php';

class AccommodationDao extends BaseDao {
    public function __construct() {
        parent::__construct("Accommodations", "accommodationId"); 
    }
}
?>
