<?php
require_once 'M/ContactMapper.php';

$mapper = new ContactMapper();
$messages = $mapper->getAllInquiries();
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
             <a href="admin_dashboard.php"><i class="fa-solid fa-users"></i> Registered Users</a>
             <a href="admin_messages.php"><i class="fa-solid fa-envelope"></i> Messages</a>
             <a href="admin_flights.php"><i class="fa-solid fa-plane"></i> Flight Data</a>
             <a href="admin_homepage.php"><i class="fa-solid fa-house"></i> Home Page</a>
             <a href="admin_hotels.php"><i class="fa-solid fa-hotel"></i> Hotels</a>
             <a href="homepage.php" class="back-site"><i class="fa-solid fa-arrow-left"></i> Back to Site</a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="admin-header">
            <h1>Welcome, Admin</h1>
        </header>
        
        <section class="stats-grid">
            <div class="stat-card">
                <h3>Total Messages</h3>
                <p><?php echo count($messages); ?></p>
            </div>
        </section>

        <section class="table-section">
            <h2>Customer Inquiries</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($messages)): ?>
                        <tr><td colspan="4" style="text-align:center;">Nuk ka mesazhe për të shfaqur.</td></tr>
                    <?php else: ?>
                        <?php foreach($messages as $msg): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($msg['emri'] ?? 'N/A'); ?></td>
                            
                            <td><?php echo htmlspecialchars($msg['email'] ?? 'N/A'); ?></td>
                            
                            <td><?php echo htmlspecialchars($msg['mesazhi'] ?? 'N/A'); ?></td>
                            
                            <td><?php echo htmlspecialchars($msg['created_at'] ?? 'N/A'); ?></td>
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