<? include 'topnav.php'; ?>
<? $foto = "https://lh3.googleusercontent.com/proxy/VfAnij4qURuCN9YhtuST_5ZnidUYy_p0oDDV3wUfQNn1Q_nyTlH2hNGuV63OBYFJ6NUAmADEqOK-zHpr_KZLDefuW8N3j6hfes4vBJQxNCVeH9qQnEo2zrbj6pAV1c0t1qM94w"; ?>
<style>
.server {
    background-color: #1d1d1d;
    color: white;
    padding: 5px 5px;
    border-radius: 5px;
    width: 500px;
    text-align: center;
    display: inline-block;
}
.btn-white {
  position: relative;
  display: inline-block;
  text-decoration: none;
  text-transform: uppercase;
  background-color: #ffffff1f;
  color: white;
  padding: 12px 40px;
  border-radius: 5px;
  overflow: hidden;
}
.btn-white:before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 2em;
  height: 100%;
  background-color: #ffffff17;
  transform: translateX(-4em) skewX(-45deg);
}
.btn-white:hover:before {
    animation: moveLight 1.5s;
}
         @keyframes moveLight {
from {
    transform: translateX(-4em) skewX(-45deg);
}
to {
    transform: translateX(20em) skewX(-45deg);
}
}
@media screen and (max-width: 650px) {
	.server {
		background-color: #1d1d1d;
		color: white;
		padding: 5px 5px;
		border-radius: 5px;
		width: 350px;
		text-align: center;
	}
}
.crown {
    width: 50px;
    margin: -40px;
}

/* Модальный (фон) */
.modal {
  display: none; /* Скрыто по умолчанию */
  position: fixed; /* Оставаться на месте */
  z-index: 1; /* Сидеть на вершине */
  padding-top: 100px; /* Расположение коробки */
  left: 0;
  top: 0;
  width: 100%; /* Полная ширина */
  height: 100%; /* Полная высота */
  overflow: auto; /* Включите прокрутку, если это необходимо */
  background-color: rgb(0,0,0); /* Цвет запасной вариант  */
  background-color: rgba(0,0,0,0.4); /*Черный с непрозрачностью */
  backdrop-filter: blur(5px);
}

/* Модальное содержание */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: none;
  width: 40%;
  border-radius: 5px;
}

/* Кнопка закрытия */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
#myBtn {
    border: none;
    background-color: white;
    color: black;
    padding: 10px;
    width: 350px;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
    border-radius: 5px;
}
#myBtn:hover {
    background-color: #cacaca;
}
#myBtn:focus {
    background-color: #969696;
}
</style>

<!-- Модальном окно -->
<div id="myModal" class="modal">

  <!-- Модальное содержание -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <h1>BLACKLIST | Hostings, servers</h1>
    <p>Coming soon...</p>
  </div>

</div>
<?php
$id = '1blQtNjq1Uke1DbB4g_muwgNjMkBagFq5b2PuEzez9Cc';
$gid = '0';
 
$csv = file_get_contents('https://docs.google.com/spreadsheets/d/' . $id . '/export?format=csv&gid=' . $gid);
$csv = explode("\r\n", $csv);
$array = array_map('str_getcsv', $csv);

?>
<br>
<div align="center" style="color:white;">
<h1>GDPSR - Rating</h1>
<p>TOP 100 Geometry Dash Private Servers!</p>
<button id="myBtn">BlackList</button>
<br>
<br>
<?php
$govno = '';
$crown = '';
for ($i = 1; $i <= 8; $i++) {
	if($i == "1"){
		$govno = 'background: linear-gradient(90deg, rgb(0, 0, 0), rgb(228 179 41 / 50%)), url(https://static.gamehag.com/upload/oeKNI1lON2x1wjrARBHUWQjFUkbnSN.jpg);';
		$crown = '<img class="crown" src="https://hentaidash.tk/gdpsr/crown.svg">';
	}elseif($i == "2"){
		$crown = '';
		$govno = 'background: linear-gradient(90deg, rgb(0, 0, 0), rgb(62 75 222 / 50%)), url(https://static.gamehag.com/upload/oeKNI1lON2x1wjrARBHUWQjFUkbnSN.jpg);';
	}elseif($i == "3"){
		$crown = '';
		$govno = 'background: linear-gradient(90deg, rgb(0, 0, 0), rgb(232 64 234 / 50%)), url(https://static.gamehag.com/upload/oeKNI1lON2x1wjrARBHUWQjFUkbnSN.jpg);';
	}else{
		$crown = '';
		$govno = 'background: linear-gradient(90deg, rgb(0, 0, 0), rgb(0 0 0 / 50%)), url(https://static.gamehag.com/upload/oeKNI1lON2x1wjrARBHUWQjFUkbnSN.jpg);';
	}
	echo '
	<div class="server" style="margin-left: 10px;margin-top: 20px; '.$govno.'">
	'.$crown.'
		<h1>'.$array[$i][0].'</h1>
		<h5>Rank: №'.$i.'<br>Client: '.$array[$i][1].'<br>Server: '.$array[$i][2].'<br>Community: '.$array[$i][3].'<br>Total: '.$array[$i][4].'</h5>
		<a class="btn-white" href="rating.php">View</a><br><b>
	</div>
	';
}

?>
<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>