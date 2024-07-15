<?php include 'header.php' ?>
<?php include 'dbcon.php' ?>



<?php

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "delete from `records` where `id` = '$id'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        header("Location: index.php?message=Employee deleted successfully");
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}
?>