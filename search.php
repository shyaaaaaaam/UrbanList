<?php
    $con = mysqli_connect("localhost", "root", "", "property");

    $jsonData = json_decode(file_get_contents('php://input'), true);

    if ($jsonData) {
        $email = $_COOKIE["email"];
        $state = mysqli_real_escape_string($con, $jsonData["state"]);
        $city = mysqli_real_escape_string($con, $jsonData["city"]);
        $city = trim($city);
        $city = strtolower($city);
        //$city = str_replace(' ', '', $city);
        $state = trim($state);
        $state = strtolower($state);
        $state = str_replace(' ', '', $state);

        $searchResults = mysqli_query($con, "SELECT * FROM listingdata WHERE REPLACE(LOWER(stat), ' ', '') = REPLACE(LOWER('$state'), ' ', '') AND (LOWER(city) = LOWER('$city') OR LOWER(city) LIKE '%$city%') AND expired = 'false' AND email <> '$email';");

        $response = array();

        if ($searchResults && mysqli_num_rows($searchResults) > 0) {
            $html = "<h2 style='color:goldenrod;'>Search Results:</h2>";
            $html .= '<div id="searchResults" style="display: flex; flex-wrap: wrap;">';

            while ($row = mysqli_fetch_assoc($searchResults)) {
                $html .= '<div class="rounded-box" style="flex: 1 0 calc(33.33% - 20px); max-width: calc(20% - 20px); height: 500px; margin: 10px;" onclick="handleBoxClick(\'' . $row['id'] . '\')">';
                $html .= "<h3>" . $row['title'] . "</h3>";
                $html .= '<div class="image-slider">';
                $html .= '<div class="slider-images">';
                $images = $row['images'];
                $images = explode(',', $images);
                foreach ($images as $image) {
                    $trimmedImage = trim($image);
                    $imagePath = 'uploads/' . $trimmedImage;
                    if (file_exists($imagePath)) {
                        $html .= '<div class="slider-image-container">';
                        $html .= '<img class="slider-image" src="' . $imagePath . '" alt="Property Image">';
                        $html .= '</div>';
                    } else {
                        $html .= '<p>Image not found: ' . $imagePath . '</p>';
                    }
                }
                $html .= "</div>";
                $html .= '<button class="slider-btn prev-btn" onclick="prevSlide(this); stopPropagation(event)">❮</button>';
                $html .= '<button class="slider-btn next-btn" onclick="nextSlide(this); stopPropagation(event)">❯</button>';

                $html .= '</div>';
                $html .= '<p>Address: ' . $row['addy'] . '</p>';
                $html .= '<p>BHK: ' . $row['bhk'] . '</p>';
                $html .= '<p>Sqft: ' . $row['sqft'] . '</p>';
                $html .= '<p>Price: ' . $row['price'] . '</p>';
                $html .= '</div>';
            }
            $html .= '</div>';

            $response['html'] = $html;
        } else {
            $response['html'] = "<h2 style='color:goldenrod;'>No properties available for the selected criteria.</h2>";
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        header('Content-Type: text/plain');
        echo "Invalid JSON data";
    }

    mysqli_close($con);
?>