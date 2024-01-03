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
      
    </style>
</head>

<body>
    <header>
    <div>
        <a href="front.html" style="text-decoration: none; color: inherit;">
            <img src="logo.png" alt="Company Logo" class="company-logo">
            <span class="company-name">UrbanList</span>
        </a>
    </div>

        <div class="action-buttons">
            <button onclick="location.href='front.html';">Home</button>
            <button onclick="location.href='signup.html'">Sign Up</button>
            <button onclick="toggleMode()">Change Mode</button>
        </div>

    </header>

    <?php
        if(isset($_COOKIE['email'])) {
            echo '<script>window.open("property.php","_self")</script>';
        } else {
            $string = <<<HEREDOC
                <form action="back.php" method="post">
                    <h1 class="head"><b>Log In:-</b></h1>
                    <label for="name"><b>Email</b></label>
                    <input type="text" placeholder="Enter Email:" name="email" required><br>
                    <label for="psw"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password: " name="psw" required><br><br>
                    <label><input type="checkbox" checked="checked" name="remember"> Remember me</label>
                    <button type="submit">Login</button>
                </form>
            HEREDOC;
            echo $string;
        }
    ?>

    <script>
        function check(input) {
            if (document.getElementById('rpassword').value != document.getElementById('password').value) {
                input.setCustomValidity('Password Must be Matching.');
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
        });
    </script>
</body>
