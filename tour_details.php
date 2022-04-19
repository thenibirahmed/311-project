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
						<p class="breadcrumbs-custom-subtitle">Your Tours</p>
						<p class="heading-1 breadcrumbs-custom-title">Tour Details</p>
						<ul class="breadcrumbs-custom-path">
							<li><a href="index.html">Home</a></li>
							<li class="active">Tour Details</li>
						</ul>
					</div>
				</section>

			</header>

			<?php  
				require_once 'inc/connection.php';
                $tour_id = isset($_GET['tour_id']) ? $_GET['tour_id'] : '';

                if( empty($tour_id) ){
                    echo "<h1 class='text-danger text-center' style='color: red'>Request Param Not Found!!</h1>";
                    die;
                }
				$sql = "SELECT * FROM tours WHERE id='$tour_id'";

				
				$result = mysqli_query($conn, $sql);
				if( !$result ){
					echo mysqli_error($conn);
				}
			?>

                <?php 
                    $row = mysqli_fetch_assoc($result)
                ?>	

			<div class="body">
				<div class="container" style="margin-left:auto; margin-right:auto">
                    <h2 class="text-center mt-4">Tour Details of <?php echo $row['name'] ?></h2>
                    <table class="table table-bordered table-hover table-striped py-5 my-5 rounded">
                                
                        <tr>
                            <th>Name</th>
                            <td><?php echo $row['name'] ?></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td><?php echo $row['description'] ?></td>
                        </tr>
                        <tr>
                            <th>From</th>
                            <td><?php echo $row['from'] ?></td>
                        </tr>
                        <tr>
                            <th>To</th>
                            <td><?php echo $row['to'] ?></td>
                        </tr>
                        <tr>
                            <th>Start Date</th>
                            <td><?php echo $row['start_date'] ?></td>
                        </tr>
                        <tr>
                            <th>Budget</th>
                            <td><?php echo $row['budget'] ?> Tk</td>
                        </tr>
                        <tr>
                            <th>Duration</th>
                            <td><?php echo $row['duration'] ?></td>
                        </tr>
                        <tr>
                            <th>Capacity</th>
                            <td><?php echo $row['capacity'] ?></td>
                        </tr>						
                                    
                    </table>
                    <div class="text-center mb-3">
                        <a href="book.php?tour_id=<?php echo $tour_id ?>&members=<?php echo isset($_GET['members']) ? $_GET['members'] : 0 ?>" class="btn btn-success btn-lg">Book Now</a>
                    </div>
				</div>
				
			</div>
			

			<?php require_once 'footer.php' ?>
	</body>
</html>