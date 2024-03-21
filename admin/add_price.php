<?php
include "../db/db.php";

$error_message = $success_message = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if variables are defined and obtained from the form
    if (isset($_POST["price"], $_POST["description"], $_FILES["image"]["name"])) {
        // Sanitizējam ievades datus
        $price = $_POST["price"];
        $description = $_POST["description"];

        // Failu augšupielāde
        $target_dir = "admin/images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;

        // Pārbaudām, vai fails ir attiecīgā formāta un izmēra
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            $error_message = "Only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Pārbaudām, vai fails tiek augšupielādēts pareizi
        if ($uploadOk) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Insert data into database
                $sql_insert = "INSERT INTO RoomPrices (price, description, image) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql_insert);
                $stmt->bind_param("dss", $price, $description, $target_file);
                if ($stmt->execute()) {
                    $success_message = "New room price added successfully";
                } else {
                    $error_message = "Error adding room price: " . $stmt->error;
                }
            } else {
                $error_message = "Error uploading file";
            }
        }
    } else {
        $error_message = "Please fill in all required fields";
    }
}
?>
