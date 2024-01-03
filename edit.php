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

        button {
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            background-color:white;
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

        fieldset{
          background-color: grey;
          border: none;
          border-radius: 2px;
          margin-bottom: 12px;
          overflow: hidden;
          padding: 0 .625em;
      }

      label{
          font-family:"tahoma";
          cursor: pointer;
          display: inline-block;
          padding: 3px 6px;
          text-align: left;
          width: 150px;
          vertical-align: top;
          color: grey;
      }

      input{
          font-size: inherit;
          display:inline-block;
          text-align: center;
          vertical-align: center;
          margin: 0 auto;
      }
      
      .head {
          text-align:center;
          color: grey;
      }
      
      .sa {
        text-align:center;
      }

      .touchbot {
        margin-top: auto;
        padding-top: 20px;
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
            <button onclick="logoutf()">Log Out</button>
            <button onclick="toggleMode()">Change Mode</button>
        </div>

        <script>
            function toggleMode() {
            if (getCookie("backgroundColor") === 'white') {
                document.body.style.backgroundColor = '#000';
                setCookie('backgroundColor', 'black', 30);
            } else {
                document.body.style.backgroundColor = '#fff';
                setCookie('backgroundColor', 'white', 30);
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
        </script>

    </header>

    <?php
        $id = $_GET['listing_id'];
        $email = $_COOKIE["email"];
        $con = mysqli_connect("localhost", "root", "", "property");
        $query = mysqli_query($con, "SELECT * FROM listingdata WHERE email = '$email' AND id = '$id';");
        if ($row = mysqli_fetch_assoc($query)) {
            $name = $_COOKIE['name'];
            $pn = $row["phone"];
            $title = $row["title"];
            $descrip = $row["descrip"];
            $city = $row["city"];
            $state = $row["stat"];
            $address = $row["addy"];
            $bhk = $row["bhk"];
            $price = $row["price"];
            $purpose = $row["purpose"];
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
            $images = $row["images"];
            echo '<form action="edit_back.php" method="post" enctype="multipart/form-data">';
            echo '    <h2 style="color: goldenrod;"><b>Enter Your Details: </b></h2>';

            echo '    <label for="identify"><b>ID: </b></label>';
            echo '    <input type="text" id="identify" name="identify" value="' . $id . '" disabled><br><br>';

            echo '    <input type="hidden" name="listing_id" value="' . $id . '">';

            echo '    <label for="name"><b>Full Name: </b></label>';
            echo '    <input type="text" id="name" name="name" disabled><br><br>';

            echo '    <label for="email"><b>Email: </b></label>';
            echo '    <input type="email" id="email" name="Email" value="" disabled><br><br>';

            echo '    <label for="phone"><b>Phone Number:</b></label>';
            echo '    <input type="tel" id="phone" name="Phone_number" pattern="[0-9]{10}" value="" required><br><br>';

            echo '    <label for="title"><b>Listing Title: </b></label>';
            echo '    <input type="text" id="title" name="title" required><br><br>';

            echo '    <label for="city"><b>City: </b></label>';
            echo '    <input type="text" id="city" name="city" required><br><br>';

            echo '    <label for="state"><b>State: </b></label>';
            echo '<select name="state">';
            echo '<option value="andhrapradesh">Andhra Pradesh</option>';
            echo '<option value="assam">Assam</option>';
            echo '<option value="goa">Goa</option>';
            echo '<option value="gujarat">Gujarat</option>';
            echo '<option value="karnataka">Karnataka</option>';
            echo '<option value="kerala">Kerala</option>';
            echo '<option value="maharashtra">Maharashtra</option>';
            echo '<option value="punjab">Punjab</option>';
            echo '<option value="rajasthan">Rajasthan</option>';
            echo '<option value="tamilnadu">Tamil Nadu</option>';
            echo '<option value="telangana">Telangana</option>';
            echo '<option value="uttarpradesh">Uttar Pradesh</option>';
            echo '<option value="westbengal">West Bengal</option>';
            echo '<option value="chandigarh">Chandigarh</option>';
            echo '<option value="jammukashmir">Jammu & Kashmir</option>';
            echo '<option value="ladakh">Ladakh</option>';
            echo '<option value="puducherry">Puducherry</option>';
            echo '</select><br><br>';

            echo '    <label for="address"><b>Address: </b></label>';
            echo '    <input type="text" id="address" name="address" required><br><br>';

            echo '    <label for="bhk"><b>Property BHK Count: </b></label>';
            echo '    <input type="text" id="bhk" name="bhk" required><br><br>';

            echo '    <label for="price"><b>Listing Price: </b></label>';
            echo '    <input type="text" id="price" name="price" value="₹" required><br><br>';

            echo '    <label for="purpose"><b>Purpose: </b></label>';
            echo '    <select name="purpose" id="purpose">';
            echo '        <option value="rent">Rent</option>';
            echo '        <option value="lease">Lease</option>';
            echo '        <option value="sale">Sale</option>';
            echo '    </select><br><br>';

            echo '    <label for="sqft"><b>Square Feet: </b></label>';
            echo '    <input type="text" id="sqft" name="sqft" required><br><br>';

            echo '    <label for="advance"><b>Advance: </b></label>';
            echo '    <input type="text" id="advance" name="advance" value="₹" required><br><br>';

            echo '    <label for="parking"><b>Parking: </b></label>';
            echo '    <input type="text" id="parking" name="parking" required><br><br>';

            echo '    <label for="floor"><b>Floor: </b></label>';
            echo '    <input type="text" id="floor" name="floor" value="X/X" required><br><br>';

            echo '    <label for="balcony"><b>Balcony: </b></label>';
            echo '    <input type="text" id="balcony" name="balcony" required><br><br>';

            echo '    <label for="elevator"><b>Elevator Service: </b></label>';
            echo '    <select name="elevator" id="elevator">';
            echo '        <option value="true">Yes</option>';
            echo '        <option value="false">No</option>';
            echo '    </select><br><br>';

            echo '    <label for="age"><b>Age: </b></label>';
            echo '    <input type="text" id="age" name="age" required><br><br>';

            echo '    <label for="bathroom"><b>Bathroom Count: </b></label>';
            echo '    <input type="text" id="bathroom" name="bathroom" required><br><br>';

            echo '    <label for="descrip"><b>Description: </b></label>';
            echo '    <textarea id="descrip" name="descrip" rows="5" cols="100"></textarea><br><br>';

            echo '    <label for="secure"><b>Security Guard: </b></label>';
            echo '    <select name="secure" id="secure">';
            echo '        <option value="true">Yes</option>';
            echo '        <option value="false">No</option>';
            echo '    </select><br><br>';

            echo '    <label for="expired"><b>Has The Listing Ended?: </b></label>';
            echo '    <select name="expired" id="expired">';
            echo '        <option value="false">No</option>';
            echo '        <option value="true">Yes</option>';
            echo '    </select><br><br>';

            echo '    <label for="files">Select files:</label>';
            echo '    <input type="file" id="files" name="files[]" accept="image/*" multiple required><br><br>';

            echo '    <label for="date"><b>Date Of Listing: </b></label>';
            echo '    <input type="text" id="date" name="date" value="" disabled><br><br>';
            echo '</div>';
            echo '<div class="touchbot">';
            echo '    <h3 style="color:grey; text-align:center;">By updating this property you agree to our Terms & Conditions.</h3><br>';
            echo '    <div class="sa">';
            echo '        <button onclick="validate()">Update Listing</button>';
            echo '    </div>';
            echo '</div>';
            echo '</form>';
        } else {
            echo 'You Dont Have Permission To Access This Site!';
        }
    ?>

    <script>
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
            setCookie("id", "", 0);
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

        document.addEventListener('DOMContentLoaded', function () {
            if (!getCookie('backgroundColor')) {
                setCookie("backgroundColor", "white", 60000)
            }
            if (getCookie("backgroundColor") == "white") {
                document.body.style.backgroundColor = "white";
            } else {
                document.body.style.backgroundColor = "black";
            }
            const urlParams = new URLSearchParams(window.location.search);
            const parameterValue = urlParams.get('listing_id');
            document.getElementById("identify").value = parameterValue;
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();

            today = dd + '/' + mm + '/' + yyyy;
        });
            <?php
                echo '<script></script>';
                echo '<script>document.getElementById("name").value = "' . $name . '";</script>';
                echo '<script>document.getElementById("email").value = "' . $email . '";</script>';
                echo '<script>document.getElementById("phone").value = "' . $pn . '";</script>';
                echo '<script>document.getElementById("title").value = "' . $title . '";</script>';
                echo '<script>document.getElementById("city").value = "' . $city . '";</script>';
                echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var stateDropdown = document.getElementsByName("state")[0];
                        var defaultState = "' . $state . '";

                        for (var i = 0; i < stateDropdown.options.length; i++) {
                            if (stateDropdown.options[i].value === defaultState) {
                                stateDropdown.options[i].selected = true;
                                break;
                            }
                        }
                    });
                </script>';
                echo '<script>document.getElementById("address").value = "' . $address . '";</script>';
                echo '<script>document.getElementById("bhk").value = "' . $bhk . '";</script>';
                echo '<script>document.getElementById("price").value = "' . $price . '";</script>';
                echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var stateDropdown = document.getElementsByName("purpose")[0];
                        var defaultState = "' . $purpose . '";

                        for (var i = 0; i < stateDropdown.options.length; i++) {
                            if (stateDropdown.options[i].value === defaultState) {
                                stateDropdown.options[i].selected = true;
                                break;
                            }
                        }
                    });
                </script>';
                echo '<script>document.getElementById("sqft").value = "' . $sqft . '";</script>';
                echo '<script>document.getElementById("advance").value = "' . $advance . '";</script>';
                echo '<script>document.getElementById("parking").value = "' . $parking . '";</script>';
                echo '<script>document.getElementById("floor").value = "' . $floor . '";</script>';
                echo '<script>document.getElementById("balcony").value = "' . $balcony . '";</script>';
                echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var stateDropdown = document.getElementsByName("elevator")[0];
                        var defaultState = "' . $elevator . '";

                        for (var i = 0; i < stateDropdown.options.length; i++) {
                            if (stateDropdown.options[i].value === defaultState) {
                                stateDropdown.options[i].selected = true;
                                break;
                            }
                        }
                    });
                </script>';
                echo '<script>document.getElementById("age").value = "' . $age . '";</script>';
                echo '<script>document.getElementById("bathroom").value = "' . $bathroom . '";</script>';
                echo '<script>document.getElementById("descrip").value = "' . $descrip . '";</script>';
                echo '<script>document.getElementById("date").value = "' . $date . '";</script>';
            ?>
    </script>
</body>

</html>