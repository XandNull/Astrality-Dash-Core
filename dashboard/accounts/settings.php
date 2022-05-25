<?php
session_start();
require "../src/dashboardLib.php";
require "../../serversdata/incl/lib/connection.php";
?>
<style>
.izi {
}
.js-tilt-glare {
  border-radius: 30px;
}
</style>
<?php
if(empty($_SESSION["accountID"])){
	error_reporting(0);
	$dl->print("<div align='center' class='card mt-4 w-50 mx-auto'> pls login <a href='https://hentaidash.tk/dashboard/accounts/login.php'> Log In</a> </div>");
	exit();
}
#exit('чай переписывает систему аватарок, все сеттинги тоже потом если че');

$accountID = $_SESSION["accountID"];

$query = $db->prepare("SELECT avatar FROM users WHERE extID = '".$accountID."'");
$query->execute();
$avatar = $query->fetchColumn();

if($avatar == "0"){
	$avatar = "avatars/1.png";
}else{
	$avatar = $avatar;
}

$query = $db->prepare("SELECT banner FROM users WHERE extID = '".$accountID."'");
$query->execute();
$banner = $query->fetchColumn();

if($banner == "0"){
	$banner = "banners/1.gif";
}else{
	$banner = $banner;
}

$query = $db->prepare("SELECT userName FROM users WHERE extID = '".$accountID."'");
$query->execute();
$userName = $query->fetchColumn();

$query = $db->prepare("SELECT * FROM actions WHERE value LIKE :usr");
$query->execute([':usr' => $userName]);
$result = $query->fetchAll();
foreach($result as &$ips);
if($query->rowCount() == 0){
	$ip = '127.0.0.1';
}else{
	$ip = $ips["value2"];
}
	

