<?php
session_start();
require("assets/php/api/mysql/mysql_connetion.php");
require("assets/php/api/template/template.php");
require("assets/php/rest.php");
$template = new template();
$template->setTempFolder(__DIR__ . "/assets/template/");
$loginstatus= $_SESSION['login'] ?? 0;

if($loginstatus===0) {
    if(isset($_POST['logi'])) {
        if (empty($_POST['usernam']) || empty($_POST['Passord'])) {
            ?> <script "text/javascript">alert("Du hast nicht alles eingegeben!");</script> <?php
        }else{
            $usern = $_POST['usernam'];
            $db_res = mysql_connetion::result("SELECT * FROM `login` WHERE `User` = '".$usern."'");
            $row = mysqli_fetch_array($db_res);
            $pwresold = $row["PW"];

            if(md5($_POST['Passord']) === $pwresold){
                $_SESSION['login']=1;
                $loginstatus=1;
                $_SESSION['rang']=$row["Rang"];
                $_SESSION['access']= (int)$row["Access"];
                $_SESSION['username']=$usern;
                ?> <script "text/javascript">alert("Du bist Jetzt eingelogt!"); </script><?php

            }else{
                ?> <script "text/javascript">alert("Du hast das falsche Passwort eingegeben!"); </script> <?php
            }
        }
    }
    if($loginstatus===0) {
        $template->parse("index.tpl");
    }
}
if($loginstatus===1){
    $site= $_GET['site'] ?? "normal";
    if($site==="normal") {
        $acc = "";
        if((int)$_SESSION['access']!==0){
            $acc = " WHERE Access = '".$_SESSION['access']."'";
        }
        $akten = mysqli_fetch_assoc(mysql_connetion::result("SELECT COUNT(*) AS count FROM akten".$acc))['count'] ?? 0;
        $rang = $_SESSION['rang']??0;
        $template->assign("teamsite",$rang>0);
        $template->assign("aktenansehbar", $akten!==0);
        $template->assign("allakten", $akten);
        $template->parse("login.tpl");
    }
    if($site==="akten-all") {
        $acc = "";
        if($_SESSION['access']!==0){
            $acc = " WHERE Access = '".$_SESSION['access']."'";
        }
        $result=mysql_connetion::result("SELECT * FROM akten".$acc);
        $i=0;
        while($row = mysqli_fetch_array($result)) {
            $fraction="Keine Fraction";
            switch($row['Access']){
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
            $akten_loop = array();
            $akten_loop["id"] = $row['ID'];
            $akten_loop["name"] = $row['Name'];
            $akten_loop["date"] = $row['Datum'];
            $akten_loop["frac"] = $fraction;
            $akten_loop["creator"] = $row['Ersteller'];
            $template->assign("akten_loop",$akten_loop);
            $i++;
        }
        $template->assign("hasakten",$i>0);
        $template->parse("akten-all.tpl");
    }
    if($site==="akte") {
        $name = $_GET['id'] ?? 0;
        if($name === 0){
            ?> <script "text/javascript">alert("Die Akte konnte nicht gefunden werden!"); </script> <?php
            header("Location: index.php?site=akten-all");
        }
        $acc = "";
        if($_SESSION['access']!==0){
            $acc = " AND Access = '".$_SESSION['access']."'";
        }
        $result=mysql_connetion::result("SELECT * FROM akten WHERE ID = '".$name."'".$acc);
        $isset=false;
        while($row =mysqli_fetch_array($result)){
            $template->assign("id",$row["ID"]);
            $template->assign("name",$row["Name"]);
            $template->assign("date",$row["Datum"]);
            $template->assign("gb",$row["Geburtstag"]);
            $template->assign("tel",$row["Durchwahl"]);
            $template->assign("straftat",$row["Straftat"]);
            $template->assign("vernehmung",$row["Vernehmung"]);
            $template->assign("aufklarung",$row["aufklaerung"]);
            $template->assign("urteil",$row["urteil"]);
            $template->assign("creator",$row["Ersteller"]);
            $template->assign("pd",$row["Access"]===1);
            $isset=true;
        }
        if(!$isset){
            ?> <script "text/javascript">alert("Die Akte konnte nicht gefunden werden!"); </script> <?php
            header("Location: index.php?site=akten-all");
        }
        $template->assign("rang",$_SESSION['rang']>0);
        $template->parse("akte.tpl");

    }
    if($site==="akten-create"){
        if(isset($_POST["createakte"])){
            $access = $_GET['frac']==="pd" ? "1" : "0";
            $date = date("d.m.Y",strtotime($_POST["date"]));
            mysql_connetion::query("INSERT INTO `akten`(`ID`, `Name`, `Geburtstag`, `Durchwahl`, `Datum`, `Straftat`, 
                                        `Vernehmung`, `aufklaerung`, `urteil`, `Ersteller`, `Access`)
                                         VALUES ('null','".rest::sonderzeichenentfernen($_POST["name"])."','".rest::sonderzeichenentfernen($_POST["gb"])
                                        ."','".rest::sonderzeichenentfernen($_POST["tel"])."','".$date
                                        ."','".rest::sonderzeichenentfernen($_POST["straftat"])."','".rest::sonderzeichenentfernen($_POST["vernehmung"])
                                        ."','".rest::sonderzeichenentfernen($_POST["aufklaerung"])."','".rest::sonderzeichenentfernen($_POST["urteil"])
                                        ."','".rest::sonderzeichenentfernen($_SESSION['username'])."','".$access."')");
            header("location: index.php?site=akten-all");
        }else {
            $template->assign("pd",$_SESSION['access']===1);
            $template->assign("verwaltung",$_SESSION['access']===0);
            $template->assign("date", date("Y-m-d"));
            $template->parse("akten-create.tpl");
        }
    }
    if($site==="akten-delete"){
        if($_SESSION['rang']<1){
            ?> <script "text/javascript">alert("Du hast kein zugrif eine Akte zu Löschen!"); </script> <?php
            header("Location: index.php?site=akten-all");
        }
        $id = $_GET['id'] ?? 0;
        if($id === 0){
            ?> <script "text/javascript">alert("Die Akte konnte nicht gefunden werden!"); </script> <?php
            header("Location: index.php?site=akten-all");
        }
        $state = $_GET['state'] ?? "";
        if($state===""){
            $template->assign("id",$id);
            $template->parse("akte-delete.tpl");
        }
        if($state==="confirm"){
            mysql_connetion::query("DELETE FROM akten WHERE ID = '".$id."'");
            ?> <script "text/javascript">alert("Die Akte wurde gelöscht!"); </script> <?php
            header("Location: index.php?site=akten-all");
        }
    }
    if($site==="akten-edit"){
        $id = $_GET['id'] ?? 0;
        if($id === 0){
            ?> <script "text/javascript">alert("Die Akte konnte nicht gefunden werden!"); </script> <?php
            header("Location: index.php?site=akten-all");
        }
        if(isset($_POST["editakte"])){
            $date = date("d.m.Y",strtotime($_POST["date"]));
            mysql_connetion::query("UPDATE `akten` SET `Name`='".rest::sonderzeichenentfernen($_POST["name"])."',`Geburtstag`='".rest::sonderzeichenentfernen($_POST["gb"])
                ."',`Durchwahl`='".rest::sonderzeichenentfernen($_POST["tel"])."',`Datum`='".$date
                ."',`Straftat`='".rest::sonderzeichenentfernen($_POST["straftat"])."',`Vernehmung`='".rest::sonderzeichenentfernen($_POST["vernehmung"])
                ."',`aufklaerung`='".rest::sonderzeichenentfernen($_POST["aufklaerung"])."',`urteil`='".rest::sonderzeichenentfernen($_POST["urteil"])
                ."',`Ersteller`='".rest::sonderzeichenentfernen($_SESSION['username'])."' WHERE `ID`='".$id."'");
            header("location: index.php?site=akten-all");
        }else{
            $result=mysql_connetion::result("SELECT * FROM akten WHERE ID = '".$id."'");
            $isset=false;
            while($row =mysqli_fetch_array($result)){
                $template->assign("id",$row["ID"]);
                $template->assign("name",$row["Name"]);
                $template->assign("date",$date = date("Y-m-d",strtotime($row["Datum"])));
                $template->assign("gb",$row["Geburtstag"]);
                $template->assign("tel",$row["Durchwahl"]);
                $template->assign("straftat",$row["Straftat"]);
                $template->assign("vernehmung",$row["Vernehmung"]);
                $template->assign("aufklarung",$row["aufklaerung"]);
                $template->assign("urteil",$row["urteil"]);
                $template->assign("creator",$row["Ersteller"]);
                $isset=true;
            }
            if(!$isset){
                ?> <script "text/javascript">alert("Die Akte konnte nicht gefunden werden!"); </script> <?php
                header("Location: index.php?site=akten-all");
            }
            $template->parse("akten-edit.tpl");
        }
    }
    if($site==="logout"){
        $_SESSION['login']=0;
        $loginstatus=0;
        $_SESSION['rang']=0;
        $_SESSION['username']="";
        header("Location: index.php");
    }
}
?>
