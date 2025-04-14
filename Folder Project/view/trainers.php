<h2>Trainer Management</h2>

<!-- Search Form -->
<form method="GET" class="search-form">
    <input type="hidden" name="page" value="trainers">
    <input type="text" name="search" placeholder="Search trainers..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
    <button type="submit">Search</button>
    <a href="?page=trainers" class="button">Clear</a>
</form>

<!-- Trainers List -->
<div class="table-container">
    <h3>Trainer List</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Specialization</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($trainersList)): ?>
                <tr>
                    <td colspan="6" class="no-data">No trainers found.</td>
                </tr>
            <?php else: ?>
                <?php
                    // Urutkan berdasarkan ID sebelum ditampilkan
                    usort($trainersList, function ($a, $b) {
                        return $a['id'] <=> $b['id'];
                    });
                    ?>

                <?php foreach($trainersList as $trainer): ?>
                <tr>
                    <td><?= $trainer['id'] ?></td>
                    <td><?= htmlspecialchars($trainer['name']) ?></td>
                    <td><?= htmlspecialchars($trainer['email']) ?></td>
                    <td><?= htmlspecialchars($trainer['phone']) ?></td>
                    <td><?= htmlspecialchars($trainer['specialization']) ?></td>
                    <td>
                        <a href="?page=trainers&action=edit&id=<?= $trainer['id'] ?>" class="button edit">Edit</a>
                        <a href="?page=trainers&action=delete&id=<?= $trainer['id'] ?>" class="button delete" onclick="return confirm('Are you sure you want to delete this trainer?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Add/Edit Trainer Form -->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'edit')): ?>
    <?php 
    $isEdit = $_GET['action'] == 'edit';
    $formTitle = $isEdit ? 'Edit Trainer' : 'Add New Trainer';
    $trainerData = $isEdit && isset($editTrainer) ? $editTrainer : null;
    ?>
    <div class="form-container">
        <h3><?= $formTitle ?></h3>
        <form method="POST">
            <?php if($isEdit): ?>
                <input type="hidden" name="id" value="<?= $trainerData['id'] ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required 
                       value="<?= $isEdit ? htmlspecialchars($trainerData['name']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required 
                       value="<?= $isEdit ? htmlspecialchars($trainerData['email']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required 
                       value="<?= $isEdit ? htmlspecialchars($trainerData['phone']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="specialization">Specialization:</label>
                <input type="text" id="specialization" name="specialization" required 
                       value="<?= $isEdit ? htmlspecialchars($trainerData['specialization']) : '' ?>">
            </div>
            
            <div class="form-buttons">
                <button type="submit" name="<?= $isEdit ? 'update_trainer' : 'add_trainer' ?>" class="button submit">
                    <?= $isEdit ? 'Update Trainer' : 'Add Trainer' ?>
                </button>
                <a href="?page=trainers" class="button cancel">Cancel</a>
            </div>
        </form>
    </div>
<?php else: ?>
    <div class="add-new">
        <a href="?page=trainers&action=add" class="button add">Add New Trainer</a>
    </div>
<?php endif; ?>