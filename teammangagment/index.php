<?php
if(!isset($_SESSION)){session_start();}
require(__DIR__.'/../assets/php/api/mysql/mysql_connetion.php');
require(__DIR__."/../assets/php/api/template/template.php");
require(__DIR__."/../assets/php/rest.php");
$template = new template();
$template->setTempFolder(__DIR__ . "/../assets/template/team/");
$site = $_GET['site'] ?? "";
if (empty($_SESSION['login']) || $_SESSION['login'] === 0) {header("Location : ../index.php");return;}

switch($site){
    case "deleteuser":{
        if(empty($_GET['name'])){
            header("index.php");
            return;
        }
        $name = $_GET['name'] ?? "";
        if($name === "" || $name === "root"){
            echo('<script> alert("Den User kann man nicht Löschen!");  </script>');
        }else{
            mysql_connetion::query("DELETE FROM `login` WHERE `User` = '".$name."'");
            echo('<script text="text/javascript">alert("Du hast den User gelöscht!");</script>');
        }
        header("Location: index.php");
        break;
    }
    case "edituser":{
        $name = $_GET['name'] ?? "";
        if($name===""||$name==="root"){
            header("Location: index.php");
        }
        if(isset($_POST['edit'])){
            mysql_connetion::query("UPDATE login SET Rang='".$_POST["rang"]."',Access='".$_POST["frac"]."' WHERE User='".$_POST["name"]."'");
        }
        $template->assign("name", $name);
        $result=mysql_connetion::result("SELECT * FROM login WHERE User = '".$name."'");
        $rang="";
        $access="";
        while($row = mysqli_fetch_array($result)){
            $rang = $row["Rang"];
            $access = $row["Access"];
        }
        $template->assign("rang", $rang);
        $template->assign("access", $access);
        $template->parse("edituser.tpl");
        break;
    }
    case "usercheck":{
        $name = $_GET['name'] ?? "";
        if($name===""){header("Location: index.php");return;}
        $template->assign("name", $name);
        $template->assign("name1", $name);
        $template->assign("name2", $name);
        $template->assign("name3", $name);
        $template->parse("usercheck.tpl");
        break;
    }
    default:{
        $acc = "";
        if($_SESSION['access']!==0){
            $acc = " WHERE `Access` = '".$_SESSION['access']."'";
        }
        $result=mysql_connetion::result("SELECT * FROM login".$acc);
        while($row = mysqli_fetch_array($result)) {
            $account_loop = array();
            $account_loop["user"] = $row["User"];
            $fraction = "Keine Fraction";
            switch ($row["Access"]) {
                case "1":
                    $fraction = "LSPD";
                    break;
                case "2":
                    $fraction = "LSMD";
                    break;
                default:
                    $fraction = "Verwaltung";
                    break;
            }
            $rang = "Normal";
            if ($row["Rang"] === "1") {
                $rang = "Leitung";
            }
            $account_loop["rang"] = $rang;
            $account_loop["fraction"] = $fraction;
            $template->assign("account_loop", $account_loop);
        }
        $template->parse("index.tpl");
        break;
    }
}
