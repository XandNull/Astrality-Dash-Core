<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
<meta name="viewport" content="width=device-width; initial-scale=1.0">
<meta charset="utf-8"><title>HentaiDash Project</title>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<style>
body{
	background-color: #fcfcfc;
	font-family: 'Comfortaa', cursive;
} 
a{
	color: #ffadf7;
	transition: 1s;
}
a:hover{
	color: black;
}
body::-webkit-scrollbar {
  width: 7px;
}
body::-webkit-scrollbar-track {
  background: #1b1e2100;
}
body::-webkit-scrollbar-thumb {
  background-color: #ffadf7;
  border-radius: 15px;
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
</style>
<nav class="container navbar navbar-dark navbar-expand-lg mt-2" style="background-color: #ffadf7; border-radius: 3px;">
  <div class="container">
    <a class="navbar-brand hvr-grow-rotate" href="#"><i class="bi bi-suit-heart"></i> HentaiDash</a>
	<div class="nav-item dropdown text-end navbar-nav">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-palette"></i> Themes</a>
		<div class="dropdown-menu text-center" aria-labelledby="navbarDropdown">
			<a href="#">Dark</a><br>
			<a href="#">Light</a>
		</div>
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-person-circle"></i> Account</a>
		<div class="dropdown-menu text-center" aria-labelledby="navbarDropdown">
			<a href="#">Login</a><br>
			<a href="#">Register</a>
			<li><hr class="dropdown-divider"></li>
			<a href="#">Forgot Password?</a>
		</div>
	</div>
  </div>
</nav>
<div class="container-md mt-2 text-center text-white p-1 w-75" style="background-color: #ffadf7; border-radius: 3px;">
<h4 class="mt-3"> Beta Test <?= date("d/m/Y") ?>
<div class="container-md text-center text-dark p-1 mt-3 w-25" style="background-color: white; border-radius: 3px;">
	<button type="button" class="btn text-white" style="background-color: #ffadf7;" data-bs-toggle="modal" data-bs-target="#exampleModal">Download</button>
	<button type="button" class="btn text-white" style="background-color: #ffadf7;" href="#">Updates</button>
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-center" id="exampleModalLabel">HentaiDash v1.0</h5>
				</div>
			<div class="modal-body text-center">
				<div class="row text-center">
					<div class="col-md-8 mx-auto">
						<button type="button" class="btn text-white" style="background-color: #ffadf7;" href="#">Android</button>
						<button type="button" class="btn text-white" style="background-color: #ffadf7;" href="#">PC</button>
						<button type="button" class="btn text-white" style="background-color: #ffadf7;" href="#">IOS</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<br>
<div class="row row-cols-1 row-cols-md-3 g-4">
	<div class="col">
		<div><iframe src="https://discord.com/widget?id=865886009568133140&theme=light" width="300" height="479" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe></div>
	</div>
	<div class="col">
		<div class="container-md text-center text-dark p-1" style="background-color: white; border-radius: 3px; width: 300;">Server Stats</div>
		<div class="container-md text-center text-dark mt-2 p-1" style="background-color: white; border-radius: 3px; width: 300;">Players: 0</div>
		<div class="container-md text-center text-dark mt-2 p-1" style="background-color: white; border-radius: 3px; width: 300;">Users: 0</div>
		<div class="container-md text-center text-dark mt-2 p-1" style="background-color: white; border-radius: 3px; width: 300;">Levels: 0</div>
		<div class="container-md text-center text-dark mt-2 p-1" style="background-color: white; border-radius: 3px; width: 300;">Comments: 0</div>
		<div class="container-md text-center text-dark mt-2 p-1" style="background-color: white; border-radius: 3px; width: 300;">Posts: 0</div>
		<div class="container-md text-center text-dark mt-2 p-1" style="background-color: white; border-radius: 3px; width: 300;">Messages: 0</div>
		<div class="container-md text-center text-dark mt-2 p-1" style="background-color: white; border-radius: 3px; width: 300;">Moderators: 0</div>
		<div class="container-md text-center text-dark mt-2 p-1" style="background-color: white; border-radius: 3px; width: 300;">Clans: 0</div>
		<div class="container-md text-center text-dark mt-2 p-1" style="background-color: white; border-radius: 3px; width: 300;">Map-packs: 0</div>
		<div class="container-md text-center text-dark mt-2 p-1" style="background-color: white; border-radius: 3px; width: 300;">Gauntlets: 0</div>
	</div>
	<div class="col">
		<div class="container-md text-center text-dark p-1" style="background-color: white; border-radius: 3px; width: 300;">Server Daily Level</div>
		<div class="container-md text-center text-dark mt-1 p-1" style="background-color: white; border-radius: 3px; width: 300;">test</div>
		<div class="container-md text-center text-dark p-1 mt-4" style="background-color: white; border-radius: 3px; width: 300;">Server Weekly Level</div>
		<div class="container-md text-center text-dark mt-1 p-1" style="background-color: white; border-radius: 3px; width: 300;">test</div>
		<div class="container-md text-center text-dark p-1 mt-4" style="background-color: white; border-radius: 3px; width: 300;">Top 1 Player</div>
		<div class="container-md text-center text-dark mt-1 p-1" style="background-color: white; border-radius: 3px; width: 300;">test</div>
		<div class="container-md text-center text-dark p-1 mt-4" style="background-color: white; border-radius: 3px; width: 300;">Top 1 Creator</div>
		<div class="container-md text-center text-dark mt-1 p-1" style="background-color: white; border-radius: 3px; width: 300;">test</div>
		<div class="container-md text-center text-dark p-1 mt-4" style="background-color: white; border-radius: 3px; width: 300;">Best Level</div>
		<div class="container-md text-center text-dark mt-1 p-1" style="background-color: white; border-radius: 3px; width: 300;">test</div>
	</div>
</div>
<br></div>
<footer class="text-center text-lg-start bg-light text-muted">
<div class="container text-center mt-2 text-white p-3" style="background-color: #ffadf7; border-radius: 3px;">
    © <?=date("Y") ?> Copyright:
    <a class="text-white fw-bold" href="https://hentaidash.tk/">HentaiDash.tk</a>
  </div>
</footer>
<div class="container-md mt-2"></div>
<script src="src/vanilla-tilt.min.js"></script>
    <script>
      VanillaTilt.init(document.querySelectorAll(".wtf"),{
        glare: false,
        reverse: true,
        "max-glare": 0.5
      });
    </script>