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
    <!--Temporary: Navigation Bar ( Alex and Brandon, please let me know if this is ok and please feel free to add anything so I can finalize it tomorrow after work! Thank you-->


<header>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="Construction.html">About Us</a></li>
                <li><a href="Construction.html">Attractions</a></li>
                <li><a href="Construction.html">Lodging</a></li>
                <li><a href="Construction.html">Contact Us</a></li>
                <li><a href="Construction.html">My Reservations</a></li>
                <li class="active"><a href="#" class="login">Login / Register</a></li>
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
            <!--Needs proof reading and group's approval 1--> 
            Nestled on the picturesque Joviedsa Island, part of the stunning San Juan Islands, Moffat Bay Lodge and Marina is a hidden gem that exudes beauty straight out of a magazine. Surrounded by crystal-clear waters and lush green forests, this tranquil oasis offers a retreat like no other.
        </p>
        <br/>
        <p>
            <!--Needs proof reading and group's approval 2--> 
            The heart of Moffat Bay Lodge lies in its dedicated and friendly staff, who strive to make every guest's stay unforgettable. From the moment you arrive, you'll be greeted with warm smiles and impeccable service, ensuring that your every need is met with care and attention.
        </p> 

    </div>
    <!-- Image Cascade -->
    <div class="image-cascade">        

        <div class="firstpic">
        <p>
            <!--Temporary: Needs proof reading and group's approval 3--> 
            Embark on a gastronomic adventure at our refined dining venues, where fresh ingredients from local sources and meticulously prepared dishes harmonize to deliver a culinary masterpiece. Whether you're relishing a meal at our sophisticated restaurant or enjoying a laid-back snack by the marina, each dish is a sensory delight. 
        </p>
            <img src="shared/attrimages/fullchef.jpg" alt="Moffat Bay Lodge and Marina">

        </div>
        <div class="secondpic">           
            <p>
                <!--Needs proof reading and group's approval 4--> 
                Soothe and de-stress in our heated indoor pool, where you can immerse yourself in the peaceful ambiance and let your worries dissolve.  


            </p>

            <img src="shared/attrimages/indoor heated pool.jpg" alt="Moffat Bay Lodge and Marina">

        </div>
        <div class="thirdpic">
            <p>
                <!--Temporary: Needs proof reading and group's approval 5--> 
                Discover our expansive accommodations featuring a variety of beds, from double full to king, catering to every traveler's preference. Whether you're traveling alone, with a partner, or with friends or family, our spaces can comfortably host up to 5 guests. 
            </p>
            <img src="shared/attrimages/sasha-kaunas-67-sOi7mVIk-unsplash.jpg" alt="Moffat Bay Lodge and Marina">
            
        </div>

        <div class="fourthpic">
            <p>
            <!--Temporary: Needs proof reading and group's approval 6--> 
            Treat yourself to the pinnacle of relaxation at Moffat Bay Lodge and Marina's opulent spa. Our spa provides a serene retreat for those in search of renewal and calm. Indulge in a luxurious massage, a refreshing facial, or a relaxing body treatment, all by our proficient and seasoned therapists. 


            <img src="shared/attrimages/spa.jpg" alt="Moffat Bay Lodge and Marina">
            
        </div>

        <div class="fifthpic">
            <p>
            <!--Temporary: Needs proof reading and group's approval 7--> 
            Moffat Bay Lodge and Marina warmly welcomes families, with our playground and kid-friendly activities guaranteed to entertain children for hours. Let your kids have fun on the playground, complete with slides, swings, and climbing structures, or participate in our organized events like arts and crafts, scavenger hunts, or nature walks. 
            </p>
            <img src="shared/attrimages/playground.jpg" alt="Moffat Bay Lodge and Marina">
            
        </div>

        <div class="sixthpic">
            <p>
            <!--Temporary: Needs proof reading and group's approval Message 8--> 
            For boating enthusiasts, Moffat Bay Lodge and Marina's marina facilities have everything you need for a smooth and enjoyable boating trip. Fuel your boat at our accessible fuel docks, or have it serviced and repaired by our skilled technicians. Shop for all your boating and sailing needs at our on-site stores, offering a wide selection from fishing equipment to boat accessories. 



            <img src="shared/attrimages/marina1.jpg" alt="Moffat Bay Lodge and Marina">
            
        </div>
    </div>


    <!-- Temporary: for Location Map. Brandon, Alexis please let me know What you think or feel free to make any changes so Once I get your feedback regarding this "About Us" page! -->
    <section id="location">
        <h2>Location</h2>
        <img src="/Moffat-Bay/shared/attrimages/map.png" alt="map" style="height: 600px; width: 800px;">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d2638.9196617269836!2d-122.97179092661662!3d48.59223709415396!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sus!4v1707408901777!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            <!--Temporary Message 9 --> Located next to Broken is the beautiful Joviedsa Island<!--Message 9: Let me know what Island features  -->  </iframe>
    </section>


    <div class="reelEmIn">
        <h3>
            <!--Message 10: Feel free to make changes. I will finalize it based on your feedback. But I think this is ok but I'll wait for your feedback! Or feel free to edit it accordngly!--> 
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
                <h3>You may also reach us at: <a href="mailto:info@moffatbaylodge.com">info@moffatbaylodge.com</a> <br> or by phone at (999) 999-Nevermind.</h3>
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
