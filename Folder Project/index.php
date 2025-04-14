<?php
// Include class files
require_once 'class/Equipment.php';
require_once 'class/Member.php';
require_once 'class/Trainer.php';
require_once 'class/Session.php';

// Initialize objects
$equipment = new Equipment();
$member = new Member();
$trainer = new Trainer();
$session = new Session();

// Initialize message variables
$successMsg = '';
$errorMsg = '';

// Equipment CRUD Operations
if (isset($_POST['add_equipment'])) {
    if ($equipment->addEquipment(
        $_POST['name'], 
        $_POST['category'], 
        $_POST['status'], 
        $_POST['purchase_date'], 
        !empty($_POST['last_maintenance']) ? $_POST['last_maintenance'] : null
    )) {
        $successMsg = "Equipment added successfully!";
        header("Location: ?page=equipment&success=$successMsg");
        exit;
    } else {
        $errorMsg = "Failed to add equipment.";
    }
}

if (isset($_POST['update_equipment'])) {
    if ($equipment->updateEquipment(
        $_POST['id'],
        $_POST['name'], 
        $_POST['category'], 
        $_POST['status'], 
        $_POST['purchase_date'], 
        !empty($_POST['last_maintenance']) ? $_POST['last_maintenance'] : null
    )) {
        $successMsg = "Equipment updated successfully!";
        header("Location: ?page=equipment&success=$successMsg");
        exit;
    } else {
        $errorMsg = "Failed to update equipment.";
    }
}

if (isset($_GET['page']) && $_GET['page'] == 'equipment' && isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    if ($equipment->deleteEquipment($_GET['id'])) {
        $successMsg = "Equipment deleted successfully!";
        header("Location: ?page=equipment&success=$successMsg");
        exit;
    } else {
        $errorMsg = "Failed to delete equipment.";
    }
}

// Member CRUD Operations
if (isset($_POST['add_member'])) {
    if ($member->addMember(
        $_POST['name'], 
        $_POST['email'], 
        $_POST['phone'], 
        $_POST['membership_type'], 
        $_POST['join_date'], 
        $_POST['expiry_date']
    )) {
        $successMsg = "Member added successfully!";
        header("Location: ?page=members&success=$successMsg");
        exit;
    } else {
        $errorMsg = "Failed to add member.";
    }
}

if (isset($_POST['update_member'])) {
    if ($member->updateMember(
        $_POST['id'],
        $_POST['name'], 
        $_POST['email'], 
        $_POST['phone'], 
        $_POST['membership_type'], 
        $_POST['join_date'], 
        $_POST['expiry_date']
    )) {
        $successMsg = "Member updated successfully!";
        header("Location: ?page=members&success=$successMsg");
        exit;
    } else {
        $errorMsg = "Failed to update member.";
    }
}

if (isset($_GET['page']) && $_GET['page'] == 'members' && isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    if ($member->deleteMember($_GET['id'])) {
        $successMsg = "Member deleted successfully!";
        header("Location: ?page=members&success=$successMsg");
        exit;
    } else {
        $errorMsg = "Failed to delete member.";
    }
}

// Trainer CRUD Operations
if (isset($_POST['add_trainer'])) {
    if ($trainer->addTrainer(
        $_POST['name'], 
        $_POST['email'], 
        $_POST['phone'], 
        $_POST['specialization']
    )) {
        $successMsg = "Trainer added successfully!";
        header("Location: ?page=trainers&success=$successMsg");
        exit;
    } else {
        $errorMsg = "Failed to add trainer.";
    }
}

if (isset($_POST['update_trainer'])) {
    if ($trainer->updateTrainer(
        $_POST['id'],
        $_POST['name'], 
        $_POST['email'], 
        $_POST['phone'], 
        $_POST['specialization']
    )) {
        $successMsg = "Trainer updated successfully!";
        header("Location: ?page=trainers&success=$successMsg");
        exit;
    } else {
        $errorMsg = "Failed to update trainer.";
    }
}

if (isset($_GET['page']) && $_GET['page'] == 'trainers' && isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    if ($trainer->deleteTrainer($_GET['id'])) {
        $successMsg = "Trainer deleted successfully!";
        header("Location: ?page=trainers&success=$successMsg");
        exit;
    } else {
        $errorMsg = "Failed to delete trainer.";
    }
}

// Session CRUD Operations
if (isset($_POST['add_session'])) {
    if ($session->addSession(
        $_POST['member_id'], 
        $_POST['trainer_id'], 
        $_POST['session_date'], 
        $_POST['start_time'], 
        $_POST['end_time'], 
        $_POST['status'], 
        $_POST['notes']
    )) {
        $successMsg = "Training session added successfully!";
        header("Location: ?page=sessions&success=$successMsg");
        exit;
    } else {
        $errorMsg = "Failed to add training session.";
    }
}

