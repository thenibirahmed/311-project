<?php require_once 'header.php' ?>
	<body>
		<!-- Page preloader-->
		
		<!-- Page-->
		<div class="page">
			<!-- Page Header-->
			<header class="section page-header breadcrumbs-custom-wrap bg-gradient bg-secondary-2 novi-background bg-cover">
				<!-- RD Navbar-->
				<div class="rd-navbar-wrap rd-navbar-default">
					<nav class="rd-navbar" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-fullwidth" data-xl-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-fixed" data-xl-device-layout="rd-navbar-static" data-md-stick-up-offset="2px" data-lg-stick-up-offset="2px" data-stick-up="true" data-sm-stick-up="true" data-md-stick-up="true" data-lg-stick-up="true" data-xl-stick-up="true">
						<div class="rd-navbar-inner"> 
							<!-- RD Navbar Panel-->
							<div class="rd-navbar-panel">
								<!-- RD Navbar Toggle-->
								<button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
								<!-- RD Navbar Brand-->
								<div class="rd-navbar-brand"><a class="brand-name" href="index.php"><img class="logo-default" src="images/logo-default-208x46.png" alt="" width="208" height="46"/><img class="logo-inverse" src="images/logo-inverse-208x46.png" alt="" width="208" height="46"/></a></div>
							</div>
							<div class="rd-navbar-aside-right">
								<div class="rd-navbar-nav-wrap">
									<!-- RD Navbar Nav-->
									<ul class="rd-navbar-nav">
										<li><a href="index.php">Home</a>
										</li>
										<li><a href="about-us.php">About Us</a>
										</li>
										<li><a href="contacts.php">Contacts</a>
										</li>									
										<li><a href="search_tour.php">Book Now</a>
										</li>									
									</ul>
								</div>
							</div>
						</div>
					</nav>
				</div>
				<!-- Breadcrumbs-->
				<section class="breadcrumbs-custom" style="background: url(images/img/about/breadcrumbs-bg.jpeg); background-size: cover;">
					<div class="container">
						<p class="breadcrumbs-custom-subtitle">You Made An Amazing Decision</p>
						<p class="heading-1 breadcrumbs-custom-title">Book Now</p>
						<ul class="breadcrumbs-custom-path">
							<li><a href="index.html">Home</a></li>
							<li class="active">Book Now</li>
						</ul>
					</div>
				</section>

			</header>

			<?php  
				require_once 'inc/connection.php';
                $tour_id = isset($_GET['tour_id']) ? $_GET['tour_id'] : '';
                $members = isset($_GET['members']) ? $_GET['members'] : '';

                if( empty($tour_id) ){
                    echo "<h1 class='text-danger text-center' style='color: red'>Request Param Not Found!!</h1>";
                    die;
                }
				$sql = "SELECT * FROM tours WHERE id='$tour_id'";

				
				$result = mysqli_query($conn, $sql);
				if( !$result ){
					echo mysqli_error($conn);
					die;
				}

				$row = mysqli_fetch_assoc($result);

				if( isset($_POST['book']) ){
					$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '' ;
					$tour_id = isset($_POST['tour_id']) ? $_POST['tour_id'] : '' ;
					$members = isset($_POST['members']) ? $_POST['members'] : '' ;

					$sql = "INSERT INTO bookings (`user_id`, `tour_id`,`is_paid`) VALUES ('$user_id', '$tour_id','0')";

					if ($conn->query($sql) !== TRUE) {	
						echo "Error: " . $sql . "<br>" . $conn->error;
						die;
					} 

					$booking_id = $conn->insert_id;

					foreach( $members as $member ){
						$sql = "INSERT INTO members (`booking_id`,`name`) VALUES ('$booking_id','$member')";

						if ($conn->query($sql) !== TRUE) {
							echo "Error: " . $sql . "<br>" . $conn->error;
							die;
						}
					}

					header('location: /admin');

				}
			?>


			<div class="body">
				<div class="container" style="margin-left:auto; margin-right:auto">
                    <h2 class="text-center mt-4">Book Tour for <?php echo $row['name'] ?></h2>
                    <?php if( isset($_SESSION['is_login']) && $_SESSION['is_login'] === true ){ ?>	
					<form action="" method="POST">
								
						<label>Name</label>
						<input disabled type="text" class="form-control" value="<?php echo $_SESSION['logged_in_user']['fname'] . ' ' . $_SESSION['logged_in_user']['lname']?>">
						
						<label class="mt-3">Email</label>
						<input disabled type="text" class="form-control" value="<?php echo $_SESSION['logged_in_user']['email'] ?>">
						
						<label class="mt-3">Phone</label>
						<input disabled type="text" class="form-control" value="<?php echo $_SESSION['logged_in_user']['phone'] ?>">

						<input name="user_id" type="hidden" value="<?php echo $_SESSION['logged_in_user']['id'] ?>">
						<input name="tour_id" type="hidden" value="<?php echo $_GET['tour_id'] ?>">
						<?php 
							if(isset($_GET['tour_id']) && isset($_GET['members']) && $_GET['members'] > 0 ) :							
								for( $i = 0; $i < $_GET['members']; $i++ ): ?>
									<label class="mt-3">Enter no <?php echo $i + 1 ?> tour members name </label>
									<input type="text" name="members[]" class="form-control">
								<?php endfor;  ?>
								<div class="text-center mb-3">
								<input onclick="return confirm('Ready to book?')" type="submit" name="book" class="btn btn-success btn-lg mt-4" value="Confirm">
						<?php endif; ?>
					</form>	

						<?php 
							if( isset($_GET['tour_id']) && ( !isset( $_GET['members'] ) || $_GET['members'] == 0 ) ){ ?>
								<form method="GET" action="book.php">
									<label class="mt-3">How many members do you want to go?</label> <br>
									<input value="<?php echo $_GET['tour_id'] ?>" type="hidden" name="tour_id">  <br>
									<input value="1" min="1" class="form-control" type="number" name="members">  <br>
									<input type="submit" class="btn btn-primary my-3">
								</form>
							<?php } ?>							
						
					<?php }else{ ?>
						<div class="text-center">
							<h3 class="text-danger">You're not logged in, to book a tour you must login first</h3>
							<a href="admin/login.php" class="btn btn-success btn">Login Now</a>
						</div>
					<?php } ?>
                    </div>
				</div>
				
			</div>
			

			<?php require_once 'footer.php' ?>
	</body>
</html>