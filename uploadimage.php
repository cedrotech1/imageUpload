<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
            <form action="uploadimage.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="pname">name</label>
                    <input type="text" class="form-control" id="pname" aria-describedby="pname"
                        placeholder="Enter pname" name='pname'>
                </div>
                <div class="form-group">
                    <label for="description">description</label>
                    <input type="text" class="form-control" id="description" aria-describedby="description"
                        placeholder="Enter description" name='description'>
                </div>
                <div class="form-group">
                    <label for="image">image</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            </form>
        </div>
    </div>

    <div class="row">


        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "imageupload";

        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "select * from product";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)) {
            ?>

            <div class="col-md-3" style='background-color:lightgray;padding:0.5cm;margin:1cm'>
                <img src="<?php echo $row['image']; ?>" alt="" style='width:100%'>
                name: <?php echo $row['pname']; ?> <br>
                description:<?php echo $row['description']; ?>
            </div>
            <?php

        }



        ?>

    </div>
</body>

</html>

<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "imageupload";

$conn = mysqli_connect($servername, $username, $password, $dbname);
// Form submission handling
if (isset($_POST['submit'])) {
    $pname = $_POST['pname'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $temp_image = $_FILES['image']['tmp_name'];

    // check if product exist
    $sql = "select * from product where pname='$pname'";
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_num_rows($result);
    if ($rows > 0) {
           echo "<script/>alert('product exist ')</script>";

    } else {
            // Move uploaded image to upload folder
            $upload_directory = "upload/";

            move_uploaded_file($temp_image, $upload_directory . $image);
            $sql = "INSERT INTO product (pname, description, image) VALUES ('$pname', '$description', '$upload_directory$image')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
                echo "<script/>window.location.href='uploadimage.php'</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
    }



}

$conn->close();
?>