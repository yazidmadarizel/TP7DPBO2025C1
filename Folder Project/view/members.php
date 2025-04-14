<h2>Member Management</h2>

<!-- Search Form -->
<form method="GET" class="search-form">
    <input type="hidden" name="page" value="members">
    <input type="text" name="search" placeholder="Search members..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
    <button type="submit">Search</button>
    <a href="?page=members" class="button">Clear</a>
</form>

<!-- Members List -->
<div class="table-container">
    <h3>Member List</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Membership Type</th>
                <th>Join Date</th>
                <th>Expiry Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($membersList)): ?>
                <tr>
                    <td colspan="8" class="no-data">No members found.</td>
                </tr>
            <?php else: ?>
                <?php
                    // Urutkan berdasarkan ID sebelum ditampilkan
                    usort($membersList, function ($a, $b) {
                        return $a['id'] <=> $b['id'];
                    });
                    ?>

                <?php foreach($membersList as $member): ?>
                <tr>
                    <td><?= $member['id'] ?></td>
                    <td><?= htmlspecialchars($member['name']) ?></td>
                    <td><?= htmlspecialchars($member['email']) ?></td>
                    <td><?= htmlspecialchars($member['phone']) ?></td>
                    <td><?= $member['membership_type'] ?></td>
                    <td><?= $member['join_date'] ?></td>
                    <td><?= $member['expiry_date'] ?></td>
                    <td>
                        <a href="?page=members&action=edit&id=<?= $member['id'] ?>" class="button edit">Edit</a>
                        <a href="?page=members&action=delete&id=<?= $member['id'] ?>" class="button delete" onclick="return confirm('Are you sure you want to delete this member?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Add/Edit Member Form -->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'edit')): ?>
    <?php 
    $isEdit = $_GET['action'] == 'edit';
    $formTitle = $isEdit ? 'Edit Member' : 'Add New Member';
    $memberData = $isEdit && isset($editMember) ? $editMember : null;
    ?>
    <div class="form-container">
        <h3><?= $formTitle ?></h3>
        <form method="POST">
            <?php if($isEdit): ?>
                <input type="hidden" name="id" value="<?= $memberData['id'] ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required 
                       value="<?= $isEdit ? htmlspecialchars($memberData['name']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required 
                       value="<?= $isEdit ? htmlspecialchars($memberData['email']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required 
                       value="<?= $isEdit ? htmlspecialchars($memberData['phone']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="membership_type">Membership Type:</label>
                <select id="membership_type" name="membership_type" required>
                    <option value="Basic" <?= $isEdit && $memberData['membership_type'] == 'Basic' ? 'selected' : '' ?>>Basic</option>
                    <option value="Standard" <?= $isEdit && $memberData['membership_type'] == 'Standard' ? 'selected' : '' ?>>Standard</option>
                    <option value="Premium" <?= $isEdit && $memberData['membership_type'] == 'Premium' ? 'selected' : '' ?>>Premium</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="join_date">Join Date:</label>
                <input type="date" id="join_date" name="join_date" required 
                       value="<?= $isEdit ? $memberData['join_date'] : date('Y-m-d') ?>">
            </div>
            
            <div class="form-group">
                <label for="expiry_date">Expiry Date:</label>
                <input type="date" id="expiry_date" name="expiry_date" required 
                       value="<?= $isEdit ? $memberData['expiry_date'] : date('Y-m-d', strtotime('+1 year')) ?>">
            </div>
            
            <div class="form-buttons">
                <button type="submit" name="<?= $isEdit ? 'update_member' : 'add_member' ?>" class="button submit">
                    <?= $isEdit ? 'Update Member' : 'Add Member' ?>
                </button>
                <a href="?page=members" class="button cancel">Cancel</a>
            </div>
        </form>
    </div>
<?php else: ?>
    <div class="add-new">
        <a href="?page=members&action=add" class="button add">Add New Member</a>
    </div>
<?php endif; ?>