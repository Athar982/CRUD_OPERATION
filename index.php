<?php include 'header.php' ?>
<?php include 'dbcon.php' ?>

<div class="box1">
    <!-- <h2>All Students</h2> -->
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <i class="fa-solid fa-user-plus"></i>
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Student</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="insert_data.php" method="post" enctype="multipart/form-data">
                        <div class="form-group mt-2 mb-4">
                            <label for="firstName">Name</label>
                            <input type="text" class="form-control" id="firstName" name="Name">
                        </div>
                        <div class="form-group mt-2 mb-4">
                            <label for="DOB">DOB</label>
                            <input type="date" class="form-control" id="DOB" name="date_of_birth">
                        </div>
                        <div class="form-group mb-4">
                            <label>Gender</label><br>
                            <input type="radio" id="male" name="Gender" value="male" required>
                            <label for="male">Male</label>
                            <input type="radio" id="female" name="Gender" value="female" required>
                            <label for="female">Female</label>
                            <input type="radio" id="other" name="Gender" value="other" required>
                            <label for="female">Other</label>
                        </div>
                        <div class="form-group mb-4">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="Email">
                        </div>
                        <div class="form-group mb-2">
                            <label for="contact">Mobile</label>
                            <input type="number" class="form-control" id="contact" name="Contact">
                        </div>
                        <div class="form-group mb-2">
                            <label for="image">Profile Photo</label>
                            <input type="file" class="form-control" id="image" name="Image">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-success" name="add_students" value="ADD">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <table class="table table-hover table-border ">
        
        <thead>
            <tr class="text-center ">
                <th>ID</th>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Profile Photo</th> <!-- New column for Profile Photo -->
                <th>Action</th>
                <!-- <th>Delete</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM records";
            $result = mysqli_query($connection, $query);
            if (!$result) {
                die("Query failed");
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>

                    <tr class="text-center">
                        <td class="vertical-center  custome-sty"><?php echo $row['id']; ?></td>
                        <td class="vertical-center  custome-sty"><?php echo $row['Name']; ?></td>
                        <td class="vertical-center  custome-sty"><?php echo $row['date_of_birth']; ?></td>

                        <td class="vertical-center  custome-sty"><?php echo $row['Gender']; ?></td>

                        <td class="vertical-center  custome-sty"><?php echo $row['Email']; ?></td>
                        <td class="vertical-center  custome-sty"><?php echo $row['Contact']; ?></td>
                        <td class="vertical-center ">
                            <?php if (!empty($row['Image'])): ?>
                                <img src="<?php echo $row['Image']; ?>" alt="Profile Photo"
                                    style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover; background-color: transparent;">
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>

                        <td class="vertical-center  ">
                            <a href="update.php?id=<?php echo $row['id']; ?>"
                                style="text-decoration: none; color: #4CAF50; font-size: 30px;">
                                <i class="fa-solid fa-pen-to-square"></i>                            </a>
                            <a href="delete_page.php?id=<?php echo $row['id']; ?>"
                                style="text-decoration: none; color: #F44336; font-size: 30px; margin-left:10px">
                                <i class="fa-regular fa-trash-can"></i>
                            </a>
                        </td>
                        <td class="vertical-center">

                        </td>


                     
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>

   
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let message = '<?php echo isset($_GET['message']) ? $_GET['message'] : ''; ?>';
        if (message !== '') {
            alert(message);
            // Optionally clear the message from URL
            history.replaceState(null, null, 'index.php');
        }
    });
</script>


<?php include ('footer.php') ?>