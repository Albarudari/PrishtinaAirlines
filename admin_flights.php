<?php
session_start();
require_once __DIR__ . '/M/FlightMapper.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$flightMapper = new FlightMapper();
$current_admin_id = $_SESSION['user_id']; 

$editMode = false;
$editFlight = null;
if (isset($_GET['edit'])) {
    $editMode = true;
    $editFlight = $flightMapper->getFlightById($_GET['edit']);
}

if (isset($_POST['save_flight'])) {
    $airline = $_POST['airline'];
    $route = $_POST['route'];
    $time = $_POST['time'];
    $duration = $_POST['duration'];
    $price = $_POST['price'];
    $stops = (int)$_POST['stops'];

    if (isset($_POST['flight_id']) && !empty($_POST['flight_id'])) {
        $flightMapper->updateFlight($_POST['flight_id'], $airline, $route, $time, $duration, $price, $stops, $current_admin_id);
        header("Location: admin_flights.php?updated=1");
    } else {
        $flightMapper->addFlight($airline, $route, $time, $duration, $price, $stops, $current_admin_id);
        header("Location: admin_flights.php?success=1");
    }
    exit();
}

if (isset($_GET['delete'])) {
    $flightMapper->deleteFlight($_GET['delete']);
    header("Location: admin_flights.php?deleted=1");
    exit();
}

