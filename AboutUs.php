<!--
Brandon Hackett
Alexis Yang
Loreto E Eclevia
CSD460 Capstone in Software Development
Bellevue University
-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>

    <header>
        <nav>
            <ul>

                <li><a href="index.html">Home</a></li>
                <li class="active"><a href="AboutUs.php">About Us</a></li>
                <li><a href="Construction.html">Attractions</a></li>
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

    <!-- Opening Text -->
    <div class="our-story">
        <h1> About Us </h1>
        <p>Moffat Bay Lodge and Marina offers refined dining venues, a heated indoor pool, expansive accommodations, an opulent spa, and kid-friendly activities. The marina facilities have everything needed for a smooth and enjoyable boating trip. The lodge is located next to Joviedsa Island. Book now to experience what Moffat Bay has to offer.</p>
        <a href="landing_header.jpg">
        <center><img src="images/landing_header.jpg" width="1500"/></center><br>
        <p1> </p1>

    </div>
    <!-- Image Cascade -->
    <div class="imagelang">        

        <a href="images/playground.jpg">Your adventure starts here. Your children will also experience the most joyful playground at Moffat Bay. </a><br>
        <a href="images/whale-2.jpg"> Whale watching</a><br>
        <a href="images/whale-3.jpg"> Whale watching</a><br>
        <a href="images/hike-3.jpg"> Hiking</a><br>
        <a href="images/scuba.jpg"> Scuba diving.</a><br>
        <a href="images/reservation-1.jpg"> Select your room feature 1</a><br>
        <a href="images/reservation-2.jpg"> Select your room feature 2</a><br>
        <a href="images/double-queen.jpg"> Select your room size (all rooms are spacious)</a><br>

    </div>
        

    <section id="location">
        <h3>Location</h3>
        <shared src="shared/hike-3.jpg">
        <images src="/Moffat-Bay/shared/attrimages/map.png" alt="map" style="height: 600px; width: 800px;">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d2638.9196617269836!2d-122.97179092661662!3d48.59223709415396!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sus!4v1707408901777!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
             Located next to Broken is the beautiful Joviedsa Island
         </iframe>

    </section>

    <div class="reelEmIn">
        <h3>
            Immerse yourself in the serenity, luxury, and relaxation at Moffat Bay. Book now to experience what Moffat Bay has to offer!
        </h3>
        <shared src="shared/hike-3.jpg"
    </div>

    <!-- Contact Us -->
    <button class="bookNow" type="button">
        <a href="room_reservation.php">Book Now!</a>
    </button>

    <!-- Contact Us -->
    <div class="contactbg">

            <div class="contactform" id="contactform">
                <h2>Contact Us</h2>
                <form action="contactForm.php" method="post" id="contactForm">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message</label>
                <textarea id="message" name="message" required></textarea>

                <input type="submit" value="Send Message">
                </form> 
            </div>

            <div class="ourinfo">
                <h3>You may also reach us at: <a href="mailto:info@moffatbaylodge.com">info@moffatbaylodge.com</a> <br> or by phone at (123) 456-7890 .</h3>
                <br>
                <p>
                    460 Moffat Bay Dr <br>
                    Joviedsa Island, <br>
                    San Juan County, WA 98260
                </p>
            </div>
    </div>

    <!-- Footer -->
    <?php readfile("shared/footer.php"); ?>
</body>
</html>
