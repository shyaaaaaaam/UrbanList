<?php
    $con = mysqli_connect("localhost", "root", "", "property");

    if (!$con) {
        die(json_encode(['status' => 'error', 'message' => 'Database connection error']));
    }

    $email = $_COOKIE["email"];
    $password = $_COOKIE["password"];

    $validateUser = mysqli_query($con, "SELECT * FROM userdata WHERE email = '$email' AND pword = '$password';");

    if (!$validateUser || mysqli_num_rows($validateUser) == 0) {
        setcookie("id", "", 0, "/");
        setcookie("email", "", 0, "/");
        setcookie("password", "", 0, "/");
        setcookie("name", "", 0, "/");
        setcookie("phone", "", 0, "/");
        mysqli_close($con);
        header("Location: login.php");
        exit;
    }

    mysqli_close($con);
?>


<!DOCTYPE html>
<html>

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

        #welcomemessage {
            font-size: 1.8em;
            font-weight: bold;
            margin: 0;
        }

        .tab {
            float: left;
            border: 1px solid white;
            background-color: goldenrod;
            width: 17%;
            height: 800px;
        }

        .tab button {
            display: block;
            background-color: inherit;
            color: black;
            padding: 22px 16px;
            width: 100%;
            border: none;
            outline: none;
            text-align: left;
            cursor: pointer;
            transition: 0.3s;
        }

        .tab button:hover {
            background-color: white;
        }

        .tab button.active {
            background-color: white;
        }

        .searchtable {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 800px;
            margin: 20px auto 0;
            background-color: goldenrod;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        select,
        input {
            padding: 10px;
            width: 30%;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        input#searchbox {
            width: 50%;
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

        .image-slider {
            position: relative;
            overflow: hidden;
        }

        .slider-images {
            display: flex;
            transition: transform 0.5s ease-in-out;
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

        .account {
            margin-right: 20px;
        }

        .property-box {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .tabcontent:not(.active-tab) {
            display: none;
        }

        .rounded-box {
            width: 150px;
            height: auto;
            border-radius: 15px;
            background-color: #e0e0e0;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .slider-image-container {
            flex: 0 0 auto;
            width: 100%;
            max-width: auto;
            height: 200px;
            overflow: hidden;
            border-radius: 8px;
        }

        .slider-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2, h3 {
            color: goldenrod;
        }

        p {
            line-height: 1.6;
        }

        .quote {
            font-style: italic;
            color: #555;
            margin-top: 20px;
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

        <div>
            <p id='welcomemessage'></p>
        </div>

        <div class="action-buttons">
            <button onclick="location.href='front.html';">Home</button>
            <button onclick="location.href='upload.html';">Create Listing</button>
            <button onclick="toggleMode()">Change Mode</button>
            <button onclick="logoutf()">Log Out</button>
        </div>
    </header>

    <div class="tab">
        <button class="tablinks" onclick="openCity(event, 'searchlistings')">Search For Property</button>
        <button class="tablinks" onclick="openCity(event, 'yourlisting')">Your Listings</button>
        <button class="tablinks" onclick="openCity(event, 'account')">Account</button>
        <button class="tablinks" onclick="openCity(event, 'about')">About</button>
    </div>

    <div id="searchlistings" class="tabcontent">
        <form id="searchForm">
            <div class="searchtable">
                <select id="state" name="state">
                <option value="andhrapradesh">Andhra Pradesh</option>
                <option value="assam">Assam</option>
                <option value="goa">Goa</option>
                <option value="gujarat">Gujarat</option>
                <option value="karnataka">Karnataka</option>
                <option value="kerala">Kerala</option>
                <option value="maharashtra">Maharashtra</option>
                <option value="punjab">Punjab</option>
                <option value="rajasthan">Rajasthan</option>
                <option value="tamilnadu">Tamil Nadu</option>
                <option value="telangana">Telangana</option>
                <option value="uttarpradesh">Uttar Pradesh</option>
                <option value="westbengal">West Bengal</option>
                <option value="chandigarh">Chandigarh</option>
                <option value="jammukashmir">Jammu & Kashmir</option>
                <option value="ladakh">Ladakh</option>
                <option value="puducherry">Puducherry</option>
                </select>
                <input type="text" placeholder="Search..." id="searchbox" name="city">
                <button type="button" onclick="searchlistings()">Search</button>
            </div>
        </form>
        <div id="searchResults"></div>
    </div>

    <div id="yourlisting" class="tabcontent">
    <div id="userListingsContainer">
        <?php
            $con = mysqli_connect("localhost", "root", "", "property");
            $userid = $_COOKIE["id"];

            $userListings = mysqli_query($con, "SELECT * FROM listingdata WHERE userid = '$userid';");

            if ($userListings && mysqli_num_rows($userListings) > 0) {
                echo "<h2 style='color: goldenrod;'>Your Listings:</h2>";
                echo '<div id="userListings" style="display: flex; flex-wrap: wrap;">';

                while ($row = mysqli_fetch_assoc($userListings)) {
                    echo '<div class="rounded-box" style="flex: 1 0 calc(33.33% - 20px); max-width: calc(20% - 20px); height: 500px; margin: 10px;" onclick="handleBoxClick(\'' . $row['id'] . '\')">';
                    echo '<h3>' . $row['title'] . '</h3>';
                    echo '<div class="image-slider">';
                    echo '<div class="slider-images">';

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
                            echo '<p>Image not found: ' . $imagePath . '</p>';
                        }
                    }

                    echo '</div>';

                    echo '<button class="slider-btn prev-btn" onclick="prevSlide(this); stopPropagation(event)">❮</button>';
                    echo '<button class="slider-btn next-btn" onclick="nextSlide(this); stopPropagation(event)">❯</button>';

                    echo '</div>';
                    echo '<p>Address: ' . $row['addy'] . '</p>';
                    echo '<p>BHK: ' . $row['bhk'] . '</p>';
                    echo '<p>Sqft: ' . $row['sqft'] . '</p>';
                    echo '<p>Price: ' . $row['price'] . '</p>';
                    echo '</div>';
                }

                echo '</div>';
            } else {
                echo "<h2 style='color: #e0e0e0;'>No Listings To Display. Feel Free To Create One!</h2>";
            }

            mysqli_close($con);
        ?>
    </div>
</div>


<div id="account" class="tabcontent">
    <form id="accounts" style="max-width: 400px; margin: 0 auto;">
        <label for="id" style="color: goldenrod; display: block; margin-bottom: 10px;"><b>ID: </b></label>
        <input type="text" id="id" name="id" value="" style="width: 100%; margin-bottom: 10px;" disabled><br>
        
        <label for="name" style="color: goldenrod; display: block; margin-bottom: 10px;"><b>Full Name: </b></label>
        <input type="text" id="name" name="name" value="" style="width: 100%; margin-bottom: 10px;" disabled><br>

        <label for="email" style="color: goldenrod; display: block; margin-bottom: 10px;"><b>Email: </b></label>
        <input type="email" id="email" name="Email" value="" disabled style="width: 100%; margin-bottom: 10px;"><br>

        <label for="phone" style="color: goldenrod; display: block; margin-bottom: 10px;"><b>Phone Number:</b></label>
        <input type="tel" id="phone" name="Phone_number" pattern="[0-9]{10}" value="" required style="width: 100%; margin-bottom: 10px;" disabled><br>

        <label for="password" style="color: goldenrod; display: block; margin-bottom: 10px;"><b>Password:</b></label>
        <input type="password" id="password" name="password" required style="width: 100%; margin-bottom: 10px;" disabled><br>
    
        <button type="button" id="editButton" onclick="enableEdits()">Edit</button>
        <button type="button" id="confirmButton" style="display: none;" onclick="updateaccount()">Confirm</button>
    </form>
</div>

<div id="about" class="tabcontent">
    <h1>About Us:</h1>

    <div class="container">
        <h2>Behind The Scenes</h2>
        <p>A Modern Web Application That Aids In Property Listing To Help Everyone From Ordinary Joes To
           Professional Real Estate Agents Market And Track Property In Today's Era.
           Made With HTML, PHP, CSS, Javascript - JQuery, AJAX, and MySQLi.
        </p>

        <h2>Our Mission</h2>
        <p>We Wish To Become The Industry Leading Property Listing Company By Creating A New Fiscal Year
            Record in FQ2024. We Plan On Releasing The Android And IOS Applications Soon.
        </p>

        <h2>Team Contributions:</h2>
        <div>
            <h3>Shyaam S</h3>
            <p>Property Search, Listings Implementation Development</p>
            <p>JavaScript, AJAX, SQLi Management</p>
        </div>
        <hr>

        <div>
            <h3>Sai Arjunaa A</h3>
            <p>Login - SignUp Implementation | Account Management Functionality</p>
            <p>HTML, PHP, CSS Design</p>
        </div>
        <hr>

        <div>
            <h3>Varun Karthik Dubai</h3>
            <p>About Page</p>
            <p>Design</p>
        </div>
        <hr>

        <div class="quote">
            <p>"Success is not final, failure is not fatal: It is the courage to continue that counts." - Winston Churchill</p>
        </div>
    </div>

    <footer>
        &copy; 2024 UrbanList. All rights reserved.
    </footer>
</div>

    <script>

    function enableEdits() {
        document.getElementById('name').disabled = false;
        document.getElementById('email').disabled = false;
        document.getElementById('phone').disabled = false;
        document.getElementById('password').disabled = false;

        document.getElementById('confirmButton').style.display = 'block';
        document.getElementById('editButton').style.display = 'none';
    }

        function logoutf() {
            setCookie("id", "", 0);
            setCookie("email", "", 0);
            setCookie("password", "", 0);
            setCookie("name", "", 0);
            setCookie("phone", "", 0);
            window.open("front.html", "_self");
        }

        function updateaccount() {
            var id = document.getElementById('id').value;
            var email = document.getElementById('email').value;
            var name = document.getElementById('name').value;
            var phone = document.getElementById('phone').value;
            var password = document.getElementById('password').value;

            var jsonData = JSON.stringify({ id: id, email: email, name: name, phone: phone, password: password });
            fetch('accupdate.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: jsonData,
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Response Data:', data);

                if (data.status === 'success') {
                    document.getElementById('name').disabled = true;
                    document.getElementById('email').disabled = true;
                    document.getElementById('phone').disabled = true;
                    document.getElementById('password').disabled = true;

                    alert("Account Information Updated! Please Re-Login!");
                    logoutf();

                    document.getElementById('confirmButton').style.display = 'none';
                    document.getElementById('editButton').style.display = 'block';
                } else {
                    alert('Update failed:', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function validate() {
            var city = document.getElementById('searchbox').value;
            if (city == '') {
                alert("Please Enter A Proper Place!");
            } else {
                searchlistings();
            }
        }

        function checkpass() {
            if (document.getElementById('retypePassword').value != document.getElementById('password').value) {
                input.setCustomValidity('Password Must be Matching.');
            } else {
                input.setCustomValidity('');
            }
        }

        function handleBoxClick(listingId) {
            var url = 'details.php?listing_id=' + listingId;
            window.location.href = url;
        }

        function searchlistings() {
            var city = document.getElementById('searchbox').value;
            var state = document.getElementById('state').value;
            var jsons = JSON.stringify({city: city, state: state});

            console.log('Form Data:', jsons);

            fetch('search.php', {
                method: 'POST',
                body: jsons,
            })
            .then(response => {
                if (response.ok) {
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json();
                    } else {
                        return response.text().then(text => ({ text }));
                    }
                } else {
                    throw new Error('Network response was not ok.');
                }
            })
            .then(data => {
                if (data.text) {
                    console.log('Response Data (Not JSON):', data.text);
                } else {
                    console.log('Response Data:', data);
                    var searchResultsDiv = document.getElementById("searchResults");
                    searchResultsDiv.innerHTML = data.html;
                }
            })
            .catch(error => console.error('Error:', error));
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
            for (let i = 0; i < ca.length; i++) {
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
        
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;

            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (!getCookie('backgroundColor')) {
                setCookie("backgroundColor", "white", 60000);
            }
            if (getCookie("backgroundColor") == "white") {
                document.body.style.backgroundColor = "white";
            } else {
                document.body.style.backgroundColor = "black";
            }
            document.getElementById("welcomemessage").textContent = 'Welcome ' + getCookie("name");

            document.getElementById('id').value = getCookie("id");
            document.getElementById('name').value = getCookie("name");
            document.getElementById('email').value = getCookie("email");
            document.getElementById('phone').value = getCookie("phone");
            document.getElementById('password').value = getCookie("password");

            const sliders = document.querySelectorAll('.slider-images');
            sliders.forEach(slider => updateSliderButtons(slider));

            const searchForm = document.getElementById('searchForm');
            searchForm.addEventListener('submit', function (event) {
                event.preventDefault();
                searchlistings();
            });
            var fakeEvent = { currentTarget: document.querySelector('.tablinks') };
            openCity(fakeEvent, 'searchlistings');
        });
    </script>

</body>

</html>