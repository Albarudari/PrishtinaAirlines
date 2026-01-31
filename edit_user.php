<?php
require_once 'M/UserMapper.php';
$mapper = new UserMapper();


if (isset($_GET['id'])) {
    $user = $mapper->getUserById($_GET['id']);
}


if (isset($_POST['update_btn'])) {
    $mapper->updateUser($_GET['id'], $_POST);
    header("Location: admin_dashboard.php");
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Prishtina Airlines</title>
    
    <link rel="stylesheet" href="edit_user.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <div class="edit-card">
        <h2>Edit User Info</h2>
        
        <form method="POST">
            <div class="input-group">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            
            <div class="input-group">
                <label>Surname</label>
                <input type="text" name="surname" value="<?php echo htmlspecialchars($user['surname']); ?>" required>
            </div>
            
            <div class="input-group">
                <label>Nationality</label>
                <input type="text" name="nationality" value="<?php echo htmlspecialchars($user['nationality']); ?>">
            </div>
            
            <div class="input-group">
                <label>City</label>
                <input type="text" name="city" value="<?php echo htmlspecialchars($user['city']); ?>">
            </div>
            
            <div class="input-group">
                <label>Role</label>
                <select name="role">
                    <option value="user" <?php echo ($user['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                    <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>
            
            <div class="button-group">
                <button type="submit" name="update_btn" class="btn save-btn">Save Changes</button>
                <a href="admin_dashboard.php" class="btn cancel-btn">Cancel</a>
            </div>
        </form>
    </div>

</body>
</html>