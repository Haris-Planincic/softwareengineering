<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/PaymentDao.php';

class PaymentService extends BaseService {
    public function __construct() {
        parent::__construct(new PaymentDao());
    }

    public function getByUserId($userId) {
        return $this->dao->getByUserId($userId);
    }

    public function createPayment($data) {
        if ($data['amount'] <= 0) {
            throw new Exception("Payment amount must be greater than 0.");
        }
        return $this->create($data);
    }
}
?>
