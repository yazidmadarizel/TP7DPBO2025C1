<?php
require_once 'config/db.php';

class Member {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAllMembers() {
        $stmt = $this->db->query("SELECT * FROM members ORDER BY id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMemberById($id) {
        $stmt = $this->db->prepare("SELECT * FROM members WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function searchMembers($keyword) {
        $stmt = $this->db->prepare("SELECT * FROM members WHERE name LIKE ? OR email LIKE ? ORDER BY id");
        $param = "%$keyword%";
        $stmt->execute([$param, $param]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addMember($name, $email, $phone, $membership_type, $join_date, $expiry_date) {
        // Find the next available ID
        $nextId = $this->findNextAvailableId();
        
        $stmt = $this->db->prepare("INSERT INTO members (id, name, email, phone, membership_type, join_date, expiry_date) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$nextId, $name, $email, $phone, $membership_type, $join_date, $expiry_date]);
    }

    public function updateMember($id, $name, $email, $phone, $membership_type, $join_date, $expiry_date) {
        $stmt = $this->db->prepare("UPDATE members 
                                   SET name = ?, email = ?, phone = ?, membership_type = ?, join_date = ?, expiry_date = ? 
                                   WHERE id = ?");
        return $stmt->execute([$name, $email, $phone, $membership_type, $join_date, $expiry_date, $id]);
    }

    public function deleteMember($id) {
        $stmt = $this->db->prepare("DELETE FROM members WHERE id = ?");
        return $stmt->execute([$id]);
    }

    private function findNextAvailableId() {
        // Get all existing IDs
        $stmt = $this->db->query("SELECT id FROM members ORDER BY id");
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