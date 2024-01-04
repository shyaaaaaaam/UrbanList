<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UrbanList - Modern Property Listings</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: white;
        }

        header {
            background-color: goldenrod;
            color: white;
            padding: 1em;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .company-logo {
            width: 50px;
            height: auto;
            margin-right: 1em;
        }

        .company-name {
            font-size: 1.8em;
            font-weight: bold;
            line-height: 1;
            margin: 0;
        }

        button {
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            background-color: white;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: skyblue;
        }

        .action-buttons {
            display: flex;
            gap: 0em;
        }

        .action-buttons button {
            border: none;
            padding: 0.5em 1em;
            border-radius: 4px;
            margin-right: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .action-buttons button:hover {
            background-color: skyblue;
        }

        fieldset {
            background-color: grey;
            border: none;
            border-radius: 2px;
            margin-bottom: 12px;
            overflow: hidden;
            padding: 0 .625em;
        }

        label {
            font-family: "tahoma";
            cursor: pointer;
            display: inline-block;
            padding: 3px 6px;
            text-align: left;
            width: 150px;
            vertical-align: top;
            color: grey;
        }

        input {
            font-size: inherit;
            display: inline-block;
            text-align: center;
            vertical-align: center;
            margin: 0 auto;
        }

        .head {
            text-align: center;
            color: grey;
        }

        .sa {
            text-align: center;
        }

        .touchbot {
            margin-top: auto;
            padding-top: 20px;
        }

        .image-details-container {
            display: flex;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .image-frame {
            flex: 0 0 500px;
            max-width: 500px;
            overflow: hidden;
        }

        .image-slider {
            position: relative;
            overflow: hidden;
        }

        .slider-images {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slider-image-container {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .slider-image {
            width: 100%;
            height: auto;
        }

        .slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.5em;
            cursor: pointer;
            background-color: transparent;
            border: none;
            color: white;
        }

        .prev-btn {
            left: 10px;
        }

        .next-btn {
            right: 10px;
        }

        .details {
            flex: 1;
            padding: 20px;
        }
        
        footer {
            text-align: center;
            padding: 10px;
            background-color: goldenrod;
            color: white;
        }
    </style>
</head>

<body>
    <header>
        <div>
            <a href="property.php" style="text-decoration: none; color: inherit;">
                <img src="logo.png" alt="Company Logo" class="company-logo">
                <span class="company-name">UrbanList</span>
            </a>
        </div>

        <div class="action-buttons">
            <button onclick="location.href='property.php';">Home</button>
            <button onclick="toggleMode()">Change Mode</button>
            <button id="edt" onclick="edit()" hidden>Edit Listing</button>
            <button onclick="logoutf()">Log Out</button>
        </div>

    </header>
    
    <div class="image-details-container">
        <div class="image-frame">
            <div class="image-slider">
                <div class="slider-images">
                    <?php
                    $con = mysqli_connect("localhost", "root", "", "property");
                    $userid = $_COOKIE["id"];
                    $name = $_COOKIE["name"];
                    $id = $_GET['listing_id'];
        
                    $result = mysqli_query($con, "SELECT * FROM listingdata WHERE id = $id");
                    if ($row = mysqli_fetch_assoc($result)) {
                        if ($userid == $row['userid']) {
                            echo '<script>document.getElementById("edt").hidden = false;</script>';
                        }
                        $images = $row['images'];
                        $images = explode(',', $images);
                        foreach ($images as $image) {
                            $trimmedImage = trim($image);
                            $imagePath = 'uploads/' . $trimmedImage;
                            if (file_exists($imagePath)) {
                                echo '<div class="slider-image-container">';
                                echo '<img class="slider-image" src="' . $imagePath . '" alt="Property Image">';
                                echo '</div>';
                            } else {
                                $html .= '<p>Image not found: ' . $imagePath . '</p>';
                            }
                        }
                    }
                    ?>
                </div>
                <button class="slider-btn prev-btn" onclick="prevSlide(this); stopPropagation(event)">❮</button>
                <button class="slider-btn next-btn" onclick="nextSlide(this); stopPropagation(event)">❯</button>
            </div>
        </div>

        <div class="details">
            <?php
            $con = mysqli_connect("localhost", "root", "", "property");
            $email = $_COOKIE["email"];
            $name = $_COOKIE["name"];
            $id = $_GET['listing_id'];
            $pn = $row["phone"];
            $title = $row["title"];
            $descrip = $row["descrip"];
            $city = $row["city"];
            $state = $row["stat"];
            $state = ucfirst($state);
            $address = $row["addy"];
            $bhk = $row["bhk"];
            $price = $row["price"];
            $purpose = strtoupper($row["purpose"]);
            $sqft = $row["sqft"];
            $advance = $row["advance"];
            $parking = $row["parking"];
            $floor = $row["floor"];
            $balcony = $row["balcony"];
            $date = date("d/m/Y");
            $age = $row["age"];
            $bathroom = $row["bathroom"];
            $secure = $row["secure"];
            if ($secure == true) {
                $secure = "Yes";
            } else {
                $secure = "No";
            }
            $elevator = $row["elevator"];
            if ($elevator == true) {
                $elevator = "Yes";
            } else {
                $elevator = "No";
            }

            $result = mysqli_query($con, "SELECT * FROM listingdata WHERE id = $id");
            if ($row = mysqli_fetch_assoc($result)) {
                echo '<table border="1" style="color: goldenrod;">';
                echo '<tr><th colspan="2">Property Details</th></tr>';
                echo '<tr><td>Title</td><td>' . $row['title'] . '</td></tr>';
                echo '<tr><td>Name</td><td>' . $name . '</td></tr>';
                echo '<tr><td>Email</td><td>' . $email . '</td></tr>';
                echo '<tr><td>Phone</td><td>' . $pn . '</td></tr>';
                echo '<tr><td>Description</td><td>' . $descrip . '</td></tr>';
                echo '<tr><td>City</td><td>' . $city . '</td></tr>';
                echo '<tr><td>State</td><td>' . $state . '</td></tr>';
                echo '<tr><td>Address</td><td>' . $address . '</td></tr>';
                echo '<tr><td>BHK</td><td>' . $bhk . '</td></tr>';
                echo '<tr><td>Price</td><td>' . $price . '</td></tr>';
                echo '<tr><td>Purpose</td><td>' . $purpose . '</td></tr>';
                echo '<tr><td>Sqft</td><td>' . $sqft . '</td></tr>';
                echo '<tr><td>Advance</td><td>' . $advance . '</td></tr>';
                echo '<tr><td>Parking</td><td>' . $parking . '</td></tr>';
                echo '<tr><td>Floor</td><td>' . $floor . '</td></tr>';
                echo '<tr><td>Balcony</td><td>' . $balcony . '</td></tr>';
                echo '<tr><td>Age</td><td>' . $age . '</td></tr>';
                echo '<tr><td>Bathroom</td><td>' . $bathroom . '</td></tr>';
                echo '<tr><td>Elevator</td><td>' . $elevator . '</td></tr>';
                echo '<tr><td>Secure</td><td>' . $secure . '</td></tr>';
                echo '<tr><td>Date</td><td>' . $date . '</td></tr>';
                echo '</table>';
            }

            mysqli_close($con);
            ?>
        </div>
    </div>

    <script>
        function edit() {
            var id = getListingIdFromUrl();
            var url = 'edit.php?listing_id=' + id;
            window.location.href = url;
        }

        function check(input) {
            if (document.getElementById('rpassword').value != document.getElementById('password').value) {
                input.setCustomValidity('Password Must be Matching.');
            } else {
                input.setCustomValidity('');
            }
            if (document.getElementById('title').value > 499) {
                input.setCustomValidity('Text Length Too Long! Please Limit Within 500!');
            } else {
                input.setCustomValidity('');
            }
            if (document.getElementById('descrip').value > 9999) {
                input.setCustomValidity('Text Length Too Long! Please Limit Within 10000!');
            } else {
                input.setCustomValidity('');
            }
        }

        function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function getCookie(cname) {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for (let i = 0; ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function logoutf() {
            setCookie("email", "", 0);
            setCookie("password", "", 0);
            setCookie("name", "", 0);
            setCookie("phone", "", 0);
            window.open("front.html","_self");
        }

        function toggleMode() {
            if (getCookie("backgroundColor") === 'white') {
                document.body.style.backgroundColor = '#000';
                setCookie('backgroundColor', 'black', 30);
            } else {
                document.body.style.backgroundColor = '#fff';
                setCookie('backgroundColor', 'white', 30);
            }
        }

        function updateSliderButtons(slider) {
            const prevBtn = slider.parentElement.querySelector('.prev-btn');
            const nextBtn = slider.parentElement.querySelector('.next-btn');
            const slideWidth = slider.children[0].offsetWidth;
            const currentOffset = parseFloat(slider.style.transform.slice(11)) || 0;

            prevBtn.style.display = 'block';
            nextBtn.style.display = 'block';
        }

        function prevSlide(btn) {
            const slider = btn.parentElement.querySelector('.slider-images');
            const slideWidth = slider.children[0].offsetWidth;
            const currentOffset = parseFloat(slider.style.transform.slice(11)) || 0;
            const newOffset = Math.min(currentOffset + slideWidth, 0);
            slider.style.transform = `translateX(${newOffset}px)`;
            updateSliderButtons(slider);
            updateSliderButtons(slider);
        }

        function nextSlide(btn, event) {
            const slider = btn.parentElement.querySelector('.slider-images');
            const slideWidth = slider.children[0].offsetWidth;
            const currentOffset = parseFloat(slider.style.transform.slice(11)) || 0;
            const newOffset = Math.max(currentOffset - slideWidth, -(slider.children.length - 1) * slideWidth);
            slider.style.transform = `translateX(${newOffset}px)`;
            updateSliderButtons(slider);
            updateSliderButtons(slider);
        }

        function stopPropagation(event) {
            event.stopPropagation();
        }

        function getListingIdFromUrl() {
            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get('listing_id');
            return id;
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (!getCookie('backgroundColor')) {
                setCookie("backgroundColor", "white", 60000)
            }
            if (getCookie("backgroundColor") == "white") {
                document.body.style.backgroundColor = "white";
            } else {
                document.body.style.backgroundColor = "black";
            }
            const sliders = document.querySelectorAll('.slider-images');
            sliders.forEach(slider => updateSliderButtons(slider));
        });
    </script>
</body>

<footer>
    &copy; 2024 UrbanList. All rights reserved.
</footer>

</html>
