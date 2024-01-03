<html>
    <?php
        $name = $_POST["name"];
        $email = $_POST["Email"];
        $pn = $_POST["Phone_number"];
        $gender = $_POST["gender"];
        $pword = $_POST["password"];
        $con=mysqli_connect("localhost", "root","", "property");
        $create=mysqli_query($con, "CREATE TABLE IF NOT EXISTS userdata(id int PRIMARY KEY AUTO_INCREMENT, name varchar(100), email varchar(100), pn varchar(100), gender varchar(100), pword varchar(100));");
        $check=mysqli_query($con, "SELECT * FROM userdata WHERE email = '$email';");
        if(mysqli_num_rows($check) == 0) {
            $insert=mysqli_query($con, "INSERT INTO userdata (name, email, pn, gender, pword) VALUES ('$name', '$email', '$pn', '$gender', '$pword');");
            $xz=mysqli_close($con);
            echo '<script>alert("Account Created...");</script>';
            echo '<script>window.open("login.php","_self")</script>';
        }
        else {
            $xz=mysqli_close($con);
            echo '<script>alert("This Account Already Exists, Please Try Logging In...");</script>';
            echo '<script>window.open("login.php","_self")</script>';
        }
    ?>
</html>