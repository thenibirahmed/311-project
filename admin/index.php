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

        
    </div>
    <!-- /.container-fluid -->


<?php require_once 'templates/footer.php'; ?>