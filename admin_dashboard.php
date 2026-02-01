<?php
if (file_exists(__DIR__ . '/Database.php')) {
    require_once __DIR__ . '/Database.php';
}

$contactPath = __DIR__ . '/M/ContactMapper.php';
if (file_exists($contactPath)) {
    require_once $contactPath;
} else {
    die("GABIM: Skedari nuk u gjet në: " . $contactPath);
}

$userPath = __DIR__ . '/M/UserMapper.php';
if (file_exists($userPath)) {
    require_once $userPath;
} else {
    die("GABIM: Skedari nuk u gjet në: " . $userPath);
}

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
            <div class="header-left">
                <h1>Dashboard Overview</h1>
                <p>Welcome back, Admin</p>
            </div>
            <div class="header-right">
                <a href="logout.php" style="color: #d02d1b; text-decoration: none;"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>
            </div>
        </header>
        
        <section class="stats-grid">
            <div class="stat-card">
                <i class="fa-solid fa-user-group icon-bg"></i>
                <h3>Total Users</h3>
                <p><?php echo is_array($users) ? count($users) : 0; ?></p>
            </div>
            <div class="stat-card">
                <i class="fa-solid fa-comment-dots icon-bg"></i>
                <h3>New Messages</h3>
                <p><?php echo is_array($messages) ? count($messages) : 0; ?></p>
            </div>
            <div class="stat-card">
                <i class="fa-solid fa-plane-departure icon-bg"></i>
                <h3>Active Flights</h3>
                <p>12</p>
            </div>
        </section>

        <section class="table-section">
            <div class="table-header">
                <h2>Registered Users</h2>
            </div>
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
                            <td>
                                <span class="badge <?php echo ($user['role'] == 'admin') ? 'admin' : 'user'; ?>">
                                    <?php echo htmlspecialchars($user['role']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn-edit" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                
                                <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn-delete" title="Delete" onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
</div>

</body>
</html>