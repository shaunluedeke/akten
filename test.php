<?php
session_start();
$_SESSION['login']=1;
$loginstatus=1;
$_SESSION['rang']=1;
$_SESSION['access']=1;
$_SESSION['username']="root";

header("Location:index.php");