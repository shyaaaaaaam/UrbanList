<?php
$con = mysqli_connect("localhost", "root", "", "property");
$userid = $_COOKIE['id'];
if ($_POST["phone"] == "") {
    $pn = $_COOKIE["phone"];
} else {
    $pn = $_POST["phone"];
}
$title = $_POST["title"];
$descrip = $_POST["descrip"];
$city = $_POST["city"];
$state = $_POST["state"];
$address = $_POST["address"];
$bhk = $_POST["bhk"];
$price = $_POST["price"];
$purpose = $_POST["purpose"];
$sqft = $_POST["sqft"];
$advance = $_POST["advance"];
$parking = $_POST["parking"];
$floor = $_POST["floor"];
$balcony = $_POST["balcony"];
$date = date("d/m/Y");
$age = $_POST["age"];
$bathroom = $_POST["bathroom"];
$secure = $_POST["secure"];
$elevator = $_POST["elevator"];
$files = $_FILES["files"];
$file_count = count($files['name']);
$create = mysqli_query($con, "CREATE TABLE IF NOT EXISTS listingdata(id int(10) AUTO_INCREMENT PRIMARY KEY, userid varchar(100), phone varchar(100), title varchar(500), descrip varchar(10000), city varchar(100), stat varchar(100), addy varchar(100), bhk varchar(100), price varchar(100), purpose varchar(100), sqft varchar(100), advance varchar(100), parking varchar(100), floor varchar(100), balcony varchar(100), da varchar(100), age varchar(100), bathroom varchar(100), secure varchar(100), elevator varchar(100), images varchar(255), expired varchar(100));");
$query = mysqli_query($con, "SELECT * FROM listingdata WHERE userid = '$userid' AND city = '$city' AND stat = '$state' AND addy = '$address' AND sqft = '$sqft' AND purpose = '$purpose';");

if(mysqli_num_rows($query) == 0) {
    $image_filenames = array();

    for ($i = 0; $i < $file_count; $i++) {
        $img_ex = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);
        $allowed_exs = array("jpg", "jpeg", "png");

        if (in_array($img_ex_lc, $allowed_exs)) {
            $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
            $img_upload_path = 'uploads/' . $new_img_name;
            move_uploaded_file($files['tmp_name'][$i], $img_upload_path);
            $image_filenames[] = $new_img_name;
        } else {
            echo '<script>alert("Invalid File Type!");</script>';
        }
    }

    $image_filenames_str = implode(', ', $image_filenames);
    $insert = mysqli_query($con, "INSERT INTO listingdata (userid, phone, title, descrip, city, stat, addy, bhk, price, purpose, sqft, advance, parking, floor, balcony, da, age, bathroom, secure, elevator, images, expired) VALUES ('$userid', '$pn', '$title', '$descrip', '$city', '$state', '$address', '$bhk', '$price', '$purpose', '$sqft', '$advance', '$parking', '$floor', '$balcony', '$date', '$age', '$bathroom', '$secure', '$elevator', '$image_filenames_str', 'false');");

    $xz = mysqli_close($con);

    echo '<script>alert("Listing Created...");</script>';
    echo '<script>window.open("property.php","_self")</script>';
} else {
    echo '<script>alert("This Listing Already Exists...");</script>';
    echo '<script>window.open("property.php","_self")</script>';
}
?>