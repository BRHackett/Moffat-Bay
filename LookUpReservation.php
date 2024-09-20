<?php
$searched = false; // Initialize the variable

// Include the database configuration file to establish the connection *We don't have a config file
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $searched = false;
    $reservation_ID = $_POST['reservation_ID'];
    $email = $_POST['email'];

    //Querying the view for the reservation information
    $query = "SELECT * FROM reservationinfo WHERE reservation_id = '$reservation_ID' or email = '$email'";

    $result = $con->query($query);
    $searched = true;
}
?>

<!DOCTYPE html>
<!-- Team 2 : Capstone Project Room Reservation Page -->
<html lang="en">

<head>
    <title>CSD460 Capstone</title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://fonts.googleapis.com/css?family=Julius Sans One' rel='stylesheet'>
</head>

<body class="landing-page">
    <header>
        <nav>
            <ul>

                <li><a href="index.html">Home</a></li>
                <li class="active"><a href="AboutUs.php">About Us</a></li>
                <li><a href="attractions.php">Attractions</a></li>
                <li class="logo"><a href="index.html"><img src="https://github.com/BRHackett/Moffat-Bay/blob/main/src/images/Moffat-Bay_Logo.png?raw=true" alt="Moffat Bay Lodge Logo"></a></li>
                <li><a href="contact_us.php">Contact Us</a></li>
                <li><a href="room_reservation.php">Make a Reservation</a></li>
                <li><a href="my_reservations.php">My Reservations</a></li>
                <li><a href="login.php" class="login">Login/Register</a></li>
            </ul>
        </nav>
    </header>
    
    <?php
    readfile("shared/navigation.html");
    ?>
    <div id="container">
        <div class="card">
            <div class="card-title">
                <p>Reservation Lookup</p><br>
            </div>
            <div class="card-content">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <label for="reservation_ID">
                        Reservation ID:
                    </label>
                    <label>
                        <input type="text" id="reservation_ID" name="reservation_ID">
                    </label>
                    <label for="email">
                        Email:
                    </label>
                    <label>
                        <input type="text" id="email" name="email"><br>
                    </label><br><br>
                    <label>
                        <input type="submit" value="Find Your Reservation!">
                    </label>
                </form>
            </div>
            <div class="card-content left-text">
                <?php
                if ($searched == true) {
                    //Displaying the results
                    if ($result->num_rows > 0) {
                        echo "<br><br><table>
                    <th>Reservation ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Room Type</th>
                    <th>Check In Date</th>
                    <th>Check Out Date</th>
                    <th>Number of Guests</th>
                    <th>Nights Booked</th>
                    <th>Stay Total</th>
                    </tr>";
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['reservation_ID'] . "</td>";
                            echo "<td>" . $row['first_name'] . "</td>";
                            echo "<td>" . $row['last_name'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['room_type'] . "</td>";
                            echo "<td>" . $row['check_in_date'] . "</td>";
                            echo "<td>" . $row['check_out_date'] . "</td>";
                            echo "<td>" . $row['num_of_guests'] . "</td>";
                            echo "<td>" . $row['nights_booked'] . "</td>";
                            echo "<td>" . $row['stay_total'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<script>alert('No Reservations were found using that Email Address or Reservation ID');</script>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
