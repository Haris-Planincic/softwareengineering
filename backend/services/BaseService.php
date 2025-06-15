<?php
require_once __DIR__ . '/../dao/BaseDao.php';

class BaseService {
    protected $dao;

    public function __construct($dao) {
        $this->dao = $dao;
    }

    public function getAll() {
        return $this->dao->getAll();
    }

    public function getById($id) {
        return $this->dao->getById($id);
    }

    public function create($data) {
        return $this->dao->insert($data);
    }

    public function update($id, $data, $primaryKey) {
        return $this->dao->update($id, $data, $primaryKey);
    }

    public function delete($id) {
        return $this->dao->delete($id);
    }
}
?>