$dl = new dashboardLib();
$dl->print('<br>
<div class="container-md text-center text-dark p-3 card">
	<div class="row row-cols-1 row-cols-md-4 mx-auto">
		<div class="col w-100 p-3 text-white" style="background-color: #b598f5; border-radius: 10px;">
			Settings
		</div>
		<div class="col w-25 p-3 text-white mt-2" style="background-color: #b598f5; border-radius: 10px 0px 0px 10px;">
			Profile (все не робит, кроме смены аватарок и баннера)
		</div>
	
		<div class="col w-75 p-3 text-white mt-2 text-left" style="background-color: #9e80e1; border-radius: 0px 10px 10px 0px;">
			Username: GreenTea12<br>
			<hr class="dropdown-divider">
			<form class="row g-1 mt-2">
			  <div class="col-auto">
				New Username:
			  </div>
			  <div class="col-auto">
				<label for="inputPassword2" class="sr-only">Username</label>
				<input type="text" class="form-control form-control-sm" id="inputPassword2" placeholder="Username">
				<span id="passwordHelpInline" class="form-text text-white text-center">Must be 3-15 characters long.</span><br>
				<span id="passwordHelpInline" class="form-text text-white text-center">Save your account before changing<br>and re-enter your account.&nbsp<span class="badge bg-danger">Warning!</span></span>
			  </div>
			  <div class="col-auto">
					<button type="submit" class="btn text-dark btn-light btn-sm">Submit</button>
				  </div>
			</form>
			<form class="row g-1">
				<div class="col-auto">
					New Prefix:
				</div>
				<div class="col-auto">
					<label for="inputPassword2" class="sr-only">Prefix</label>
					<input type="text" class="form-control form-control-sm" id="inputPassword2" placeholder="Prefix">
					<span id="passwordHelpInline" class="form-text text-white">Must be 2-12 characters long.</span>
				</div>
				<div class="col-auto">
					<button type="submit" class="btn text-dark btn-light btn-sm">Submit</button>
				  </div>
			</form>
			<hr class="dropdown-divider">
			<form class="row g-1 mt-2">
			  <div class="col-auto">
				VK:
			  </div>
			  <div class="col-auto">
				<label for="inputPassword2" class="sr-only">link</label>
				<input type="text" class="form-control form-control-sm" id="inputPassword2" placeholder="link">
			  </div>
			  <div class="col-auto">
					<button type="submit" class="btn text-dark btn-light btn-sm">Submit</button>
				  </div>
			</form>
			<form class="row g-1">
				<div class="col-auto">
					Discord:
				  </div>
				  <div class="col-auto">
					<label for="inputPassword2" class="sr-only">link</label>
					<input type="Password" class="form-control form-control-sm" id="inputPassword2" placeholder="link">
				  </div>
				  <div class="col-auto">
					<button type="submit" class="btn text-dark btn-light btn-sm">Submit</button>
				  </div>
			</form>
		</div>
		
		<div class="col w-25 p-3 text-white mt-2" style="background-color: #b598f5; border-radius: 10px 0px 0px 10px;">
			Avatar | Banner
		</div>

		<div class="col w-75 p-3 text-white mt-2" style="background-color: #9e80e1; border-radius: 0px 10px 10px 0px;">
			<img src="'.$avatar.'" class="izi" style="border-radius: 10px; width: 200px; height: 200px;">
			<img src="'.$banner.'" style="height: 155px; border-radius: 5px; width: 500px; height: 200px;" class="izi">
			<form class="mt-2" action="image.php" method="POST" enctype="multipart/form-data"><input type="file" name="avatar"><button type="submit" class="btn text-dark btn-light btn-sm">Avatar</button></form>
			<form action="image.php" method="POST" enctype="multipart/form-data"><input type="file" name="banner"><button type="submit" class="btn text-dark btn-light btn-sm">Banner</button></form>
		</div>
		
		<div class="col w-25 p-3 text-white mt-2" style="background-color: #b598f5; border-radius: 10px 0px 0px 10px;">
			Password
		</div>

		<div class="col w-75 p-3 text-white mt-2" style="background-color: #9e80e1; border-radius: 0px 10px 10px 0px;">
			<form class="row g-1">
				  <div class="col-auto">
					New Password:
				  </div>
				  <div class="col-auto">
					<label for="inputPassword2" class="sr-only">Password</label>
					<input type="Password" class="form-control form-control-sm" id="inputPassword2" placeholder="Password">
					<span id="passwordHelpInline" class="form-text text-white">Must be 6-20 characters long.</span>
				  </div>
			</form>
			<form class="row g-1">
				  <div class="col-auto">
					Old Password:
				  </div>
				  <div class="col-auto">
					<label for="inputPassword2" class="sr-only">Password</label>
					<input type="Password" class="form-control form-control-sm" id="inputPassword2" placeholder="Password">
					<span id="passwordHelpInline" class="form-text text-white">Must be 6-20 characters long.</span><br>
					<span id="passwordHelpInline" class="form-text text-white">Save your account before changing<br>and re-enter your account.&nbsp<span class="badge bg-danger">Warning!</span></span>
				  </div>
				  <div class="col-auto">
					<button type="submit" class="btn text-dark btn-light btn-sm">Submit</button>
				  </div>
			</form>
		</div>
		
		<div class="col w-25 p-3 text-white mt-2" style="background-color: #b598f5; border-radius: 10px 0px 0px 10px;">
			Email
		</div>

		<div class="col w-75 p-3 text-white mt-2" style="background-color: #9e80e1; border-radius: 0px 10px 10px 0px;">
			<form class="row g-1">
				  <div class="col-auto">
					New Email:
				  </div>
				  <div class="col-auto">
					<label for="inputPassword2" class="sr-only">Password</label>
					<input type="Password" class="form-control form-control-sm" id="inputPassword2" placeholder="Password">
					<span id="passwordHelpInline" class="form-text text-white">Must be 3-15 characters long.</span>
				  </div>
			</form>
			<form class="row g-1">
				  <div class="col-auto">
					Password:
				  </div>
				  <div class="col-auto">
					<label for="inputPassword2" class="sr-only">Password</label>
					<input type="Password" class="form-control form-control-sm" id="inputPassword2" placeholder="Password">
					<span id="passwordHelpInline" class="form-text text-white">Must be 6-20 characters long.</span>
					
				  </div>
				  <div class="col-auto">
					<button type="submit" class="btn text-dark btn-light btn-sm">Submit</button>
				  </div>
			</form>
		</div>
		
		<div class="col w-25 p-3 text-white mt-2" style="background-color: #b598f5; border-radius: 10px 0px 0px 10px;">
			Security
		</div>

		<div class="col w-75 p-3 text-white mt-2 text-left" style="background-color: #9e80e1; border-radius: 0px 10px 10px 0px;">
			Last activity from: '.$ip.'
		</div>
		
	</div>
</div>

</div>');
?>
<script src="../src/vanilla-tilt.min.js"></script>
    <script>
      VanillaTilt.init(document.querySelectorAll(".izi"),{
        glare: false,
        reverse: true,
        "max-glare": 0.5
      });
    </script>