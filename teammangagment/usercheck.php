
<?php
session_start();
require('../assets/php/api/mysql/mysql_connetion.php');

if($_SESSION['login']==0){
  header("Location : ../../index.php");
}else

if(empty($_GET['name'])){
  header("../index.php");
}else{
$name = $_GET['name'];



?>
<html>
<head>

    <meta charset="utf-8">
    <title>AktenSystem Teammangagment</title>
    <link rel="shortcut icon" type="image/png" href="/img/logo.png">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
      <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js"></script>
    <style>
    .andern a:hover{
      background-color: darkgreen;
    }
    .loschen a:hover{
      background-color: darkred;
    }
    </style>
    <script>
  function openSlideMenu(){
    document.getElementById('menu').style.width = '250px';
    document.getElementById('content').style.marginLeft = '250px';
  }
  function closeSlideMenu(){
    document.getElementById('menu').style.width = '0';
    document.getElementById('content').style.marginLeft = '0';
  }
</script>
<script language="JavaScript">

function Passwordandern()
{
 var breite=400;
 var hoehe=500;
 var positionX=((screen.availWidth / 2) - breite / 2);
 var positionY=((screen.availHeight / 2) - hoehe / 2);
 var ur='';
 var url=ur;
 pop=window.open('','Password andern','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0,fullscreen=0,width='+breite+',height='+hoehe+',top=10000,left=10000');
 pop.blur();
 pop.resizeTo(breite,hoehe);
 pop.moveTo(positionX,positionY);
 pop.location=url;
 }
onerror = stopError;
function stopError()
{return true;}
//-->
</script>
</head>
<body>
  <script type="text/javascript" color="76, 209, 55" opacity="1.4" zindex="-2" count="100" src="http://www.cssscript.com/demo/interactive-particle-nest-system-with-javascript-and-canvas-canvas-nest-js/canvas-nest.js"></script><canvas id="c_n2" width="725" height="913" style="position: fixed; top: 0px; left: 0px; z-index: -2; opacity: 0.7;"></canvas>
    <div id="content">

    <span class="slide">
      <a onclick="openSlideMenu()">
        <i class="fas fa-bars"></i>
      </a>
    </span>

    <div id="menu" class="nav">
      <a class="close" onclick="closeSlideMenu()">
        <i class="fas fa-times"></i>
      </a>
      <a href="../index.php">Home</a>
      <a href="index.php">Team</a>
      </div>
    <div class="inter">
    <center>
      <h1>Teammangagment vom AktenSystem</h1>
      <br><br>
      <?php echo '<h2>Account von '.$name.'</h2>
<br><br><br><br><br><br>  <div class="pricing-table">      <div class="col">

        <div class="table">
        <ul>
        <li></li>
        <li>Username : <br><strong>'.$name.'</strong></li>
          <li></li>
        </ul>
        <div class="loschen">
            <a href="edituser.php?name='.$name.'" >Edit</a>
        </div>
        <div class="loschen">
            <a href="deleteuser.php?name='.$name.'" >Löschen</a>
        </div>

        </div></div>
        '; ?>
    </div>
      <br><br><br><br>

    </center>
  </div>

</body>
</html>
<?php } ?>
