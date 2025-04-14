<h2>Equipment Management</h2>

<!-- Search Form -->
<form method="GET" class="search-form">
    <input type="hidden" name="page" value="equipment">
    <input type="text" name="search" placeholder="Search equipment..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
    <button type="submit">Search</button>
    <a href="?page=equipment" class="button">Clear</a>
</form>

<!-- Equipment List -->
<div class="table-container">
    <h3>Equipment List</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Status</th>
                <th>Purchase Date</th>
                <th>Last Maintenance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($equipmentList)): ?>
                <tr>
                    <td colspan="7" class="no-data">No equipment found.</td>
                </tr>
            <?php else: ?>
                <?php
                    // Sort by ID before displaying
                    usort($equipmentList, function ($a, $b) {
                        return $a['id'] <=> $b['id'];
                    });
                ?>

                <?php foreach($equipmentList as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= htmlspecialchars($item['category']) ?></td>
                    <td><?= $item['status'] ?></td>
                    <td><?= $item['purchase_date'] ?></td>
                    <td><?= $item['last_maintenance'] ?? 'N/A' ?></td>
                    <td>
                        <a href="?page=equipment&action=edit&id=<?= $item['id'] ?>" class="button edit">Edit</a>
                        <a href="?page=equipment&action=delete&id=<?= $item['id'] ?>" class="button delete" onclick="return confirm('Are you sure you want to delete this equipment?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Add/Edit Equipment Form -->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'edit')): ?>
    <?php 
    $isEdit = $_GET['action'] == 'edit';
    $formTitle = $isEdit ? 'Edit Equipment' : 'Add New Equipment';
    $equipmentData = $isEdit && isset($editEquipment) ? $editEquipment : null;
    ?>
    <div class="form-container">
        <h3><?= $formTitle ?></h3>
        <form method="POST">
            <?php if($isEdit): ?>
                <input type="hidden" name="id" value="<?= $equipmentData['id'] ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required 
                       value="<?= $isEdit ? htmlspecialchars($equipmentData['name']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" id="category" name="category" required 
                       value="<?= $isEdit ? htmlspecialchars($equipmentData['category']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Available" <?= $isEdit && $equipmentData['status'] == 'Available' ? 'selected' : '' ?>>Available</option>
                    <option value="Under Maintenance" <?= $isEdit && $equipmentData['status'] == 'Under Maintenance' ? 'selected' : '' ?>>Under Maintenance</option>
                    <option value="Out of Order" <?= $isEdit && $equipmentData['status'] == 'Out of Order' ? 'selected' : '' ?>>Out of Order</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="purchase_date">Purchase Date:</label>
                <input type="date" id="purchase_date" name="purchase_date" required 
                       value="<?= $isEdit ? $equipmentData['purchase_date'] : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="last_maintenance">Last Maintenance:</label>
                <input type="date" id="last_maintenance" name="last_maintenance" 
                       value="<?= $isEdit && !empty($equipmentData['last_maintenance']) ? $equipmentData['last_maintenance'] : '' ?>">
            </div>
            
            <div class="form-buttons">
                <button type="submit" name="<?= $isEdit ? 'update_equipment' : 'add_equipment' ?>" class="button submit">
                    <?= $isEdit ? 'Update Equipment' : 'Add Equipment' ?>
                </button>
                <a href="?page=equipment" class="button cancel">Cancel</a>
            </div>
        </form>
    </div>
<?php else: ?>
    <div class="add-new">
        <a href="?page=equipment&action=add" class="button add">Add New Equipment</a>
    </div>
<?php endif; ?>