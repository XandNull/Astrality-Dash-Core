<script async src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

<head>

    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Astrality Project</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.3/css/bootstrap-colorpicker.min.css" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">

</head>

<style>
body{
	background-color: #fcfcfc;
	font-family: 'Poppins', sans-serif;
} 
a{
	color: #b598f5;
	transition: 1s;
	display: inline-block;
	vertical-align: middle;
	-webkit-transform: perspective(1px) translateZ(0);
	transform: perspective(1px) translateZ(0);
	box-shadow: 0 0 1px rgba(0, 0, 0, 0);
}
a:hover{
	color: black;
}
a:active{
	-webkit-animation-name: hvr-push;
	animation-name: hvr-push;
	-webkit-animation-duration: 0.5s;
	animation-duration: 0.5s;
	-webkit-animation-timing-function: linear;
	animation-timing-function: linear;
	-webkit-animation-iteration-count: 1;
	animation-iteration-count: 1;
}
body::-webkit-scrollbar {
  width: 7px;
}
body::-webkit-scrollbar-track {
  background: #1b1e2100;
}
body::-webkit-scrollbar-thumb {
  background-color: #b598f5;
  border-radius: 20px;
  border: 3px solid #1b1e2100;
}
.hvr-grow-rotate {
  display: inline-block;
  vertical-align: middle;
  -webkit-transform: perspective(1px) translateZ(0);
  transform: perspective(1px) translateZ(0);
  box-shadow: 0 0 1px rgba(0, 0, 0, 0);
  -webkit-transition-duration: 0.3s;
  transition-duration: 0.3s;
  -webkit-transition-property: transform;
  transition-property: transform;
}
.hvr-grow-rotate:hover, .hvr-grow-rotate:focus, .hvr-grow-rotate:active {
  -webkit-transform: scale(1.1) rotate(4deg);
  transform: scale(1.1) rotate(4deg);
}
@-webkit-keyframes hvr-push {
  50% {
    -webkit-transform: scale(0.8);
    transform: scale(0.8);
  }
  100% {
    -webkit-transform: scale(1);
    transform: scale(1);
  }
}
@keyframes hvr-push {
  50% {
    -webkit-transform: scale(0.8);
    transform: scale(0.8);
  }
  100% {
    -webkit-transform: scale(1);
    transform: scale(1);
  }
}
.hvr-skew-forward {
  display: inline-block;
  vertical-align: middle;
  -webkit-transform: perspective(1px) translateZ(0);
  transform: perspective(1px) translateZ(0);
  box-shadow: 0 0 1px rgba(0, 0, 0, 0);
  -webkit-transition-duration: 0.3s;
  transition-duration: 0.3s;
  -webkit-transition-property: transform;
  transition-property: transform;
  -webkit-transform-origin: 0 100%;
  transform-origin: 0 100%;
}
.hvr-skew-forward:hover, .hvr-skew-forward:focus, .hvr-skew-forward:active {
  -webkit-transform: skew(-10deg);
  transform: skew(-10deg);
}
.hvr-skew-backward {
  display: inline-block;
  vertical-align: middle;
  -webkit-transform: perspective(1px) translateZ(0);
  transform: perspective(1px) translateZ(0);
  box-shadow: 0 0 1px rgba(0, 0, 0, 0);
  -webkit-transition-duration: 0.3s;
  transition-duration: 0.3s;
  -webkit-transition-property: transform;
  transition-property: transform;
  -webkit-transform-origin: 0 100%;
  transform-origin: 0 100%;
}
.hvr-skew-backward:hover, .hvr-skew-backward:focus, .hvr-skew-backward:active {
  -webkit-transform: skew(10deg);
  transform: skew(10deg);
}
.card{
	border-radius: 10px;
}
.modal-content {
	border: 0px;
	border-radius: 10px;
}
.btn{
	border-radius: 20px;
}
.dropdown-menu{
	border-radius: 10px;
}
.form-control{
	border-radius: 10px;
}
</style>
<?
class dashboardLib{
	public function printFooter(){
		echo '<br><footer class="text-center text-lg-start bg-light text-muted shadow-sm">
				<div class="container-lg text-center mt-2 text-white p-3" style="background-color: #b598f5; border-radius: 10px;">
					<i class="bi bi-at"></i> '.date("Y").' Copyright:
					<a class="text-white fw-bold" href="https://hentaidash.tk/">HentaiDash.tk</a> | by GreenTea12
				  </div>
				</footer>
			</div></div>
			<div class="mt-2"></div>';
	}
	public function print($content){
		$dl = new dashboardLib();
		$dl->printBody();
		$dl->printNavbar($active);
		echo "$content";
		$dl->printFooter();
	}
	public function printBody(){
		echo '<div class="container-lg container-box mt-2"><div class="p-3 w-100" style="border-radius: 10px;"><div class="card-block buffer w-100">';
	}
	public function printNavbar($active){
		require_once __DIR__."/../../serversdata/incl/lib/mainLib.php";
		$gs = new mainLib();
		$reg = '<a class="hvr-skew-forward" href="https://hentaidash.tk/dashboard/accounts/login.php">Login</a><br>
				<a class="hvr-skew-forward" href="https://hentaidash.tk/dashboard/accounts/register.php">Register</a>';
		$userName = ' Account';
		if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
			$userName = $gs->getAccountName($_SESSION["accountID"]);
			if($gs->checkPermission($_SESSION["accountID"], "isAdmin")){
				$admin = '<a class="hvr-skew-forward" href="https://hentaidash.tk/dashboard/src/secret.php">Admin Panel</a><hr class="dropdown-divider">';
			}
			$reg = '
			<a class="hvr-skew-forward" href="https://hentaidash.tk/dashboard/accounts/'.$userName.'">Profile</a><br>
			<a class="hvr-skew-forward" href="https://hentaidash.tk/dashboard/accounts/settings.php">Settings</a><br>
			<a class="hvr-skew-forward" href="https://hentaidash.tk/dashboard/songadd.php">Song Add</a><br>
			
			<hr class="dropdown-divider">
			<a class="hvr-skew-forward" href="https://hentaidash.tk/dashboard/accounts/logout.php">Logout</a>';
		}
		echo '<div class="card p-3"><nav class="navbar navbar-dark navbar-expand-lg shadow-sm w-100" style="background-color: #b598f5; border-radius: 10px;">
				<div class="container">
					<a class="navbar-brand hvr-grow-rotate" href="https://hentaidash.tk/dashboard/index.php"><i class="bi bi-stars"></i> Astrality</a>
						<div class="nav-item dropdown text-end navbar-nav">
							<a class="nav-link dropdown-toggle hvr-push" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-palette"></i> Themes</a>
							<div class="dropdown-menu text-center" aria-labelledby="navbarDropdown">
								<a class="hvr-skew-forward" href="#">Dark</a><br>
								<a class="hvr-skew-forward" href="#">Light</a><br>
								<li><hr class="dropdown-divider"></li>
								<a class="hvr-skew-forward" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2">Custom</a>
								<p class="mt-2" style="font-size: 13px;"> Темы не работают(( </p>
							</div>
							
							<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header text-dark">
												<h5 class="modal-title text-center" id="exampleModalLabel">Dashboard Customization</h5>
											</div>
										<div class="modal-body text-center">
											<div class="row text-center">
												<div class="row">
													<div class="col">
														<div align="center">Navbar:<input id="cp1" type="text" class="form-control w-25" value="#ffffff"/></div>
													</div>
													<div class="col">
														<div align="center">BG:<input id="cp2" type="text" class="form-control w-25" value="#ffffff"/></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="modal fade" id="songadd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header text-dark">
											<h5 class="modal-title text-center" id="exampleModalLabel">No youtube links, only Dropbox/Soundcloud</h5>
										</div>
										<div class="modal-body text-center">
											<div class="row text-center">
												<div class="col-md-8 mx-auto">
													<div class="row">
															<form action="https://hentaidash.tk/dashboard/src/dashboardLib.php" method="post">Link: <input type="text" class="input-group form-control w-75 mx-auto" name="songlink">
															<input type="submit" value="Add Song" class="btn btn-sm text-white hvr-grow mt-2" style="background-color: #b598f5;"></form>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<a class="nav-link dropdown-toggle hvr-push" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-person-circle"></i> '.$userName.'</a>
							<div class="dropdown-menu text-center dropdown-menu-right" aria-labelledby="navbarDropdown">
								'.$reg.'
							</div>
						</div>
					  </div>
					</nav>';
	}
	public function printLoginBox($content){
		$this->print("<h2 class='mt-5 text-center card w-50 mx-auto p-2'>Login</h2>".$content);
	}
	public function printLoginBoxInvalid(){
		$this->printLoginBox("<p class='mt-3 card w-50 mx-auto text-center'>Invalid username or password. <a href=''>Click here to try again.</a>");
	}
	public function printLoginBoxError($content){
		$this->printLoginBox("<p class='mt-3 card w-50 mx-auto text-center'>An error has occured: $content. <a href=''>Click here to try again.</a>");
	}
	public function convertToDate($timestamp){
		return date("d/m/Y G:i:s", $timestamp);
	}
	public function generateLineChart($elementID, $name, $data){
		$labels = implode('","', array_keys($data));
		$data = implode(',', $data);
		$chart = "<script>
					var ctx = document.getElementById(\"$elementID\");
					var myChart = new Chart(ctx, {
						type: 'bar',
						data: {
							labels: [\"$labels\"],
							datasets: [{
								label: '$name',
								data: [$data],
								backgroundColor: [
									'rgba(255, 99, 132, 0.1)'
								],
								borderColor: [
									'rgba(255,99,132,1)'
								],
							}]
						},
						options: {
							responsive: true,
							maintainAspectRatio: false,
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero:true
									}
								}]
							}
						}
					});
					</script>";
		return $chart;
	}
}
?>
<script>
$(function () {
    $('#cp1, #cp2').colorpicker();
  });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.3/js/bootstrap-colorpicker.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
