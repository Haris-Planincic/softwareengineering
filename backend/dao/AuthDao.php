<?php
require_once 'BaseDao.php';

class AuthDao extends BaseDao {
    public function __construct() {
        parent::__construct("users", "userId"); 
    }

    public function get_user_by_email($email) {
        $stmt = Database::connect()->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch();
    }
}
?>
