<?php
require("assets/php/api/mysql/mysql_connetion.php");
$na = 0;
mysql_connetion::connect();
$db_res = mysql_connetion::result("SELECT PW FROM Login") or ($na = 1);

if ($na === 1) {

    mysql_connetion::query("CREATE TABLE IF NOT EXISTS login (User VARCHAR(100), PW VARCHAR(100), Rang VARCHAR(100), Access INT(10))") or die("<center><h1>Es ging nicht</h1>");
    mysql_connetion::query("CREATE TABLE IF NOT EXISTS akten (
  `ID` int(16) NOT NULL,
  `Name` varchar(255) COLLATE utf8_bin NOT NULL,
  `Geburtstag` varchar(255) COLLATE utf8_bin NOT NULL,
  `Durchwahl` varchar(200) COLLATE utf8_bin NOT NULL,
  `Datum` varchar(200) COLLATE utf8_bin NOT NULL DEFAULT current_timestamp(),
  `Straftat` varchar(255) COLLATE utf8_bin NOT NULL,
  `Vernehmung` text COLLATE utf8_bin NOT NULL,
  `aufklaerung` text COLLATE utf8_bin NOT NULL,
  `urteil` varchar(255) COLLATE utf8_bin NOT NULL,
  `Ersteller` varchar(200) COLLATE utf8_bin NOT NULL DEFAULT 'System',
  `Access` INT(10) COLLATE utf8_bin NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;") or die("<center><h1>Es ging nicht</h1>");
    $pwmd = md5('M3gcz951t41991!!!');
    mysql_connetion::query("INSERT INTO Login(User, PW,Rang,Access) VALUES ('root','".$pwmd."','1','0')");
}

header('Location: index.php');
?>