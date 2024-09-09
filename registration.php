<?php
// Start session
session_start();

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

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
    $country = $_POST['country'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate phone number (must be 10 digits)
    if (!preg_match('/^\d{10}$/', $phone)) {
        $error_message = "Phone number must be exactly 10 digits.";
    }
    // Validate username and password on the server side
    elseif (strlen($username) < 6) {
        $error_message = "Username must be at least 6 characters long.";
    } elseif (!preg_match('/^(?=.*[0-9]).{8,}$/', $password)) {
        $error_message = "Password must be at least 8 characters long and include at least 1 number.";
    } else {
        // Hash the password
        $password_hash = hash("sha256", $password);

        // Insert into User table
        $stmt = $conn->prepare("INSERT INTO User (first_name, last_name, email, phone, address, city, state, zip_code, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $first_name, $last_name, $email, $phone, $address, $city, $state, $zip_code, $country);

        if ($stmt->execute()) {
            // Get the last inserted user_id
            $user_id = $conn->insert_id;

            // Insert into Login table
            $login_stmt = $conn->prepare("INSERT INTO Login (user_id, username, password_hash) VALUES (?, ?, ?)");
            $login_stmt->bind_param("iss", $user_id, $username, $password_hash);

            if ($login_stmt->execute()) {
                // Registration successful, redirect to login page
                header("Location: login.php");
                exit();
            } else {
                $error_message = "Error inserting into Login table.";
            }
            $login_stmt->close();
        } else {
            $error_message = "Error inserting into User table.";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moffat Bay Lodge - Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="Construction.html">About Us</a></li>
                <li><a href="Construction.html">Attractions</a></li>
                <li class="logo"><a href="index.html"><img src="https://github.com/BRHackett/Moffat-Bay/blob/main/src/images/Moffat-Bay_Logo.png?raw=true" alt="Moffat Bay Lodge Logo"></a></li>
                <li><a href="Construction.html">Lodging</a></li>
                <li><a href="Construction.html">Contact Us</a></li>
                <li><a href="Construction.html">My Reservations</a></li>
                <li class="active"><a href="login.php" class="login">Login / Register</a></li>
            </ul>
        </nav>
    </header>

    <section class="register-section">
        <div class="register-container">
            <h1>Register</h1>
            <?php if (!empty($error_message)): ?>
                <p class="error"><?= $error_message ?></p>
            <?php endif; ?>
            <form action="registration.php" method="POST" onsubmit="return validateForm()">
                <div class="form-group">
                    <label>
          First Name:
          </label>
          <label>
          <input type="text" id="first_name" name="first_name"required>
          </label><br><br>
                </div>
                <div class="form-group">
                    <label>
          Last Name:
          </label>
          <label>
          <input type="text" id="last_name" name="last_name"required><br>
                </div>
                <div class="form-group">
                    <label><br>

          Address:
          </label>
          <label>
          <input type="text" id="Address" name="Address"required><br>
                </div>
                <div class="form-group">
                    <label><br>
         City:
          </label>
          <label>
          <input type="text" id="City" name="City"required>
          </label>
                </div>
                <div class="form-group">
                    <label><br>

            <div class="form-group">
                    <label for="state">State:</label>
                    <select id="state" name="state" required>
                        <option value="">Select a state</option>
                        <option value="AL">AL</option>
                        <option value="AK">AK</option>
                        <option value="AZ">AZ</option>
                        <option value="AR">AR</option>
                        <option value="CA">CA</option>
                        <option value="CO">CO</option>
                        <option value="CT">CT</option>
                        <option value="DE">DE</option>
                        <option value="FL">FL</option>
                        <option value="GA">GA</option>
                        <option value="HI">HI</option>
                        <option value="ID">ID</option>
                        <option value="IL">IL</option>
                        <option value="IN">IN</option>
                        <option value="IA">IA</option>
                        <option value="KS">KS</option>
                        <option value="KY">KY</option>
                        <option value="LA">LA</option>
                        <option value="ME">ME</option>
                        <option value="MD">MD</option>
                        <option value="MA">MA</option>
                        <option value="MI">MI</option>
                        <option value="MN">MN</option>
                        <option value="MS">MS</option>
                        <option value="MO">MO</option>
                        <option value="MT">MT</option>
                        <option value="NE">NE</option>
                        <option value="NV">NV</option>
                        <option value="NH">NH</option>
                        <option value="NJ">NJ</option>
                        <option value="NM">NM</option>
                        <option value="NY">NY</option>
                        <option value="NC">NC</option>
                        <option value="ND">ND</option>
                        <option value="OH">OH</option>
                        <option value="OK">OK</option>
                        <option value="OR">OR</option>
                        <option value="PA">PA</option>
                        <option value="RI">RI</option>
                        <option value="SC">SC</option>
                        <option value="SD">SD</option>
                        <option value="TN">TN</option>
                        <option value="TX">TX</option>
                        <option value="UT">UT</option>
                        <option value="VT">VT</option>
                        <option value="VA">VA</option>
                        <option value="WA">WA</option>
                        <option value="WV">WV</option>
                        <option value="WI">WI</option>
                        <option value="WY">WY</option>
                    </select><br><br>
                </div>
                <label>
         Zip Code:
          </label>
          <label>
          <input type="text" id="Zip Code" name="Zip Code"required>
          </label><br><br>
         
         <label>
         Country:
          </label>
          <label>
          <input type="text" id="Country" name="Country"required>
          </label><br><br>
                
                <div class="form-group">
                    <label>
          Create a Username:
          </label>
          <label>
          <input type="text" id="email" name="email"required>
          </label>
          <label>
          Create a Password:
          </label>
          <label>
          <input type="password" id="password" name="password"required>
          <input type="checkbox" onclick="togglePaswd()">Show Password<br><br>
          </label>

                </div>
    
        <div class="card-content">
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          
          <label>
          <input type="submit" value="Register Now!">
          </label>
        </form>
        </div>
      </div>
    </div>
    <script type="text/JavaScript">
    // Change the input type so the user can see the entered password
    function togglePaswd() {
      var x = document.getElementById("password");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }

    // Change the input type so the user can see the entered confirmation password
    function toggleCpaswd() {
      var y = document.getElementById("cpassword");
      if (y.type === "password") {
        y.type = "text";
      } else {
        y.type = "password";
      }
    }
    
    
    </script>
</body>
</html>
