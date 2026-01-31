<?php
require_once 'M/ContactMapper.php';
require_once 'M/UserMapper.php';

$contactMapper = new ContactMapper();
$messages = $contactMapper->getAllInquiries();

$userMapper = new UserMapper();
$users = $userMapper->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Prishtina Airlines</title>
    <link rel="stylesheet" href="admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="admin-container">
    <aside class="sidebar">
        <div class="logo">✈ Admin Panel</div>
        <nav class="side-nav">
             <a href="admin_dashboard.php" class="active"><i class="fa-solid fa-users"></i> Registered Users</a>
             <a href="admin_messages.php"><i class="fa-solid fa-envelope"></i> Messages</a>
             <a href="#"><i class="fa-solid fa-chart-line"></i> Statistics</a>
             <a href="#"><i class="fa-solid fa-plane"></i> Flight Data</a>
             <a href="homepage.php" class="back-site"><i class="fa-solid fa-arrow-left"></i> Back to Site</a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="admin-header">
            <h1>Dashboard Overview</h1>
            <p>Welcome back, Admin</p>
        </header>
        
        <section class="stats-grid">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p><?php echo count($users); ?></p>
            </div>
            <div class="stat-card">
                <h3>New Messages</h3>
                <p><?php echo count($messages); ?></p>
            </div>
            <div class="stat-card">
                <h3>Active Flights</h3>
                <p>12</p>
            </div>
        </section>

        <section class="table-section">
            <h2>Registered Users</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
               <tbody>
    <?php if (empty($users)): ?>
        <tr><td colspan="5">No users found.</td></tr>
    <?php else: ?>
        <?php foreach($users as $user): ?>
        <tr>
            <td>#<?php echo htmlspecialchars($user['id']); ?></td>
            <td><?php echo htmlspecialchars($user['name']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td><span class="badge admin"><?php echo htmlspecialchars($user['role']); ?></span></td>
            <td>
                <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn-edit" style="color: #497682; margin-right: 15px; text-decoration: none;">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                
                <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn-delete" style="color: #d02d1b; text-decoration: none;" onclick="return confirm('Are you sure?')">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</tbody>