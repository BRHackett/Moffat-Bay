<?php
session_start();

if (!isset($_SESSION['reservation_data']) || !isset($_SESSION['user_id'])) {
    header("Location: room_reservation.php");
    exit;
}

$servername = "localhost";
$username = "admin";
$password = "pass";
$dbname = "moffatbay";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$reservation_data = $_SESSION['reservation_data'];
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['confirm'])) {
        $start_date = $reservation_data['start_date'];
        $end_date = $reservation_data['end_date'];
        $room_id = $reservation_data['room_id'];
        $notes = $reservation_data['notes'];
        
        $reservation_date = date("Y-m-d");
        $status = 'Pending';
        $payment_status = 'Unpaid';

        // Insert reservation
        $sql = "INSERT INTO Reservations (user_id, reservation_date, start_date, end_date, status, payment_status, room_id, notes)
                VALUES ('$user_id', '$reservation_date', '$start_date', '$end_date', '$status', '$payment_status', '$room_id', '$notes')";

        if (mysqli_query($conn, $sql)) {
            unset($_SESSION['reservation_data']); // Clear session after successful reservation
            header("Location: my_reservations.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } elseif (isset($_POST['cancel'])) {
        unset($_SESSION['reservation_data']);
        header("Location: room_reservation.php");
        exit;
    }
}

// Fetch room details
$sql = "SELECT room_category, room_type FROM Rooms WHERE room_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $reservation_data['room_id']);
$stmt->execute();
$stmt->bind_result($room_category, $room_type);
$stmt->fetch();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Summary - Moffat Bay Lodge</title>
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
                <li><a href="my_reservations.php">My Reservations</a></li>
                <li><a href="contact_us.php">Contact Us</a></li>
                <li><a href="login.php" class="login">Login/Register</a></li>
            </ul>
        </nav>
    </header>

    <section class="reservation-hero">
        <div class="reservation-hero-text">
            <h1>Reservation Summary</h1>
            <table>
                <tr>
                    <th>Room</th>
                    <td><?php echo htmlspecialchars($room_category . ' - ' . $room_type); ?></td>
                </tr>
                <tr>
                    <th>Check-in Date</th>
                    <td><?php echo htmlspecialchars($reservation_data['start_date']); ?></td>
                </tr>
                <tr>
                    <th>Check-out Date</th>
                    <td><?php echo htmlspecialchars($reservation_data['end_date']); ?></td>
                </tr>
                <tr>
                    <th>Notes</th>
                    <td><?php echo htmlspecialchars($reservation_data['notes']); ?></td>
                </tr>
            </table>
            <form method="post" class="reservation-actions">
                <button type="submit" name="confirm" class="button">Confirm Reservation</button>
                <button type="submit" name="cancel" class="button cancel">Cancel</button>
            </form>
        </div>
    </section>
</body>
</html>

<?php
$conn->close();
?>
