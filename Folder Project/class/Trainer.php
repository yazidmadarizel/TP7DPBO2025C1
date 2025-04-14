<?php
require_once 'config/db.php';

class Trainer {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAllTrainers() {
        $stmt = $this->db->query("SELECT * FROM trainers ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTrainerById($id) {
        $stmt = $this->db->prepare("SELECT * FROM trainers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function searchTrainers($keyword) {
        $stmt = $this->db->prepare("SELECT * FROM trainers WHERE name LIKE ? OR specialization LIKE ?");
        $param = "%$keyword%";
        $stmt->execute([$param, $param]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addTrainer($name, $email, $phone, $specialization) {
        // Find the next available ID
        $nextId = $this->findNextAvailableId();
        
        $stmt = $this->db->prepare("INSERT INTO trainers (id, name, email, phone, specialization) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$nextId, $name, $email, $phone, $specialization]);
    }

    public function updateTrainer($id, $name, $email, $phone, $specialization) {
        $stmt = $this->db->prepare("UPDATE trainers SET name = ?, email = ?, phone = ?, specialization = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $phone, $specialization, $id]);
    }

    public function deleteTrainer($id) {
        $stmt = $this->db->prepare("DELETE FROM trainers WHERE id = ?");
        return $stmt->execute([$id]);
    }

    private function findNextAvailableId() {
        // Get all existing IDs
        $stmt = $this->db->query("SELECT id FROM trainers ORDER BY id");
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
