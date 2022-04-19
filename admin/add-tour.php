<?php 
    require_once '../inc/connection.php';
    
    if( ! isset($_SESSION['is_login']) || $_SESSION['is_login'] != true ){
        header('location: login.php');
        exit;
    }
    require_once 'templates/header.php'; 

    if( isset($_POST['add-tour']) ){
        $name = isset($_POST['name']) ? $_POST['name'] : '' ;
        $description = isset($_POST['description']) ? $_POST['description'] : '' ;
        $budget = isset($_POST['budget']) ? $_POST['budget'] : '' ;
        $from = isset($_POST['from']) ? $_POST['from'] : '' ;
        $to = isset($_POST['to']) ? $_POST['to'] : '' ;
        $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '' ;
        $duration = isset($_POST['duration']) ? $_POST['duration'] : '' ;
        $capacity = isset($_POST['capacity']) ? $_POST['capacity'] : '' ;
        $errors = [];
        if(
            empty($name) ||
            empty($budget) ||
            empty($from) ||
            empty($to) ||
            empty($start_date) ||
            empty($duration) ||
            empty($capacity) 
        ){
            $errors['required'] = ' - Please fill all the required fields';
        }

        if(
            !empty($name) &&
            !empty($budget) &&
            !empty($from) &&
            !empty($to) &&
            !empty($start_date) &&
            !empty($duration) &&
            !empty($capacity) 
        ){
            $sql = "INSERT INTO tours (`name`, `description`, `budget`, `from`, `to`, `start_date`, `duration`, `capacity`) 
            VALUES 
            ('$name', '$description', '$budget', '$from', '$to', '$start_date', '$duration', '$capacity');";
                                                                                    
            if ( $conn->query( $sql ) === TRUE ) {
                $_SESSION['tour-added'] = 'Tour Added Successfully';
            } else {
                // echo "Something went wrong";
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Add Tour Package</h1>

        <?php echo isset( $errors['required'] ) ? "<span style='color: red; margin: 5px 12px'>{$errors['required']}</span>" : '' ?>
        <?php 
            if(isset( $_SESSION['tour-added'] )){
                echo "<span style='color: green; margin: 5px 12px'>{$_SESSION['tour-added']}</span>";
                unset($_SESSION['tour-added']);
            }
        ?>
        <div class="card">
            <div class="card-body">
                <form action="" method="POST">
                    <label><b>Package Name</b></label><span class="text-danger">*</span>
                    <input type="text" name="name" class="form-control">
                    
                    <label class="mt-3"><b>Package Description</b></label>
                    <textarea id="" cols="30" rows="5" class="form-control" name="description"></textarea>
                    
                    <label class="mt-3"><b>Package Budget</b></label><span class="text-danger">*</span>
                    <input type="number" name="budget" class="form-control">
                    
                    <label class="mt-3"><b>Starts From</b></label><span class="text-danger">*</span>
                    <input type="text" name="from" class="form-control">
                    
                    <label class="mt-3"><b>Ends To</b></label><span class="text-danger">*</span>
                    <input type="text" name="to" class="form-control">
                    
                    <label class="mt-3"><b>Starting Date</b></label><span class="text-danger">*</span>
                    <input type="date" name="start_date" class="form-control">
                    
                    <label class="mt-3"><b>Duration (Days)</b></label><span class="text-danger">*</span>
                    <input type="number" name="duration" class="form-control">
                    
                    <label class="mt-3"><b>Capacity</b></label><span class="text-danger">*</span>
                    <input type="number" name="capacity" class="form-control">

                    <input type="submit" name="add-tour" class="btn btn-primary mt-3">
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->


<?php require_once 'templates/footer.php'; ?>