<!--
Brandon Hackett
Alexis Yang
Loreto E Eclevia
Group 3
Bellevue University
Date:
-->

<!--DOCTYPE html-->


<html>
<head>
  <meta charset="UTF-8">
  <title>About Us - Moffat Bay Lodge and Marina</title>
  <link rel="icon" type="image/x-icon" href="/Moffat-Bay/shared/transparent-logo.png">
  <link href="shared/aboutUs.css" rel="stylesheet">
</head>

<body>
   
    <header>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li> 
                <li><a href="Construction.html">Lodging</a></li>
<<<<<<< HEAD
                <li class="active"><a href="#">About Us</a></li>
                <li><a href="Construction.html">My Reservations</a></li>
                <li class="active"><a href="login.php" class="login">Login / Register</a></li>
=======
                <li><a href="Construction.html">About Us</a></li>
                <li><a href="Construction.html">My Reservations</a></li>
                <li class="active"><a href="#" class="login">Login / Register</a></li>
>>>>>>> c91713288c9cf0ca4b4c318642db06c8178b8cea
                <li><a href="Construction.html">Attractions</a></li>
                <li><a href="Construction.html">Contact Us</a></li>
            </ul>
        </nav>
    </header>

    <?php
        readfile("shared/navigation.html");
    ?>

    <!-- Opening Text -->
    <div class="our-story">
        <h1> ABOUT US </h1>
        <span class="line"></span>
        <p> 
            Nestled on the picturesque Joviedsa Island, part of the stunning San Juan Islands, Moffat Bay Lodge and Marina is a hidden gem that exudes beauty straight out of a magazine. Surrounded by crystal-clear waters and lush green forests, this tranquil oasis offers a retreat like no other.
        </p>
        <br/>
        <p>
            The heart of Moffat Bay Lodge lies in its dedicated and friendly staff, who strive to make every guest's stay unforgettable. From the moment you arrive, you'll be greeted with warm smiles and impeccable service, ensuring that your every need is met with care and attention.
        </p> 

    </div>
    <!-- Image Cascade -->
    <div class="image-cascade">        

        <div class="firstpic">
        <p> 
            Experience refined dining experiences with fresh local ingredients and meticulously prepared dishes at our sophisticated and laid-back venues.
        </p>
            <img src="shared/attrimages/fullchef.jpg" alt="Moffat Bay Lodge and Marina">

        </div>
        <div class="secondpic">           
            <p> 
                Soothe and de-stress in our heated indoor pool, where you can immerse yourself in the peaceful ambiance and let your worries dissolve.  


            </p>

            <img src="shared/attrimages/indoor heated pool.jpg" alt="Moffat Bay Lodge and Marina">

        </div>
        <div class="thirdpic">
            <p> 
                Expansive accommodations with various bed sizes for up to 5 guests, suitable for solo travelers, partners, friends, or family.
            </p>
            <img src="shared/attrimages/sasha-kaunas-67-sOi7mVIk-unsplash.jpg" alt="Moffat Bay Lodge and Marina">
            
        </div>

        <div class="fourthpic">
            <p> 
            Moffat Bay Lodge and Marina's Spa offers luxurious massages, facials, and body treatments by experienced therapists for relaxation.


            <img src="shared/attrimages/spa.jpg" alt="Moffat Bay Lodge and Marina">
            
        </div>

        <div class="fifthpic">
            <p> 
            Moffat Bay Lodge and Marina offers a playground and kid-friendly activities for families, including arts and crafts and nature walks.
            </p>
            <img src="shared/attrimages/playground.jpg" alt="Moffat Bay Lodge and Marina">
            
        </div>

        <div class="sixthpic">
            <p> 
            Moffat Bay Lodge and Marina offers a range of facilities for boating enthusiasts, including fuel docks, on-site stores, and skilled technicians.

            <img src="shared/attrimages/marina1.jpg" alt="Moffat Bay Lodge and Marina">
            
        </div>
    </div>

    <section id="location">
        <h2>Location</h2>
        <img src="/Moffat-Bay/shared/attrimages/map.png" alt="map" style="height: 600px; width: 800px;">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d2638.9196617269836!2d-122.97179092661662!3d48.59223709415396!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sus!4v1707408901777!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
             Located next to Broken is the beautiful Joviedsa Island
         </iframe>

    </section>

    <div class="reelEmIn">
        <h3>
            Immerse yourself in the serenity, luxury, and relaxation at Moffat Bay. Book now to experience what Moffat Bay has to offer!
        </h3>
    </div>

    <!-- Book Now Button -->
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
                <h3>You may also reach us at: <a href="mailto:info@moffatbaylodge.com">info@moffatbaylodge.com</a> <br> or by phone at (562) 810-5815.</h3>
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
