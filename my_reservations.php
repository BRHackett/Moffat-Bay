<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
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

// Fetch the user's first and last name from the User table
$sql = "SELECT first_name, last_name FROM User WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name);
$stmt->fetch();
$stmt->close();

// Handle reservation cancellation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_reservation'])) {
    $reservation_id = $_POST['reservation_id'];

    // Simply update the reservation status to 'Cancelled' (trigger will handle room availability)
    $sql_cancel = "UPDATE Reservations SET status = 'Cancelled' WHERE reservation_id = ?";
    $stmt_cancel = $conn->prepare($sql_cancel);
    $stmt_cancel->bind_param("i", $reservation_id);
    $stmt_cancel->execute();
    $stmt_cancel->close();
}

// Query to get the user's reservation details, including room description
$stmt = $conn->prepare("
    SELECT r.reservation_id, r.reservation_date, r.start_date, r.end_date, r.status, r.payment_status, rm.room_category, rm.room_type, rm.description, r.notes, rm.room_id
    FROM Reservations r
    JOIN Rooms rm ON r.room_id = rm.room_id
    WHERE r.user_id = ? AND r.status != 'Cancelled'
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Initialize search variables for lookup
$searched = false;
$search_result = null;

// Handle reservation lookup submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['reservation_ID']) || isset($_POST['email']))) {
    $searched = true;
    $reservation_ID = $_POST['reservation_ID'];
    $email = $_POST['email'];

    // Perform lookup using either reservation ID or email
    $lookup_sql = "SELECT r.reservation_id, u.first_name, u.last_name, u.email, rm.room_category, rm.room_type, rm.description, r.start_date, r.end_date, r.status
                   FROM Reservations r
                   JOIN Rooms rm ON r.room_id = rm.room_id
                   JOIN User u ON r.user_id = u.user_id
                   WHERE r.reservation_id = ? OR u.email = ?";
    
    $stmt_lookup = $conn->prepare($lookup_sql);
    $stmt_lookup->bind_param("is", $reservation_ID, $email);
    $stmt_lookup->execute();
    $search_result = $stmt_lookup->get_result();
}

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
                <li><a href="attractions.php">Attractions</a></li>
                <li class="logo"><a href="index.html"><img src="https://github.com/BRHackett/Moffat-Bay/blob/main/src/images/Moffat-Bay_Logo.png?raw=true" alt="Moffat Bay Lodge Logo"></a></li>
                <li><a href="room_reservation.php">Lodging</a></li>
                <li class="active"><a href="my_reservations.php">My Reservations</a></li>
                <li><a href="contact_us.php">Contact Us</a></li>
                <li><a href="logout.php" class="login">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- User's Reservations Section -->
    <section class="reservation-hero">
        <div class="reservation-hero-text">
            <h1><?php echo htmlspecialchars((isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'Guest') . ' ' . (isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '')); ?>'s Reservations</h1>
            <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Reservation ID</th>
                            <th>Room Type</th>
                            <th>Room Description</th>
                            <th>Check-in Date</th>
                            <th>Check-out Date</th>
                            <th>Status</th>
                            <th>Payment Status</th>
                            <th>Notes</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['reservation_id']); ?></td>
                                <td><?= htmlspecialchars($row['room_category'] . ' - ' . $row['room_type']); ?></td>
                                <td><?= htmlspecialchars($row['description']); ?></td>
                                <td><?= htmlspecialchars($row['start_date']); ?></td>
                                <td><?= htmlspecialchars($row['end_date']); ?></td>
                                <td><?= htmlspecialchars($row['status']); ?></td>
                                <td><?= htmlspecialchars($row['payment_status']); ?></td>
                                <td><?= htmlspecialchars($row['notes']); ?></td>
                                <td>
                                    <form method="post" action="">
                                        <input type="hidden" name="reservation_id" value="<?= $row['reservation_id']; ?>">
                                        <button type="submit" name="cancel_reservation" class="button cancel">Cancel</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No reservations found.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Lookup Section -->
<section class="lookup-hero">
    <div class="lookup-hero-text">
        <h1>Can't see your reservation?</h1>
	<p>Look it up by using your email or Reservation number.</p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="reservation_ID">Reservation ID:</label>
            <input type="text" name="reservation_ID" id="reservation_ID"><br>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email"><br>

            <button type="submit" class="button lookup">Find Reservation</button>
        </form>
    </div>
</section>

<!-- Display the search results -->
<?php if ($searched): ?>
    <section class="lookup-result">
        <div class="lookup-hero-text">
            <?php if ($search_result && $search_result->num_rows > 0): ?>
                <h3>Search Results:</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Reservation ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Room Type</th>
                            <th>Room Description</th>
                            <th>Check-in Date</th>
                            <th>Check-out Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $search_result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['reservation_id']); ?></td>
                                <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td><?= htmlspecialchars($row['room_category'] . ' - ' . $row['room_type']); ?></td>
                                <td><?= htmlspecialchars($row['description']); ?></td>
                                <td><?= htmlspecialchars($row['start_date']); ?></td>
                                <td><?= htmlspecialchars($row['end_date']); ?></td>
                                <td><?= htmlspecialchars($row['status']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No reservation found with the given information.</p>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
