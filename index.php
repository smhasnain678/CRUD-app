<!-- INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'Go to buy fruits', 'Hey Hasnain!\r\nI want you to buy fruit. Delete this note once you are done with this task.', current_timestamp()); -->

<?php
 $insert = false; 
 $update = false; 
 $delete = false; 
// Connecting to the DB

$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Sorry we failed to connect: ". mysqli_connect_error());
}

if(isset($_GET['delete'])){
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
    $result = mysqli_query($conn, $sql);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['snoEdit'])){
        // Update the record
        $sno = $_POST["snoEdit"];
        $title = $_POST["titleEdit"];
        $description = $_POST["descriptionEdit"];

        $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sno` = $sno";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $update = true;
        }else{
            echo "We could not update the record successfully";
        }
    }else{
        
    $title = $_POST["title"];
    $description = $_POST["description"];

    $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
    $result = mysqli_query($conn, $sql);

    if($result){
        // echo "The record has been inserted successfully!<br>";
        $insert = true;
    }else{
        echo "The record was not inserted successfully because of this error ---> ". mysqli_error($conn);
    }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Php CURD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.6/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
        Edit Modal
    </button> -->

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModal">Edit this Note</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/crud/index.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="mb-3">
                            <label for="Title" class="form-label">Note Title</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="desc">Note Description</label>
                            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"
                                rows="3"></textarea>
                        </div>
                        <!-- <button type="submit" class="btn btn-primary">Update Note</button> -->
                    </div>
                    <div class="modal-footer d-block mr-auto">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PHP CRUD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <?php
     if($insert){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success</strong> Your note has been inserted successfully
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
     }
    ?>
    <?php
     if($delete){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success</strong> Your note has been deleted successfully
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
     }
    ?>
    <?php
     if($update){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success</strong> Your note has been updated successfully
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
     }
    ?>

    <div class="container mt-4">
        <h2>Add Note</h2>
        <form action="/crud/index.php" method="post">
            <div class="mb-3">
                <label for="Title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="desc">Note Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <div class="container my-4">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
            $sql = "SELECT * FROM `notes`";
            $result = mysqli_query($conn, $sql);
            $sno = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $sno = $sno + 1;
                echo " <tr>
                    <th scope='row'>". $sno."</th>
                    <td>". $row['title']."</td>
                    <td>". $row['description']."</td>
                    <td> <button class='btn btn-sm btn-primary edit' id=e".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-danger 
                    delete' id=d".$row['sno'].">Delete</button> </td>
                </tr>";
            }
            ?>

                <!-- echo $row['sno'] . ". Title ". $row['title'] ." Desc is ". $row['description'];
                echo "<br>"; -->
            </tbody>
        </table>
    </div>
    <hr>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script src="//cdn.datatables.net/2.3.6/js/dataTables.min.js"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>

    <script>
        // --- Edit Logic ---
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener('click', (e) => {
                let tr = e.target.parentNode.parentNode;
                let title = tr.getElementsByTagName("td")[0].innerText;
                let description = tr.getElementsByTagName("td")[1].innerText;

                // Form inputs fill karna
                document.getElementById('titleEdit').value = title;
                document.getElementById('descriptionEdit').value = description;
                // e.target.id "e38" se "38" nikal kar hidden input me daalna
                document.getElementById('snoEdit').value = e.target.id.substr(1);

                $('#editModal').modal('toggle');
            })
        });

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener('click', (e) => {
                // e.target.id se "d38" milega, substr(1) "38" nikal dega
                let sno = e.target.id.substr(1);

                if (confirm("Are you sure you want to delete this note?")) {
                    window.location = `/crud/index.php?delete=${sno}`;
                }
            })
        });
    </script>
</body>

</html>