<?php session_start();
require('../assets/php/api/mysql/mysql_connetion.php');

if($_SESSION['login']===0){
  header("Location : ../index.php");
}else

?>
<html>
<head>

    <meta charset="utf-8">
    <title>loginSystem Teammangagment</title>
    <link rel="shortcut icon" type="image/png" href="/img/logo.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/login/style.css">
    <link rel="stylesheet" href="../assets/css/bootstap/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <script>
  function openSlideMenu(){
    document.getElementById('menu').style.width = '250px';
    document.getElementById('content').style.marginLeft = '250px';
  }
  function closeSlideMenu(){
    document.getElementById('menu').style.width = '0';
    document.getElementById('content').style.marginLeft = '0';
  }
  function openregisterclick(){
    document.getElementById('register').style.width = '40%';
    document.getElementById('register').style.height = '40%';
  }
</script>
<script language="JavaScript">

function Register()
{
 var breite=screen.availWidth;
 var hoehe=screen.availHeight;
 var positionX=((screen.availWidth / 2) - breite / 2);
 var positionY=((screen.availHeight / 2) - hoehe / 2);
 var url='register.php';
 pop=window.open('','User Register','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0,fullscreen=0,width='+breite+',height='+hoehe+',top=10000,left=10000');
 pop.blur();
 pop.resizeTo(breite,hoehe);
 pop.moveTo(positionX,positionY);
 pop.location=url;
 }
onerror = stopError;
function stopError()
{return true;}

</script>
</head>
<body>
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
        <script type="text/javascript" color="200, 0, 0" opacity="1.6" zindex="-2" count="150" src="http://www.cssscript.com/demo/interactive-particle-nest-system-with-javascript-and-canvas-canvas-nest-js/canvas-nest.js"></script><canvas id="c_n2" width="725" height="913" style="position: fixed; top: 0px; left: 0px; z-index: -2; opacity: 0.7;"></canvas>
        <center>
      <h1>Webinterface von AktenSystem</h1>
      <br>

      <h2>Accounts</h2>
      <br><br><br><br><br>
            <div class="inter" style="width: 70%;position: absolute;top: 50%;left: 50%;transform: translate(-50%, 0%);">
                <table id="Table" class="table table-striped table-dark" style="width: 100%;" data-toggle="table" data-pagination="true"
                       data-search="true">
                    <thead>
                    <tr>
                        <th scope="col" data-sortable="true" data-field="name">Name</th>
                        <th scope="col" data-sortable="true" data-field="rang">Rang</th>
                        <th scope="col" data-sortable="true" data-field="frac">Fraction</th>
                        <th scope="col" data-field="open">Infos</th>
                    </tr>
                    </thead>
                    <tbody>


        <?php
        $acc = "";
        if($_SESSION['access']!==0){
            $acc = " WHERE `Access` = '".$_SESSION['access']."'";
        }
        $result=mysql_connetion::result("SELECT * FROM login".$acc);
      	while($row = mysqli_fetch_array($result)){

              $Userresold = $row["User"];
              $Rangresold = $row["Rang"];
              $accresold = $row["Access"];
              $fraction="Keine Fraction";
              switch($accresold){
                  case "0":
                      $fraction="Verwaltung";
                      break;
                  case "1":
                      $fraction="LSPD";
                      break;
                  case "2":
                      $fraction="LSMD";
                      break;
              }
              $rang="Normal";
              if($Rangresold==="1"){
                  $rang = "Leitung";
              }
        echo '
                    <tr>
                        <th scope="row">'.$Userresold.'</th>
                        <td>'.$rang.'</td>
                        <td>'.$fraction.'</td>
                        <td><a class="btn btn-primary" href="usercheck.php?name='.$Userresold.'">INFO</a></td>
                    </tr>
          ';
      }
        ?>

                    </tbody>
                </table>

            </div>
      </div>
        <footer class="bg-dark text-center text-white " style="position: fixed;bottom:0; width:100%; height:50px; padding: 7px;">
            <a href="" onclick="Register()" class="btn btn-primary">User Hinzufügen</a>
        </footer>

    </center>
  </div>

</body>
</html>
