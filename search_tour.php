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
										<li class="active"><a href="#">Book Now</a>
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
						<p class="heading-1 breadcrumbs-custom-title">Search Results</p>
						<ul class="breadcrumbs-custom-path">
							<li><a href="index.html">Home</a></li>
							<li class="active">Search Results</li>
						</ul>
					</div>
				</section>

			</header>

			<?php  
				require_once 'inc/connection.php';

				$adults = isset($_GET['adults']) ? $_GET['adults'] : 0;
				$childs = isset($_GET['childs']) ? $_GET['childs'] : 0;
				$total = $adults + $childs;

				$sql = "SELECT * FROM tours ";

				$sql .= isset($_GET['from']) ? "WHERE `from`='{$_GET['from']}'" : '';
				$sql .= isset($_GET['to']) ? " AND `to`='{$_GET['to']}'" : '';

				if(isset($_GET['start_date']) && ! empty($_GET['start_date']) ){ // date formatting
					$splitted = explode('-',$_GET['start_date']);
					$m = $splitted[0];
					$d = $splitted[1];
					$y = $splitted[2];
					$start_date = $y . "-" . $m . "-" . $d;

					$sql .= " AND `start_date`='{$start_date}'";
				}

				$sql .= isset($_GET['duration']) ? " AND `duration`='{$_GET['duration']}'" : '';
				// echo $sql;die;
				$result = mysqli_query($conn, $sql);
				if( !$result ){
					echo mysqli_error($conn);
				}
			?>

			<div class="body">
				<div class="container" style="margin-left:auto; margin-right:auto">
				<h2 class="text-center mt-4">Choose the best tour for you</h2>
				<table class="table table-bordered table-hover table-striped py-5 my-5 rounded">

							<tr>
								<th><b>Name</b></th>
								<th><b>From</b></th>
								<th><b>To</b></th>
								<th><b>Date</b></th>
								<th><b>Budget</b></th>
								<th><b>Duration</b></th>
								<th><b>Details</b></th>
							</tr>
							<?php 
								while($row = mysqli_fetch_assoc($result)) :
							?>
							<tr>
								<td><?php echo $row['name'] ?></td>
								<td><?php echo $row['from'] ?></td>
								<td><?php echo $row['to'] ?></td>
								<td><?php 
									$dateParts = explode('-',$row['start_date']);
									$y = $dateParts[0];
									$m = $dateParts[1];
									$d = $dateParts[2];
									echo $d . '/'. $m . '/' . $y;
								?></td>
								<td><?php echo $row['budget'] ?> Tk</td>
								<td><?php echo $row['duration'] ?> Days</td>
								<td>
									<a href="tour_details.php?tour_id=<?php echo $row['id'] ?>&members=<?php echo $total ?>" class="btn btn-outline-success">See Details</a>
								</td>
							</tr>
							<?php endwhile; ?>
								
				</table>
				</div>
				
			</div>
			

			<?php require_once 'footer.php' ?>
	</body>
</html>