$flights = $flightMapper->getAllFlights();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Flight Administration | Prishtina Airlines</title>
    <link rel="stylesheet" href="admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .main-content { flex-grow: 1; padding: 30px; background: #f4f7f6; }
        .btn-edit { color: #f39c12; margin-right: 15px; font-size: 18px; }
        .btn-delete { color: #dc3545; font-size: 18px; }
        .btn-action { background: <?php echo $editMode ? '#f39c12' : '#00bcd4'; ?>; color: white; border: none; padding: 12px; cursor: pointer; font-weight: bold; border-radius: 4px; }
        .admin-info { font-size: 11px; color: #777; display: block; }
        .admin-name { color: #003366; font-weight: bold; }
        
        /* Stili per kartelat e statistikave */
        .stat-card { position: relative; overflow: hidden; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .icon-bg { opacity: 0.1; position: absolute; right: 10px; bottom: 10px; font-size: 40px; color: #003366; }
    </style>
</head>
<body>

<div class="admin-container" style="display: flex; min-height: 100vh;">
    <aside class="sidebar">
        <div class="logo"><i class="fa-solid fa-plane"></i> Admin Panel</div>
        <nav class="side-nav">
             <a href="admin_dashboard.php"><i class="fa-solid fa-users"></i> Registered Users</a>
             <a href="admin_messages.php"><i class="fa-solid fa-envelope"></i> Messages</a>
             <a href="admin_flights.php" class="active"><i class="fa-solid fa-plane"></i> Flight Data</a>
             <a href="admin_homepage.php"><i class="fa-solid fa-house"></i> Home Page</a>
             <a href="homepage.php" class="back-site"><i class="fa-solid fa-arrow-left"></i> Back to Site</a>
        </nav>
    </aside>

    <main class="main-content">
        <h2><?php echo $editMode ? "Edit Flight" : "Flight Management"; ?></h2>
        <br>

        <section class="stats-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
            <div class="stat-card">
                <i class="fa-solid fa-plane-departure icon-bg"></i>
                <h3 style="margin: 0; color: #666; font-size: 14px;">Total Flights</h3>
                <p style="font-size: 24px; font-weight: bold; margin: 10px 0 0 0;"><?php echo count($flights); ?></p>
            </div>
            <div class="stat-card">
                <i class="fa-solid fa-route icon-bg"></i>
                <h3 style="margin: 0; color: #666; font-size: 14px;">Active Routes</h3>
                <p style="font-size: 24px; font-weight: bold; margin: 10px 0 0 0;"><?php echo count(array_unique(array_column($flights, 'route'))); ?></p>
            </div>
            <div class="stat-card">
                <i class="fa-solid fa-euro-sign icon-bg"></i>
                <h3 style="margin: 0; color: #666; font-size: 14px;">Average Price</h3>
                <p style="font-size: 24px; font-weight: bold; margin: 10px 0 0 0;">€<?php echo (count($flights) > 0) ? round(array_sum(array_column($flights, 'price')) / count($flights)) : 0; ?></p>
            </div>
        </section>

        <section style="background: #fff; padding: 25px; border-radius: 8px; margin-bottom: 30px; border-top: 4px solid <?php echo $editMode ? '#f39c12' : '#00bcd4'; ?>;">
            <form action="admin_flights.php" method="POST" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-top: 20px;">
                <input type="hidden" name="flight_id" value="<?php echo $editMode ? $editFlight['id'] : ''; ?>">
                <input type="text" name="airline" placeholder="Airline" required value="<?php echo $editMode ? htmlspecialchars($editFlight['airline']) : ''; ?>" style="padding: 10px; border: 1px solid #ddd;">
                <input type="text" name="route" placeholder="Route" required value="<?php echo $editMode ? htmlspecialchars($editFlight['route']) : ''; ?>" style="padding: 10px; border: 1px solid #ddd;">
                <input type="time" name="time" required value="<?php echo $editMode ? $editFlight['flight_time'] : ''; ?>" style="padding: 10px; border: 1px solid #ddd;">
                <input type="text" name="duration" placeholder="Duration" required value="<?php echo $editMode ? htmlspecialchars($editFlight['duration']) : ''; ?>" style="padding: 10px; border: 1px solid #ddd;">
                <input type="number" step="0.01" name="price" placeholder="Price €" required value="<?php echo $editMode ? $editFlight['price'] : ''; ?>" style="padding: 10px; border: 1px solid #ddd;">
                <select name="stops" style="padding: 10px; border: 1px solid #ddd;">
                    <option value="0" <?php echo ($editMode && $editFlight['stops'] == 0) ? 'selected' : ''; ?>>Direct</option>
                    <option value="1" <?php echo ($editMode && $editFlight['stops'] == 1) ? 'selected' : ''; ?>>1 Stop</option>
                    <option value="2" <?php echo ($editMode && $editFlight['stops'] == 2) ? 'selected' : ''; ?>>2+ Stops</option>
                </select>
                <button type="submit" name="save_flight" class="btn-action" style="grid-column: span 2;">
                    <?php echo $editMode ? "UPDATE FLIGHT" : "SAVE FLIGHT"; ?>
                </button>
                <?php if($editMode): ?>
                    <a href="admin_flights.php" style="text-align:center; padding:12px; background:#eee; text-decoration:none; color:black; border-radius:4px;">Cancel</a>
                <?php endif; ?>
            </form>
        </section>

        <section style="background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f8f9fa;">
                    <tr>
                        <th style="padding: 15px; text-align: left;">Airline & Route</th>
                        <th style="padding: 15px; text-align: left;">Price</th>
                        <th style="padding: 15px; text-align: left;">Log Details</th> <th style="padding: 15px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($flights as $f): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px;">
                            <strong><?php echo htmlspecialchars($f['airline']); ?></strong><br>
                            <small><?php echo htmlspecialchars($f['route']); ?></small>
                        </td>
                        <td style="padding: 15px; font-weight: bold; color: #28a745;">€<?php echo number_format($f['price'], 2); ?></td>
                        
                        <td style="padding: 15px;">
                            <span class="admin-info">Created by: <span class="admin-name"><?php echo htmlspecialchars($f['admin_name'] ?? 'System'); ?></span></span>
                            <?php if(!empty($f['updated_by_name'])): ?>
                                <span class="admin-info">Last edit: <span class="admin-name"><?php echo htmlspecialchars($f['updated_by_name']); ?></span></span>
                            <?php endif; ?>
                        </td>

                        <td style="padding: 15px; text-align: center;">
                            <a href="admin_flights.php?edit=<?php echo $f['id']; ?>" class="btn-edit"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="admin_flights.php?delete=<?php echo $f['id']; ?>" class="btn-delete" onclick="return confirm('Delete?')"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</div>
</body>
</html>