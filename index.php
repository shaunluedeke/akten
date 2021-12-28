<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION)) {
    session_start();
}
require_once(__DIR__ . "/assets/lib/template/template.php");
require(__DIR__ . "/assets/php/aktensys.php");
require_once(__DIR__ . "/assets/php/main.php");
require (__DIR__ . "/assets/php/bußgeld.php");
$main = new main();
$mysql = $main->getSQL();
$template = new template();
$template->setTempFolder(__DIR__ . "/assets/template/");

$loginstatus = $_SESSION['login'] ?? 0;

if ((int)$loginstatus === 0) {
    if (isset($_POST["logi"])) {
        if ($main->login($_POST["usernam"], $_POST["Passord"], ($_POST["remember"] ?? "") === "true")) {
            echo('<script>alert("Du bist Jetzt eingelogt!"); window.location="index.php";</script>');
        } else {
            echo('<script>alert("Du hast das falsche Passwort eingegeben!"); </script>');
        }

    }
    $template->parse("index.tpl");
}

if ((int)$loginstatus === 1) {
    $site = $_GET['site'] ?? "";
    switch ($site) {

        #region akten

        case "akten-all":
        {
            $aktensys = new aktensys(0);
            $result = $aktensys->get((int)$_SESSION['access']);
            foreach ($result as $key => $value) {
                $fraction = match ($value['access']) {
                    0 => "Verwaltung",
                    1 => "LSPD",
                    2 => "LSMC",
                    default => "Keine Fraction",
                };
                $akten_loop = array();
                $akten_loop["id"] = $value['id'];
                $akten_loop["name"] = $main->sonderzeichenhinzufügen($value['name']);
                $akten_loop["date"] = $value["data"]['date'];
                $akten_loop["frac"] = $fraction;
                $akten_loop["creator"] = $main->sonderzeichenhinzufügen($value["data"]['creator']);
                $template->assign("akten_loop", $akten_loop);
            }
            $template->assign("hasakten", count($result) > 0);
            $template->parse("akten/akten-all.tpl");
            break;
        }

        case "akte":
        {
            $id = $_GET['id'] ?? 0;
            if ($id === 0) {
                echo('<script>alert("Die Akte konnte nicht gefunden werden!"); window.location="index.php?site=akten-all";</script>');
            }
            $acc = "";
            if ($_SESSION['access'] !== 0) {
                $acc = " AND Access = '" . $_SESSION['access'] . "'";
            }
            $akten = new aktensys($id);
            $row = $akten->get();
            $isset = count($row) > 0;
            if ($isset) {
                $template->assign("id", $row["id"]);
                $template->assign("name", $main->sonderzeichenhinzufügen($row["name"]));
                $template->assign("date", $row["data"]["date"]);
                $template->assign("gb", $row["data"]["gb"]);
                $template->assign("tel", $row["data"]["tel"]);
                $template->assign("straftat", $main->sonderzeichenhinzufügen($row["data"]["straftat"]));
                $template->assign("vernehmung", $main->sonderzeichenhinzufügen($row["data"]["vernehmung"]));
                $template->assign("aufklarung", $main->sonderzeichenhinzufügen($row["data"]["aufklarung"]));
                $template->assign("urteil", $main->sonderzeichenhinzufügen($row["data"]["urteil"]));
                $template->assign("creator", $row["data"]["creator"]);
                $template->assign("pd", (int)$row["access"] === 1);
                $template->assign("released",(int)$_SESSION["access"]===(int)$row["access"] || (int)$_SESSION["access"]===0);
                $template->assign("release", match ($row["release"]) {1 => "Freigegeben für das LSPD",2 => "Freigegeben für das LSMC",default => "",});
            } else {
                echo('<script>alert("Die Akte konnte nicht gefunden werden!"); </script>');
                header("Location: index.php?site=akten-all");
            }
            $template->assign("rang", $_SESSION['rang'] > 0);
            $template->parse("akten/akte.tpl");
            break;
        }

        case "akten-create":
        {
            if (isset($_POST["createakte"])) {
                $access = $_GET['frac'] === "pd" ? "1" : "2";
                $date = date("d.m.Y", strtotime($_POST["date"]));
                $akten = new aktensys();
                $id = $akten->set($main->sonderzeichenentfernen($_POST["name"]), $date, $access,
                    $main->sonderzeichenentfernen($_SESSION['name']), $main->sonderzeichenentfernen($_POST['gb']), $main->sonderzeichenentfernen($_POST["tel"]),
                    $main->sonderzeichenentfernen($_POST["straftat"]), $main->sonderzeichenentfernen($_POST["vernehmung"]),
                    $main->sonderzeichenentfernen($_POST["aufklaerung"]), $main->sonderzeichenentfernen($_POST["urteil"]));
                header("location: index.php?site=akte&id=$id");
            } else {
                $template->assign("pd", $_SESSION['access'] === 1);
                $template->assign("verwaltung", $_SESSION['access'] === 0);
                $template->assign("date", date("Y-m-d"));
                $template->parse("akten/akten-create.tpl");
            }
            break;
        }

        case "akten-delete":
        {
            if ($_SESSION['rang'] < 1) {
                echo('<script>alert("Du hast kein zugrif eine Akte zu Löschen!"); window.location="index.php?site=akten-all";</script>');
            }
            $id = $_GET['id'] ?? 0;
            if ($id === 0) {
                echo('<script>alert("Die Akte konnte nicht gefunden werden!"); window.location="index.php?site=akten-all";</script>');
            }
            $state = $_GET['state'] ?? "";
            if ($state === "") {
                $template->assign("id", $id);
                $template->parse("akten/akte-delete.tpl");
            }
            if ($state === "confirm") {
                $akte = new aktensys($id);
                $akte->delete();
                echo('<script>alert("Die Akte wurde gelöscht!"); window.location="index.php?site=akten-all";</script>');
            }
            break;
        }

        case "akten-edit":
        {
            $id = $_GET['id'] ?? 0;
            if ($id === 0) {
                echo('<script>alert("Die Akte konnte nicht gefunden werden!"); window.location="index.php?site=akten-all";</script>');
            }
            if (isset($_POST["editakte"])) {
                $date = date("d.m.Y", strtotime($_POST["date"]));
                $akten = new aktensys($id);
                $akten->update($main->sonderzeichenentfernen($_POST["name"]), $date,
                    $main->sonderzeichenentfernen($_SESSION['name']), $main->sonderzeichenentfernen($_POST['gb']), $main->sonderzeichenentfernen($_POST["tel"]),
                    $main->sonderzeichenentfernen($_POST["straftat"]), $main->sonderzeichenentfernen($_POST["vernehmung"]),
                    $main->sonderzeichenentfernen($_POST["aufklaerung"]), $main->sonderzeichenentfernen($_POST["urteil"]));
                if($akten->updaterelese($_POST["release"])){ echo('<script>alert("Die Akte wurde erfolgreich bearbeitet!"); window.location="index.php?site=akte&id='.$id.'";</script>');}
            } else {
                $akte = new aktensys($id);
                $row = $akte->get();
                $isset = count($row) > 0;
                if ($isset) {
                    $template->assign("id", $row["id"]);
                    $template->assign("name", $row["name"]);
                    $template->assign("date", date("Y-m-d", strtotime($row["data"]["date"])));
                    $template->assign("gb", $row["data"]["gb"]);
                    $template->assign("tel", $row["data"]["tel"]);
                    $template->assign("straftat", $main->sonderzeichenhinzufügen($row["data"]["straftat"]));
                    $template->assign("vernehmung", $main->sonderzeichenhinzufügen($row["data"]["vernehmung"]));
                    $template->assign("aufklarung", $main->sonderzeichenhinzufügen($row["data"]["aufklarung"]));
                    $template->assign("urteil", $main->sonderzeichenhinzufügen($row["data"]["urteil"]));
                    $template->assign("creator", $row["data"]["creator"]);
                    $template->assign("pd", (int)$row["access"] === 1);
                    $template->assign("releaseselect0",$row["release"]===0?"selected":"");
                    $template->assign("releaseselect1",$row["release"]===1?"selected":"");
                    $template->assign("releaseselect2",$row["release"]===2?"selected":"");
                } else {
                    echo('<script>alert("Die Akte konnte nicht gefunden werden!"); window.location="index.php?site=akten-all";</script>');
                }
                $template->parse("akten/akten-edit.tpl");
            }
            break;
        }

        #endregion

        #region teammanager

        case "team":
        {
            if ((int)$_SESSION["rang"] !== 1) {
                header("Location: index.php");
            }

            $result = $mysql->result("SELECT * FROM `login`" . ($_SESSION['access'] !== 0 ? " WHERE `Access` = '" . $_SESSION['access'] . "'" : ""));
            while ($row = mysqli_fetch_array($result)) {
                $user_loop = array();
                $user_loop["name"] = base64_decode($row["Username"]);
                $Rangresold = $row["Rang"];
                $accresold = $row["Access"];
                $user_loop["fraction"] = match ($accresold) {
                    "0" => "Verwaltung",
                    "1" => "LSPD",
                    "2" => "LSMC",
                    default => "Keine Fraction",
                };
                $user_loop["rang"] = $Rangresold === "1" ? "Leitung" : "Normal";
                $template->assign("user_loop", $user_loop);
            }
            $template->parse("team/index.tpl");
            break;
        }

        case "user-check":
        {
            if ((int)$_SESSION["rang"] !== 1) {
                header("Location: index.php");
            }
            $name = $_GET["name"] ?? "";
            if ($name === "") {
                header("Location: index.php?site=team");
            }
            $template->assign("name", $name);
            $template->assign("name1", $name);
            $template->assign("name2", $name);
            $template->assign("name3", $name);
            $template->parse("team/user-check.tpl");

            break;
        }

        case "user-edit":
        {
            if ((int)$_SESSION["rang"] !== 1) {
                header("Location: index.php");
            }
            $name = $_GET["name"] ?? "";
            if ($name === "" || $name === "root") {
                header("Location: index.php?site=team");
            }
            if (isset($_POST["edit"])) {
                if ($mysql->query("UPDATE `login` SET `Rang`='" . $_POST["rang"] . "',`Access`='" . $_POST["frac"] . "' WHERE `Username`='" . base64_encode($name) . "'")) {
                    echo('<script>alert("Du hast dein User geändert!"); window.location="index.php?site=team";</script>');
                } else {
                    echo('<script>alert("Es gab ein Datenbank fehler!"); </script>');
                }
            }
            $result = $mysql->result("SELECT `Rang`,`Access` FROM `login` WHERE `Username`='" . base64_encode($name) . "'");
            $isset = false;
            while ($row = mysqli_fetch_array($result)) {
                $template->assign("name", $name);
                $template->assign("name1", $name);
                $template->assign("rang", $row["Rang"]);
                $template->assign("access", $row["Access"]);
                $template->assign("access1", $row["Access"]);
                $isset = true;
            }
            if (!$isset) {
                echo('<script>alert("Den User gibt es nicht!"); window.location="index.php?site=team";</script>');
            }

            $template->assign("verwaltung", $_SESSION["access"] === 0);
            $template->parse("team/user-edit.tpl");
            break;
        }

        case "user-delete":
        {
            if ((int)$_SESSION["rang"] !== 1) {
                header("Location: index.php");
            }
            $name = $_GET["name"] ?? "";
            if ($name === "" || $name === "root") {
                header("Location: index.php?site=team");
            }
            if ($mysql->query("DELETE FROM `login` WHERE `Username`='" . base64_encode($name) . "'")) {
                echo('<script>alert("Der User wurde gelöscht!"); window.location="index.php?site=team";</script>');
                header("Location: index.php");
            } else {
                echo('<script>alert("Es gab ein Fehler!"); window.location="index.php?site=team";</script>');
            }
            break;
        }

        case "register":
        {
            if (isset($_POST["register"])) {
                $p = $main->register($_POST["usernam"], "", $_POST["ran"], ($_POST["access"] ?? $_SESSION["access"]));
                $pw = match ($p) {
                    "#ERROR 1#" => "Den User gibt es schon!",
                    "#ERROR 2#" => "Es gab ein Datenbank fehler!",
                    default => "Das Password ist: " . $p . "",
                };
                echo('<script>alert("' . $pw . '"); window.location="index.php?site=team";</script>');
            }
            $template->assign("access", $_SESSION["access"] === 0);
            $template->parse("team/register.tpl");
            break;
        }

        #endregion

        #region bußgeld
        //bußgeld system

        case "fine":{
            $fine = new bußgeld((int)$_SESSION["access"]);
            $getfine = $fine->get();
            foreach ($getfine as $key => $value) {
                $fraction = match ($value['access']) {
                    0 => "Verwaltung",
                    1 => "LSPD",
                    2 => "LSMC",
                    default => "Keine Fraction",
                };
                $fine_loop = array();
                $fine_loop["para"] = $main->sonderzeichenhinzufügen($value["paragraf"]);
                $fine_loop["name"] = $main->sonderzeichenhinzufügen($value["name"]);
                $fine_loop["fine"] = $main->sonderzeichenhinzufügen($value['geld']);
                $fine_loop["frac"] = $fraction;
                $fine_loop["leader1"] = (int)$_SESSION["rang"] === 1 ? '<td><a class="btn btn-primary" href="index.php?site=fine-edit&id='.$value['id'].'">Ändern</a></td>' : "";
                $template->assign("fine_loop", $fine_loop);
            }
            $template->assign("leader", (int)$_SESSION["rang"] === 1);
            $template->assign("leader2", (int)$_SESSION["rang"] === 1);
            $template->assign("leader3", (int)$_SESSION["rang"] === 1);
            $template->assign("hasfine", count($getfine) > 0);
            $template->parse("bußgeld/fine.tpl");
            break;
        }

        case "fine-add":{
            if ((int)$_SESSION["rang"] !== 1) {
                header("Location: index.php");
            }
            if (isset($_POST["createfine"])) {
                (int)$access = $_POST["frac"] ?? (int)$_SESSION["access"];
                $fine = new bußgeld((int)$access);
                $fine->add($_POST["paragraf"], $_POST["name"], $_POST["geld"]);
                echo('<script>alert("Der Bußgeld wurde hinzugefügt!"); window.location="index.php?site=fine";</script>');
            }
            $template->assign("verwaltung", (int)$_SESSION["access"] === 0);
            $template->parse("bußgeld/fine-add.tpl");
            break;
        }

        case "fine-edit":{
            $id = $_POST["id"]?? $_GET["id"] ?? 0;
            if ((int)$_SESSION["rang"] !== 1 || $id === 0) {
                header("Location: index.php");
            }
            if (isset($_POST["editfine"])) {
                $fine = new bußgeld(0,(int)$id);
                $access = (int)$_SESSION["access"]===0 ? (int)$fine->get()["access"] : (int)$_SESSION["access"];
                $fine->set_access($access);
                $fine->edit($_POST["paragraf"], $_POST["name"], $_POST["geld"]);
                echo('<script>alert("Der Bußgeld wurde bearbeitet!"); window.location="index.php?site=fine";</script>');
            }
            $fine = new bußgeld(0,(int)$id);
            $getfine = $fine->get();
            if(count($getfine) === 0){
                echo('<script>alert("Das Bußgeld wurde nicht gefunden!"); window.location="index.php?site=fine";</script>');
            }
            $template->assign("id", $id);
            $template->assign("paragraf", $main->sonderzeichenhinzufügen($getfine["paragraf"]));
            $template->assign("name", $main->sonderzeichenhinzufügen($getfine["name"]));
            $template->assign("geld", $main->sonderzeichenhinzufügen($getfine["geld"]));
            $template->parse("bußgeld/fine-edit.tpl");
            break;
        }

        #endregion bußgeld

        case "pw-edit":
        {
            if (isset($_POST["pwedit"])) {
                if ($main->login($_SESSION["name"], $_POST["pwalt"])) {
                    $pw = hash("sha256", md5($_POST["pwneu"]));
                    if ($mysql->query("UPDATE `login` SET `PW`='$pw' WHERE `Username`='" . base64_encode($_SESSION["name"]) . "'")) {
                        echo('<script>alert("Du hast dein Password geändert!"); window.location="index.php";</script>');
                    } else {
                        echo('<script>alert("Es gab ein Datenbank fehler!"); </script>');
                    }
                } else {
                    echo('<script>alert("Du hast das falsche Passwort eingegeben!"); </script>');
                }
            }
            $template->parse("pw-edit.tpl");
            break;
        }

        case "logout":
        {
            unset($_SESSION);
            session_destroy();
            header("Location: index.php");
            break;
        }

        default:
        {
            $akten = $mysql->count("SELECT `ID` FROM `akten`" . ((int)$_SESSION['access'] !== 0 ? " WHERE `Access` = '" . $_SESSION['access'] . "' OR `Freigabe` = '". $_SESSION['access'] ."'" : ""));
            $rang = $_SESSION['rang'] ?? 0;
            $template->assign("teamsite", $rang > 0);
            $template->assign("aktenansehbar", $akten !== 0);
            $template->assign("pd", (int)$_SESSION["access"] !== 2);
            $template->assign("allakten", $akten);
            $template->parse("login.tpl");
            break;
        }

    }
}
?>