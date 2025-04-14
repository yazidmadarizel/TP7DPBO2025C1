<?php
require_once 'config/db.php';

class Session {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAllSessions() {
        $stmt = $this->db->query("SELECT s.*, m.name as member_name, t.name as trainer_name 
                                 FROM sessions s
                                 JOIN members m ON s.member_id = m.id
                                 JOIN trainers t ON s.trainer_id = t.id
                                 ORDER BY s.id, s.session_date DESC, s.start_time ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getSessionById($id) {
        $stmt = $this->db->prepare("SELECT * FROM sessions WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function searchSessions($keyword) {
        $stmt = $this->db->prepare("SELECT s.*, m.name as member_name, t.name as trainer_name 
                                   FROM sessions s
                                   JOIN members m ON s.member_id = m.id
                                   JOIN trainers t ON s.trainer_id = t.id
                                   WHERE m.name LIKE ? OR t.name LIKE ? OR s.status LIKE ?
                                   ORDER BY s.id, s.session_date DESC, s.start_time ASC");
        $param = "%$keyword%";
        $stmt->execute([$param, $param, $param]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addSession($member_id, $trainer_id, $session_date, $start_time, $end_time, $status, $notes) {
        // Find the next available ID
        $nextId = $this->findNextAvailableId();
        
        $stmt = $this->db->prepare("INSERT INTO sessions (id, member_id, trainer_id, session_date, start_time, end_time, status, notes) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$nextId, $member_id, $trainer_id, $session_date, $start_time, $end_time, $status, $notes]);
    }

    public function updateSession($id, $member_id, $trainer_id, $session_date, $start_time, $end_time, $status, $notes) {
        $stmt = $this->db->prepare("UPDATE sessions 
                                   SET member_id = ?, trainer_id = ?, session_date = ?, 
                                       start_time = ?, end_time = ?, status = ?, notes = ?
                                   WHERE id = ?");
        return $stmt->execute([$member_id, $trainer_id, $session_date, $start_time, $end_time, $status, $notes, $id]);
    }

    public function deleteSession($id) {
        $stmt = $this->db->prepare("DELETE FROM sessions WHERE id = ?");
        return $stmt->execute([$id]);
    }

    private function findNextAvailableId() {
        // Get all existing IDs
        $stmt = $this->db->query("SELECT id FROM sessions ORDER BY id");
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