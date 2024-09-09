<?php
// Include the database configuration file to establish the connection
include 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ($password == $cpassword) {
      // Query to check if the user exists
      $query = "SELECT * FROM Guests WHERE first_name = '$first_name' OR last_name = '$last_name' OR telephone = '$telephone' AND email = '$email' OR password = '$password'";

      $result = $con->query($query);

      // Check if the query executed successfully
      if ($result) {

          // Check if the user exists
          if ($result->num_rows > 0) {
            // User already exist, display an error message
            echo "<script>alert('The information you entered already exist');</script>";
          } else {
            // Prepare SQL Query to Insert user data into the database
            $query = "INSERT INTO Guests (first_name,last_name,telephone,email,password) VALUES ('$first_name','$last_name', '$telephone', '$email', '$password')";

            // Display at the top of Register page
            // that the data was entered correctly.
            if ($con->query($query)){
              //printf("Record inserted succesfully");
              echo "<script>alert('Record inserted succesfully');</script>";
            }
            // Display a message at the top of Register page
            // that the data was NOT entered into the database.
            if ($con->errno) {
              printf("WARNING!!! Could not insert record into table: %s  WARNING!!! <br />", $con->error);
            }
          }
      } else {
          // Query execution failed, display an error message
          echo "<script>alert('Error: " . $con->error . "');</script>";
      }
    } else {
      // User password  do not match, display an error message
      echo "<script>alert('WARNING!!! The passwords you entered did not match WARNING!!! ');</script>";
    }
}
?>


    </script>
</body>
</html>
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
          <label>
          Confirm Password:
          </label>
          <label>
          <input type="password" id="cpassword" name="cpassword"required>
          <input type="checkbox" onclick="toggleCpaswd()">Show Password<br><br>
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
    
