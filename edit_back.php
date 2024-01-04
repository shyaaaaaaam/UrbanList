<?php
$con = mysqli_connect("localhost", "root", "", "property");
$id = $_POST["listing_id"];
$userid = $_COOKIE["id"];
$name = $_COOKIE['name'];
$email = $_COOKIE["email"];
if ($_POST["Phone_number"] == "") {
    $pn = $_COOKIE["phone"];
} else {
    $pn = $_POST["Phone_number"];
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
$expired = $_POST["expired"];
$elevator = $_POST["elevator"];

$files = $_FILES["files"];
$file_count = count($files['name']);
$image_filenames = array();

if ($file_count > 0) {
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
            continue;
        }
    }
}

if (!empty($image_filenames)) {
    $image_filenames_str = implode(', ', $image_filenames);
    $update = mysqli_query($con, "UPDATE listingdata SET images = '$image_filenames_str' WHERE id = '$id' AND userid = '$userid';");
}

$update = mysqli_query($con, "UPDATE listingdata SET phone = '$pn', title = '$title', descrip = '$descrip', city = '$city', stat = '$state', addy = '$address', bhk = '$bhk', price = '$price', purpose = '$purpose', sqft = '$sqft', advance = '$advance', parking = '$parking', floor = '$floor', balcony = '$balcony', da = '$date', age = '$age', bathroom = '$bathroom', secure = '$secure', elevator = '$elevator', expired = '$expired' WHERE id = '$id' AND userid = '$userid';");

$xz = mysqli_close($con);

echo '<script>alert("Listing Updated...");</script>';
echo '<script>window.location.href="details.php?listing_id=' . $id . '";</script>';
?>
