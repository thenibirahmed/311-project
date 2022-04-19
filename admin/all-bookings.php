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
                        <th>Booking ID</th>
                        <th>User</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Tour</th>
                        <th>Details</th>
                        <th>Action</th>
                    </tr>
                    <?php  

                        if( isset($_POST['delete_booking']) ){
                            $id = isset($_POST['id']) ? $_POST['id'] : null;

                            if( $id != null ){
                                $sql = "DELETE FROM `bookings` WHERE `id`='$id'";
                                mysqli_query($conn,$sql);
                            }
                        }

                        if(isset($_POST['change_payment_status'])){
                            $is_paid = isset($_POST['is_paid']) ? $_POST['is_paid'] : 0;
                            $id = isset($_POST['id']) ? $_POST['id'] : null;

                            if( $id != null ){
                                $sql = "UPDATE `bookings` SET `is_paid`='$is_paid' WHERE `id`='$id'";
                                mysqli_query($conn,$sql);
                            }
                        }

                        if( isset($_SESSION['logged_in_user']) && $_SESSION['logged_in_user']['role'] == 'admin' ){
                            $sql = "SELECT * FROM `bookings`";
                        }else{
                            $sql = "SELECT * FROM `bookings` WHERE `user_id`='{$_SESSION['logged_in_user']['id']}'";
                        }
                                                                                                
                        $result = mysqli_query( $conn, $sql );

                        while($row = mysqli_fetch_assoc($result)){ 
                            $sql = "SELECT * FROM `users` WHERE id='{$row['user_id']}'"; 
                            $user = mysqli_fetch_assoc(mysqli_query( $conn, $sql ));

                            $sql = "SELECT * FROM `tours` WHERE id='{$row['tour_id']}'";
                            $tour = mysqli_fetch_assoc(mysqli_query( $conn, $sql ));

                            $sql = "SELECT * FROM `members` WHERE booking_id='{$row['id']}'";
                            $members = mysqli_query( $conn, $sql );
                        ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $user['fname'] ?></td>
                                <td><?php echo $user['phone'] ?></td>
                                <td><?php echo $user['email'] ?></td>
                                <td><?php echo $tour['name'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary" 
                                        data-toggle="modal" data-target="#exampleModal<?php echo $row['id'] ?>">
                                            Show details
                                    </button>
                                </td>
                                <td>
                                    <form action="" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                        <input type="submit" name="delete_booking" class="btn btn-danger" value="Delete Booking" onclick="return confirm('Are you sure you want to delete this booking?')">
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Booking Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="mb-3">Tour Details</h4>
                                            <p>
                                                <b>Tour ID</b>
                                                <?php echo $tour['id'] ?>
                                            </p>

                                            <p>
                                                <b>Name:</b>
                                                <?php echo $tour['name'] ?>
                                            </p>
                                            <p>
                                                <b>Description:</b>
                                                <?php echo $tour['description'] ?>
                                            </p>
                                            <p>
                                                <b>Budget:</b>
                                                <?php echo $tour['budget'] ?>
                                            </p>
                                            <p>
                                                <b>From:</b>
                                                <?php echo $tour['from'] ?>
                                            </p>
                                            <p>
                                                <b>To:</b>
                                                <?php echo $tour['to'] ?>
                                            </p>
                                            <p>
                                                <b>Start Date:</b>
                                                <?php echo $tour['start_date'] ?>
                                            </p>
                                            <p>
                                                <b>Duration:</b>
                                                <?php echo $tour['duration'] ?>
                                            </p>
                                            <p>
                                                <b>Capacity:</b>
                                                <?php echo $tour['capacity'] ?>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="mb-3">Booked User Details</h4>
                                            <p>
                                                <b>First name</b>
                                                <?php echo $user['fname'] ?>
                                            </p>
                                            <p>
                                                <b>Last Name:</b>
                                                <?php echo $user['lname'] ?>
                                            </p>
                                            <p>
                                                <b>Email:</b>
                                                <?php echo $user['email'] ?>
                                            </p>
                                            <p>
                                                <b>Phone:</b>
                                                <?php echo $user['phone'] ?>
                                            </p>
                                            <h4 class="mt-5 mb-3">Booked Members</h4>
                                            <?php 
                                            $iteration = 1;
                                            while($member = mysqli_fetch_assoc($members)): ?>
                                                <p>
                                                    <b>No <?php echo $iteration; $iteration++ ?> Member:</b>
                                                    <?php echo $member['name'] ?>
                                                </p>
                                            <?php endwhile; ?>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <?php if( isset($_SESSION['logged_in_user']) && $_SESSION['logged_in_user']['role'] == 'admin' ): ?>
                                        <?php if($row['is_paid'] == false): ?>
                                            <form action="" method="POST">
                                                <input type="hidden" name="is_paid" value="1">
                                                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                                <input onclick="return confirm('Are you sure you want to make the payment paid?')" type="submit" name="change_payment_status" value="Mark as paid" type="button" class="btn btn-primary">
                                            </form>
                                        <?php else: ?>
                                            <form action="" method="POST">
                                                <input type="hidden" name="is_paid" value="0">
                                                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                                <input onclick="return confirm('Are you sure you want to make the payment unpaid?')" type="submit" name="change_payment_status" value="Mark as unpaid" type="button" class="btn btn-danger">
                                            </form>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
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