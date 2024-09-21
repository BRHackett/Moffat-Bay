<?php
$searched = false;

$servername = "localhost";
$username = "admin";
$password = "pass";
$dbname = "moffatbay";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reservation_ID = $_POST['reservation_ID'];
    $email = $_POST['email'];

    $sql = "SELECT r.reservation_id, u.first_name, u.last_name, u.email, rm.room_category, rm.room_type, r.start_date, r.end_date
            FROM Reservations r
            JOIN User u ON r.user_id = u.user_id
            JOIN Rooms rm ON r.room_id = rm.room_id
            WHERE r.reservation_id = ? OR u.email = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $reservation_ID, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $searched = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservation Lookup</title>
</head>
<body>
    <h1>Find Your Reservation</h1>

    <form method="post">
        <label for="reservation_ID">Reservation ID:</label>
        <input type="text" name="reservation_ID" id="reservation_ID"><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email"><br>

        <button type="submit">Find Reservation</button>
    </form>

    <?php if ($searched): ?>
        <?php if ($result->num_rows > 0): ?>
            <h2>Reservation Details</h2>
            <table>
                <thead>
                    <tr>
                        <th>Reservation ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Room Type</th>
                        <th>Check-in Date</th>
                        <th>Check-out Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['reservation_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['room_category'] . ' - ' . $row['room_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No reservation found with the given information.</p>
        <?php endif; ?>
    <?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
