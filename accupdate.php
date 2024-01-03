<?php
    $con = mysqli_connect("localhost", "root", "", "property");

    if (!$con) {
        echo json_encode(['status' => 'error', 'message' => 'Database connection error']);
        exit;
    }

    $jsonData = json_decode(file_get_contents('php://input'), true);

    if ($jsonData) {
        $id = mysqli_real_escape_string($con, $jsonData["id"]);
        $email = mysqli_real_escape_string($con, $jsonData["email"]);
        $name = mysqli_real_escape_string($con, $jsonData["name"]);
        $pn = mysqli_real_escape_string($con, $jsonData["phone"]);
        $pword = mysqli_real_escape_string($con, $jsonData["password"]);

        $check = mysqli_query($con, "SELECT * FROM userdata WHERE id = '$id';");

        if (mysqli_num_rows($check) > 0) {
            $update = mysqli_query($con, "UPDATE userdata SET name = '$name', email = '$email', pn = '$pn', pword = '$pword' WHERE id = '$id';");
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User not found']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON data']);
    }

    mysqli_close($con);
?>