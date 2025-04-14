<h2>Training Session Management</h2>

<!-- Search Form -->
<form method="GET" class="search-form">
    <input type="hidden" name="page" value="sessions">
    <input type="text" name="search" placeholder="Search by member or trainer..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
    <button type="submit">Search</button>
    <a href="?page=sessions" class="button">Clear</a>
</form>

<!-- Sessions List -->
<div class="table-container">
    <h3>Training Sessions List</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Member</th>
                <th>Trainer</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($sessionsList)): ?>
                <tr>
                    <td colspan="8" class="no-data">No training sessions found.</td>
                </tr>
            <?php else: ?>
                <?php
                    // Urutkan berdasarkan ID sebelum ditampilkan
                    usort($sessionsList, function ($a, $b) {
                        return $a['id'] <=> $b['id'];
                    });
                    ?>

                <?php foreach($sessionsList as $session): ?>
                <tr>
                    <td><?= $session['id'] ?></td>
                    <td><?= htmlspecialchars($session['member_name']) ?></td>
                    <td><?= htmlspecialchars($session['trainer_name']) ?></td>
                    <td><?= $session['session_date'] ?></td>
                    <td><?= substr($session['start_time'], 0, 5) ?> - <?= substr($session['end_time'], 0, 5) ?></td>
                    <td><?= $session['status'] ?></td>
                    <td><?= !empty($session['notes']) ? htmlspecialchars(substr($session['notes'], 0, 30)) . (strlen($session['notes']) > 30 ? '...' : '') : 'N/A' ?></td>
                    <td>
                        <a href="?page=sessions&action=edit&id=<?= $session['id'] ?>" class="button edit">Edit</a>
                        <a href="?page=sessions&action=delete&id=<?= $session['id'] ?>" class="button delete" onclick="return confirm('Are you sure you want to delete this session?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Add/Edit Session Form -->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'edit')): ?>
    <?php 
    $isEdit = $_GET['action'] == 'edit';
    $formTitle = $isEdit ? 'Edit Training Session' : 'Add New Training Session';
    $sessionData = $isEdit && isset($editSession) ? $editSession : null;
    ?>
    <div class="form-container">
        <h3><?= $formTitle ?></h3>
        <form method="POST">
            <?php if($isEdit): ?>
                <input type="hidden" name="id" value="<?= $sessionData['id'] ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="member_id">Member:</label>
                <select id="member_id" name="member_id" required>
                    <option value="">-- Select Member --</option>
                    <?php foreach($allMembers as $member): ?>
                        <option value="<?= $member['id'] ?>" <?= $isEdit && $sessionData['member_id'] == $member['id'] ? 'selected' : '' ?>><?= htmlspecialchars($member['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="trainer_id">Trainer:</label>
                <select id="trainer_id" name="trainer_id" required>
                    <option value="">-- Select Trainer --</option>
                    <?php foreach($allTrainers as $trainer): ?>
                        <option value="<?= $trainer['id'] ?>" <?= $isEdit && $sessionData['trainer_id'] == $trainer['id'] ? 'selected' : '' ?>><?= htmlspecialchars($trainer['name']) ?> (<?= htmlspecialchars($trainer['specialization']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="session_date">Session Date:</label>
                <input type="date" id="session_date" name="session_date" required 
                       value="<?= $isEdit ? $sessionData['session_date'] : date('Y-m-d') ?>">
            </div>
            
            <div class="form-group">
                <label for="start_time">Start Time:</label>
                <input type="time" id="start_time" name="start_time" required 
                       value="<?= $isEdit ? $sessionData['start_time'] : '09:00' ?>">
            </div>
            
            <div class="form-group">
                <label for="end_time">End Time:</label>
                <input type="time" id="end_time" name="end_time" required 
                       value="<?= $isEdit ? $sessionData['end_time'] : '10:00' ?>">
            </div>
            
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Scheduled" <?= $isEdit && $sessionData['status'] == 'Scheduled' ? 'selected' : '' ?>>Scheduled</option>
                    <option value="Completed" <?= $isEdit && $sessionData['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="Cancelled" <?= $isEdit && $sessionData['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="notes">Notes:</label>
                <textarea id="notes" name="notes" rows="3"><?= $isEdit ? htmlspecialchars($sessionData['notes']) : '' ?></textarea>
            </div>
            
            <div class="form-buttons">
                <button type="submit" name="<?= $isEdit ? 'update_session' : 'add_session' ?>" class="button submit">
                    <?= $isEdit ? 'Update Session' : 'Add Session' ?>
                </button>
                <a href="?page=sessions" class="button cancel">Cancel</a>
            </div>
        </form>
    </div>
<?php else: ?>
    <div class="add-new">
        <a href="?page=sessions&action=add" class="button add">Add New Training Session</a>
    </div>
<?php endif; ?>