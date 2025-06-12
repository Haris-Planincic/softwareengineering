<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/ContactMessageDao.php';

class ContactMessageService extends BaseService {
    public function __construct() {
        parent::__construct(new ContactMessageDao());
    }

    public function submitMessage($data) {
        if (strlen($data['message']) < 10) {
            throw new Exception("Message is too short.");
        }
        return $this->create($data);
    }
}
?>
