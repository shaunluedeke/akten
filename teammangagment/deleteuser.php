<?php
session_start();
require('../assets/php/api/mysql/mysql_connetion.php');

if($_SESSION['login']==0){
  header("Location : ../../index.php");
}else{

if(empty($_GET['name'])){
  header("../index.php");
}else{
$name = $_GET['name'];
if($name == "root"){
?>
<script >
alert("Den User kann man nicht Löschen!");
</script>
<?php
header("Location: index.php");
}else{
    mysql_connetion::query("DELETE FROM `login` WHERE `User` = '".$name."'");
?>
<script text="text/javascript">
alert("Du hast den User gelöscht!");
</script>
<?php
header("Location: index.php");
}
}
}
?>
