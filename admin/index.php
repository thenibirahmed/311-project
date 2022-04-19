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
        <h1 class="h3 mb-4 text-gray-800">Welcome to NSU Traveling Zone Admin</h1>
        <div class="row">
            <?php if(isset($_SESSION['logged_in_user']) && $_SESSION['logged_in_user']['role'] == 'admin' ) :  ?>
                <div class="col-md-4">
                    <div class="card">
                        <h5 class="card-header">All Packeges</h5>
                        <div class="card-body">
                            <p class="card-title">See all tour packages</p>
                            <a href="all-tours.php" class="btn btn-primary">See Tour</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <h5 class="card-header">Add Package</h5>
                        <div class="card-body">
                            <p class="card-title">Add a tour package</p>
                            <a href="add-tour.php" class="btn btn-primary">Add Tour</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <h5 class="card-header">All Bookings</h5>
                        <div class="card-body">
                            <p class="card-title">See and manage all bookings</p>
                            <a href="all-bookings.php" class="btn btn-primary">See Bookings</a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-md-4">
                    <div class="card">
                        <h5 class="card-header">My Bookings</h5>
                        <div class="card-body">
                            <p class="card-title">See my bookings</p>
                            <a href="all-bookings.php" class="btn btn-primary">See Bookings</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        

        
    </div>
    <!-- /.container-fluid -->


<?php require_once 'templates/footer.php'; ?>