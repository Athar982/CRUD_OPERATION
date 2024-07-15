<?php include 'header.php';?>
<?php include 'dbcon.php'; ?>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM records WHERE id = '$id'";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    } else {
        $row = mysqli_fetch_assoc($result);
    }
}

if (isset($_POST['update_students'])) {
    $id = $_POST['id'];
    $Name = $_POST['Name'];
    $DOB = $_POST['date_of_birth'];
    $Email = $_POST['Email'];
    $Contact = $_POST['Contact'];
    $Gender = $_POST['Gender']; // Capture Gender field
    $imagePath = $row['Image']; // Default to existing image

    // Handle file upload if a new image is uploaded
    if (!empty($_FILES["Image"]["tmp_name"]) && is_uploaded_file($_FILES["Image"]["tmp_name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["Image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["Image"]["tmp_name"]);
        if ($check !== false && $_FILES["Image"]["size"] <= 3 * 1024 * 1024 && in_array($imageFileType, array("jpg", "jpeg", "png", "gif"))) {
            if (move_uploaded_file($_FILES["Image"]["tmp_name"], $target_file)) {
                $imagePath = $target_file;
            }
        }
    }

    $query = "UPDATE records SET Name = '$Name', date_of_birth ='$DOB', Email = '$Email', Contact = '$Contact', Gender = '$Gender', Image = '$imagePath' WHERE id = '$id'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        header("Location: index.php?message=Employee updated successfully");
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}
?>

<div class="container">
    <h2>Update Student</h2>
    <form action="update.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="form-group mt-2 mb-4">
            <label for="firstName">Name</label>
            <input type="text" class="form-control" id="firstName" name="Name" value="<?php echo $row['Name']; ?>">
        </div>
        <div class="form-group mt-2 mb-4">
            <label for="dob">DOB</label>
            <input type="date" class="form-control" id="dob" name="date_of_birth" value="<?php echo $row['date_of_birth']; ?>">
        </div>
        <div class="form-group mb-4">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="Email" value="<?php echo $row['Email']; ?>">
        </div>
        <div class="form-group mb-2">
            <label for="contact">Mobile</label>
            <input type="number" class="form-control" id="contact" name="Contact" value="<?php echo $row['Contact']; ?>">
        </div>
        <div class="form-group mb-2">
            <label for="gender">Gender</label>
            <br>
            <input type="radio" id="male" name="Gender" value="male" <?php if ($row['Gender'] == 'male') echo 'checked'; ?>>
            <label for="male">Male</label>
            <input type="radio" id="female" name="Gender" value="female" <?php if ($row['Gender'] == 'female') echo 'checked'; ?>>
            <label for="female">Female</label>
            <input type="radio" id="other" name="Gender" value="other" <?php if ($row['Gender'] == 'other') echo 'checked'; ?>>
            <label for="other">Other</label>
        </div>
        <div class="form-group mb-2">
            <label for="image">Profile Photo</label>
            <input type="file" class="form-control" id="image" name="Image">
            <img src="<?php echo $row['Image']; ?>" alt="Profile Photo" style="max-width: 100px; max-height: 100px;">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-success" name="update_students" value="Update">
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
