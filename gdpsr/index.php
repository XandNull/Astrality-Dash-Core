<? include 'topnav.php'; ?>
<style>
.box-main-v1 {
    background-color: #1d1d1d;
    color: white;
    padding: 5px 5px;
    border-radius: 5px;
    width: 250px;
    text-align: center;
    display: inline-block;
}
.btn-white {
    background-color: white;
    color: black;
    padding: 10px 10px;
    text-decoration: none;
    transition: .4s;
    border-radius: 5px;
}
.btn-white:hover {
    background-color: #1d1d1d;
    color: white;
}
@media screen and (max-width: 650px) {
	.box-main-v1 {
		background-color: #1d1d1d;
		color: white;
		padding: 5px 5px;
		border-radius: 5px;
		width: 250px;
		text-align: center;
		display: inline-block;
		margin-top: 5px;
	}
}
</style>
<br>
<div align="center" style="color:white;">
<h1>GDPSR - First GDPS rating system</h1>
<p>Welcome!</p>
<br>
<div class="box-main-v1">
<br>
    <i style="font-size: 100px;" class="bi bi-archive-fill"></i>
    <h1>All in one</h1>
    <p>All servers!</p>
</div>
<div class="box-main-v1">
<br>
    <i style="font-size: 100px;" class="bi bi-award-fill"></i>
    <h1>Honest rating</h1>
    <p>Everything is fair</p>
</div>
<div class="box-main-v1">
<br>
    <i style="font-size: 100px;" class="bi bi-bar-chart-fill"></i>
    <h1>So many!</h1>
    <p>Huge number of servers</p>
</div>
<div class="box-main-v1">
<br>
    <i style="font-size: 100px;" class="bi bi-bookmark-check-fill"></i>
    <h1>Tell us!</h1>
    <p>Tell us interesting projects!</p>
</div>
<br>
<br>
<br>
<a class="btn-white" href="rating.php"><i class="bi bi-award-fill"></i> View top 100 servers!</a>
<a class="btn-white" href="https://discord.gg/invite/rnmYNwvGx8"><i class="bi bi-discord"></i> Suggest a server</a><br><br>

<script src="vanilla-tilt.min.js"></script>
    <script>
      VanillaTilt.init(document.querySelectorAll(".box-main-v1"),{
        glare: true,
        reverse: true,
        "max-glare": 0.5
      });
    </script>