if (isset($_POST['update_session'])) {
    if ($session->updateSession(
        $_POST['id'],
        $_POST['member_id'], 
        $_POST['trainer_id'], 
        $_POST['session_date'], 
        $_POST['start_time'], 
        $_POST['end_time'], 
        $_POST['status'], 
        $_POST['notes']
    )) {
        $successMsg = "Training session updated successfully!";
        header("Location: ?page=sessions&success=$successMsg");
        exit;
    } else {
        $errorMsg = "Failed to update training session.";
    }
}

if (isset($_GET['page']) && $_GET['page'] == 'sessions' && isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    if ($session->deleteSession($_GET['id'])) {
        $successMsg = "Training session deleted successfully!";
        header("Location: ?page=sessions&success=$successMsg");
        exit;
    } else {
        $errorMsg = "Failed to delete training session.";
    }
}

// Handle data for views
$page = isset($_GET['page']) ? $_GET['page'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Get search keyword if present
$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';

// Get data based on current page
if ($page == 'equipment') {
    if (!empty($searchKeyword)) {
        $equipmentList = $equipment->searchEquipment($searchKeyword);
    } else {
        $equipmentList = $equipment->getAllEquipment();
    }
    
    if ($action == 'edit' && isset($_GET['id'])) {
        $editEquipment = $equipment->getEquipmentById($_GET['id']);
    }
} elseif ($page == 'members') {
    if (!empty($searchKeyword)) {
        $membersList = $member->searchMembers($searchKeyword);
    } else {
        $membersList = $member->getAllMembers();
    }
    
    if ($action == 'edit' && isset($_GET['id'])) {
        $editMember = $member->getMemberById($_GET['id']);
    }
} elseif ($page == 'trainers') {
    if (!empty($searchKeyword)) {
        $trainersList = $trainer->searchTrainers($searchKeyword);
    } else {
        $trainersList = $trainer->getAllTrainers();
    }
    
    if ($action == 'edit' && isset($_GET['id'])) {
        $editTrainer = $trainer->getTrainerById($_GET['id']);
    }
} elseif ($page == 'sessions') {
    if (!empty($searchKeyword)) {
        $sessionsList = $session->searchSessions($searchKeyword);
    } else {
        $sessionsList = $session->getAllSessions();
    }
    
    if ($action == 'edit' && isset($_GET['id'])) {
        $editSession = $session->getSessionById($_GET['id']);
    }
    
    // For session forms, we need members and trainers lists
    $allMembers = $member->getAllMembers();
    $allTrainers = $trainer->getAllTrainers();
}

// Get success message from URL if redirected
if (isset($_GET['success'])) {
    $successMsg = $_GET['success'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Center Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php include 'view/header.php'; ?>
        
        <main>
            <?php if(!empty($successMsg)): ?>
                <div class="alert success"><?= $successMsg ?></div>
            <?php endif; ?>
            
            <?php if(!empty($errorMsg)): ?>
                <div class="alert error"><?= $errorMsg ?></div>
            <?php endif; ?>
            
            <?php if(empty($page)): ?>
                <div class="welcome">
                    <h2>Welcome to Fitness Center Management System</h2>
                    <p>Select an option from the navigation menu to manage equipment, members, trainers, or training sessions.</p>
                    
                    <div class="dashboard-cards">
                        <div class="card">
                            <h3>Equipment</h3>
                            <p>Manage all fitness equipment in the center.</p>
                            <a href="?page=equipment" class="button">View Equipment</a>
                        </div>
                        
                        <div class="card">
                            <h3>Members</h3>
                            <p>Manage all member accounts and memberships.</p>
                            <a href="?page=members" class="button">View Members</a>
                        </div>
                        
                        <div class="card">
                            <h3>Trainers</h3>
                            <p>Manage all fitness trainers and their specializations.</p>
                            <a href="?page=trainers" class="button">View Trainers</a>
                        </div>
                        
                        <div class="card">
                            <h3>Training Sessions</h3>
                            <p>Schedule and manage training sessions.</p>
                            <a href="?page=sessions" class="button">View Sessions</a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <?php
                    switch ($page) {
                        case 'equipment':
                            include 'view/equipment.php';
                            break;
                        case 'members':
                            include 'view/members.php';
                            break;
                        case 'trainers':
                            include 'view/trainers.php';
                            break;
                        case 'sessions':
                            include 'view/sessions.php';
                            break;
                        default:
                            echo "<p>Page not found.</p>";
                    }
                ?>
            <?php endif; ?>
        </main>
        
        <?php include 'view/footer.php'; ?>
    </div>
</body>
</html>