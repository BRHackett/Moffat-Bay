<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "admin";
$password = "pass";
$dbname = "moffatbay";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Query to get the user's reservation details
$stmt = $conn->prepare("SELECT reservation_date, start_date, end_date, status, payment_status, room_id, notes FROM Reservations WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reservations - Moffat Bay Lodge</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="AboutUs.php">About Us</a></li>
                <li><a href="Construction.html">Attractions</a></li>
                <li class="logo"><a href="index.html"><img src="https://github.com/BRHackett/Moffat-Bay/blob/main/src/images/Moffat-Bay_Logo.png?raw=true" alt="Moffat Bay Lodge Logo"></a></li>
                <li><a href="Construction.html">Lodging</a></li>
                <li><a href="Construction.html">Contact Us</a></li>
                <li class="active"><a href="my_reservations.php">My Reservations</a></li>
                <li><a href="index.html" class="login">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="reservations-section">
        <div class="reservations-container">
            <h1>My Reservations</h1>
            <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Reservation Date</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Payment Status</th>
                            <th>Room Type</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['reservation_date']); ?></td>
                                <td><?= htmlspecialchars($row['start_date']); ?></td>
                                <td><?= htmlspecialchars($row['end_date']); ?></td>
                                <td><?= htmlspecialchars($row['status']); ?></td>
                                <td><?= htmlspecialchars($row['payment_status']); ?></td>
                                <td><?= htmlspecialchars($row['room_id']); ?></td>
                                <td><?= htmlspecialchars($row['notes']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No reservations found.</p>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
