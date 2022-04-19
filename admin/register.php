<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>NSU Travelling Zone - Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create a Customer Account!</h1>
                            </div>
                            <?php
                                require_once '../inc/connection.php';
                                if( isset( $_SESSION['is_login'] ) && $_SESSION['is_login'] == true ){
                                    header('location: index.php');
                                }

                                if ( isset( $_POST['register'] ) ) {
                                    $fname     = isset( $_POST['fname'] ) ? $_POST['fname'] : '';
                                    $lname     = isset( $_POST['lname'] ) ? $_POST['lname'] : '';
                                    $email     = isset( $_POST['email'] ) ? $_POST['email'] : '';
                                    $phone     = isset( $_POST['phone'] ) ? $_POST['phone'] : '';
                                    $password  = isset( $_POST['password'] ) ? $_POST['password'] : '';
                                    $pass_conf = isset( $_POST['password_confirmation'] ) ? $_POST['password_confirmation'] : '';
                                    $errors = [];
                                    
                                    if ( empty( $fname ) || empty( $lname ) || empty( $email ) || empty( $password ) || empty($phone) ) {
                                        $errors['register_form_fields'] = 'Name, email and password are required';
                                    }
                                    
                                    if ( $password != $pass_conf ) {
                                        $errors['password'] = 'Password doesn\'t match';
                                    }                                    

                                    if ( ! empty( $fname ) && ! empty( $lname ) && ! empty( $email ) && ! empty( $password ) && ! empty( $phone ) && $password == $pass_conf  ) {                                        
                                        
                                        $sql = "SELECT * FROM users WHERE email = '$email' OR phone = '$phone'";
                                        $result = mysqli_query( $conn, $sql );

                                        if(mysqli_num_rows($result) > 0){
                                            $errors['not_unique'] = 'Email or phone already exists';
                                        }else{
                                            $password = md5($password);
                                            $sql = "INSERT INTO users (fname, lname, email, phone, password, role) VALUES ('$fname', '$lname', '$email', '$phone', '$password', 'customer')";
                                                                                    
                                            if ( $conn->query( $sql ) === TRUE ) {
                                                header('location: login.php');
                                            } else {
                                                // echo "Something went wrong";
                                                echo "Error: " . $sql . "<br>" . $conn->error;
                                            }
                                        }                                
                                    }
                                }

                                ?>
                            <form class="user" action="" method="POST">
                                <?php echo isset( $errors['register_form_fields'] ) ? "<span style='color: red; margin: 5px 12px'>{$errors['register_form_fields']}</span>" : '' ?>
                                <?php echo isset( $errors['not_unique'] ) ? "<span style='color: red; margin: 5px 12px'>{$errors['not_unique']}</span>" : '' ?>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="fname" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="First Name">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="lname" class="form-control form-control-user" id="exampleLastName"
                                            placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Email Address">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="phone" maxlength="11" class="form-control form-control-user" id="exampleInputPhone"
                                        placeholder="Phone Number">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="password_confirmation" class="form-control form-control-user"
                                        id="exampleRepeatPassword" placeholder="Repeat Password">
                                    </div>

                                    <?php echo isset( $errors['password'] ) ? "<span style='color: red; margin: 5px 12px'>{$errors['password']}</span>" : '' ?>
                                </div>
                                <input name="register" type="submit" class="btn btn-primary btn-user btn-block" value="Register Account">
                                <hr>
                                <!-- <a href="index.html" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Register with Google
                                </a>
                                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a> -->
                            </form>
                            <!-- <hr> -->
                            <div class="text-center">
                                <!-- <a class="small" href="forgot-password.html">Forgot Password?</a> -->
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a> <br>
                                <a class="small" href="admin-regsiter.php">Admin Account</a> <br>
                                <a class="small" href="/">&larr; Go to site</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>