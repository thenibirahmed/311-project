<?php 
    require_once '../inc/connection.php';
    
    if( ! isset($_SESSION['is_login']) || $_SESSION['is_login'] != true ){
        header('location: login.php');
        exit;
    }
    require_once 'templates/header.php'; 
?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">All Tours</h1>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-stripped table-hover">
                    <tr>
                        <th>Name</th>
                        <th>Budget</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Start Date</th>
                        <th>Duration</th>
                        <th>Capacity</th>
                        <th>Show Tour Details</th>
                        <th>Action</th>
                    </tr>
                    <?php  

                        if( isset($_POST['delete_tour']) ){
                            $id = isset($_POST['id']) ? $_POST['id'] : null;

                            if( $id != null ){
                                $sql = "DELETE FROM `tours` WHERE `id`='$id'";
                                mysqli_query($conn,$sql);
                            }
                        }

                        $sql = "SELECT * FROM `tours`";
                                                                                                
                        $result = mysqli_query( $conn, $sql );

                        while($row = mysqli_fetch_assoc($result)){ ?>
                            <tr>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['budget'] ?></td>
                                <td><?php echo $row['from'] ?></td>
                                <td><?php echo $row['to'] ?></td>
                                <td><?php echo $row['start_date'] ?></td>
                                <td><?php echo $row['duration'] ?></td>
                                <td><?php echo $row['capacity'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary" 
                                        data-toggle="modal" data-target="#exampleModal<?php echo $row['id'] ?>">
                                            Show details
                                    </button>
                                </td>
                                <td>
                                    <form action="" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                        <input type="submit" name="delete_tour" class="btn btn-danger" value="Delete Booking" onclick="return confirm('Are you sure you want to delete this booking?')">
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tour Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>
                                        <b>Tour ID</b>
                                        <?php echo $row['id'] ?>
                                    </p>

                                    <p>
                                        <b>Name:</b>
                                        <?php echo $row['name'] ?>
                                    </p>
                                    <p>
                                        <b>Description:</b>
                                        <?php echo $row['description'] ?>
                                    </p>
                                    <p>
                                        <b>Budget:</b>
                                        <?php echo $row['budget'] ?>
                                    </p>
                                    <p>
                                        <b>From:</b>
                                        <?php echo $row['from'] ?>
                                    </p>
                                    <p>
                                        <b>To:</b>
                                        <?php echo $row['to'] ?>
                                    </p>
                                    <p>
                                        <b>Start Date:</b>
                                        <?php echo $row['start_date'] ?>
                                    </p>
                                    <p>
                                        <b>Duration:</b>
                                        <?php echo $row['duration'] ?>
                                    </p>
                                    <p>
                                        <b>Capacity:</b>
                                        <?php echo $row['capacity'] ?>
                                    </p>
                                
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <!-- <button type="button" class="btn btn-primary">Show Booked Users</button> -->
                                </div>
                                </div>
                            </div>
                            </div>
                    <?php }

                    ?>
                    
                </table>
            </div>
        </div>
        
        <!-- Button trigger modal -->
        

    </div>
    <!-- /.container-fluid -->


<?php require_once 'templates/footer.php'; ?>