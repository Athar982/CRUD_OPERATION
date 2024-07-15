<?php
include('dbcon.php'); // Include your database connection file

if (isset($_POST['add_students'])) {
    $Name = $_POST['Name'];
    $DOB = $_POST['date_of_birth'];
    $Email = $_POST['Email'];
    $Contact = $_POST['Contact'];
    $Gender = $_POST['Gender'];

    // Debugging: Print the original DOB
    echo "Original DOB: " . $DOB . "<br>";

    // Convert the date format to YYYY-MM-DD if it's not already in that format
    $DOB = date('Y-m-d', strtotime($DOB));

    // Debugging: Print the converted DOB
    echo "Converted DOB: " . $DOB . "<br>";

    // File upload handling
    $target_dir = "uploads/"; // Specify the directory where you want to store uploaded files, ensure it ends with a slash "/"
    $target_file = $target_dir . basename($_FILES["Image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is actually uploaded and not an empty file
    if (!empty($_FILES["Image"]["tmp_name"]) && is_uploaded_file($_FILES["Image"]["tmp_name"])) {
        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["Image"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size (maximum 3MB)
        if ($_FILES["Image"]["size"] > 3 * 1024 * 1024) {
            echo "Sorry, your file is too large. Maximum size allowed is 3MB.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowed_extensions)) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["Image"]["tmp_name"], $target_file)) {
                echo "The file " . basename($_FILES["Image"]["name"]) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
                $uploadOk = 0;
            }
        }
    } else {
        echo "No file uploaded or invalid file.";
        $uploadOk = 0;
    }

    // Inserting data into database if file upload was successful
    if ($uploadOk == 1) {
        $query = "INSERT INTO records (Name, date_of_birth, Email, Contact, Gender, Image) VALUES ('$Name', '$DOB', '$Email', '$Contact', '$Gender', '$target_file')";
        $result = mysqli_query($connection, $query);

        if ($result) {
            header("Location: index.php?message=Employee added successfully");
            exit();
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    }
}
?>
