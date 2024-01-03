<html>
    <?php
        $email = $_POST["email"];
        $pword = $_POST["psw"];
        $con=mysqli_connect("localhost", "root", "", "property");
        $confirm=mysqli_query($con, "SELECT * FROM userdata WHERE email = '$email' and pword = '$pword';");
        if(mysqli_num_rows($confirm) > 0) {
            $rem = $_POST["remember"];
            $row = mysqli_fetch_assoc($confirm);  
            $xz=mysqli_close($con);
            if (isset($rem)){
                setcookie("id", $row["id"], time()+3600*24*365*10, "/");
                setcookie("email", $email, time()+3600*24*365*10, "/");
                setcookie("password", $pword, time()+3600*24*365*10, "/");
                setcookie("name", $row['name'], time()+3600*24*365*10, "/");
                setcookie("phone", $row['pn'], time()+3600*24*365*10, "/");
            } else {
                setcookie("id", $row["id"], 0, "/");
                setcookie("email", $email, 0, "/");
                setcookie("password", $pword, 0, "/");
                setcookie("name", $row['name'], 0, "/");
                setcookie("phone", $row['pn'], 0, "/");
            }
            echo '<script>window.open("property.php","_self")</script>';
        }
        else {
            $xz=mysqli_close($con);
            echo '<script>alert("This Account Doesnt Exist, Please Try Creating An Account");</script>';
            echo '<script>window.open("signup.html","_self")</script>';
        }
    ?>
</html>