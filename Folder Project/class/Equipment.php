<?php
require_once 'config/db.php';

class Equipment {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAllEquipment() {
        $stmt = $this->db->query("SELECT * FROM equipment ORDER BY id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEquipmentById($id) {
        $stmt = $this->db->prepare("SELECT * FROM equipment WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function searchEquipment($keyword) {
        $stmt = $this->db->prepare("SELECT * FROM equipment WHERE name LIKE ? OR category LIKE ? ORDER BY id");
        $param = "%$keyword%";
        $stmt->execute([$param, $param]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addEquipment($name, $category, $status, $purchase_date, $last_maintenance) {
        // Find the first available ID (to fill gaps)
        $nextId = $this->findNextAvailableId();
        
        $stmt = $this->db->prepare("INSERT INTO equipment (id, name, category, status, purchase_date, last_maintenance) 
                                    VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$nextId, $name, $category, $status, $purchase_date, $last_maintenance]);
    }

    public function updateEquipment($id, $name, $category, $status, $purchase_date, $last_maintenance) {
        $stmt = $this->db->prepare("UPDATE equipment 
                                    SET name = ?, category = ?, status = ?, purchase_date = ?, last_maintenance = ? 
                                    WHERE id = ?");
        return $stmt->execute([$name, $category, $status, $purchase_date, $last_maintenance, $id]);
    }

    public function deleteEquipment($id) {
        $stmt = $this->db->prepare("DELETE FROM equipment WHERE id = ?");
        return $stmt->execute([$id]);
    }

    private function findNextAvailableId() {
        // Get all existing IDs
        $stmt = $this->db->query("SELECT id FROM equipment ORDER BY id");
        $existingIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        // If no records exist, start with 1
        if (empty($existingIds)) {
            return 1;
        }
        
        // Find the first gap in the sequence
        $expectedId = 1;
        foreach ($existingIds as $existingId) {
            if ($existingId > $expectedId) {
                // Found a gap
                return $expectedId;
            }
            $expectedId = $existingId + 1;
        }
        
        // If no gaps found, return next sequential number
        return $expectedId;
    }

  
}
?>