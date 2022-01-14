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
require(__DIR__ . "/assets/php/bußgeld.php");
$main = new main();
$mysql = $main->getSQL();
$main->init();
$template = new template();
$template->setTempFolder(__DIR__ . "/assets/template/");

$loginstatus = $_SESSION['login'] ?? 0;

if ((int)$loginstatus === 0) {
    if (isset($_POST["logi"])) {
        if ($main->login($_POST["usernam"], $_POST["Passord"])) {
            echo('<script>alert("Du bist Jetzt eingelogt!"); window.location="index.php";</script>');
        } else {
            echo('<script>alert("Du hast das falsche Passwort eingegeben!"); </script>');
        }

    }
    $template->parse("index.tpl");
}

if ((int)$loginstatus === 1) {
    $site = $_GET['site'] ?? "";
    require_once(__DIR__ . "/assets/php/fracsys.php");
    $fracsys = new fracsys((int)$_SESSION['access']);
    switch ($site) {

        #region akten

        case "akten-all":
        {
            $aktensys = new aktensys(0);
            $result = $aktensys->get((int)$_SESSION['access']);
            foreach ($result as $key => $value) {
                $fraction = $fracsys->name($value['access']);
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
            if (count($row) > 0) {
                $txt = $fracsys->text("akte", (int)$row['access']);
                $template->assign("aktenname", $txt["title"] ?? "Kein Titel");
                $template->assign("id", $row["id"]);
                $template->assign("name", $main->sonderzeichenhinzufügen($row["name"]));
                foreach ($row["data"] as $key => $value) {
                    if ($key !== "creator") {
                        $akten_loop = [];
                        $akten_loop["key"] = $main->sonderzeichenhinzufügen($txt[$key] ?? "");
                        $akten_loop["value"] = $main->sonderzeichenhinzufügen($value ?? "");
                        $template->assign("akten_loop", $akten_loop);
                    }
                }
                $template->assign("creator", $row["data"]["creator"]);
                $template->assign("released", (int)$_SESSION["access"] === (int)$row["access"] || (int)$_SESSION["access"] === 0);
                $template->assign("release", ((int)$row['release'] === 0 ? "" : "Freigegeben für das " . $fracsys->name($row['release'])));
            } else {
                echo('<script>alert("Die Akte konnte nicht gefunden werden!"); window.location="index.php?site=akten-all";</script>');
            }
            $template->assign("rang", $_SESSION['rang'] > 0);
            $template->parse("akten/akte.tpl");
            break;
        }

        case "akten-create":
        {
            if (isset($_POST["createakte"])) {
                $akten = new aktensys();
                $dataarray = [];
                foreach ($_POST as $key => $value) {
                    if ($key !== "createakte" && $key !== "name" && $key !== "date") {
                        $dataarray[$key] = $main->sonderzeichenentfernen($value);
                    }
                    if ($key === "date") {
                        $dataarray[$key] = date("d.m.Y", strtotime($value));
                    }
                }
                $dataarray["creator"] = $_SESSION["name"];
                $id = $akten->set($main->sonderzeichenentfernen($_POST["name"]), $_SESSION["access"], $dataarray);
                header("location: index.php?site=akte&id=$id");
            } else {
                $getperson = [];
                if (isset($_GET['person'])) {
                    require_once(__DIR__ . "/assets/php/person.php");
                    $person = new person($_GET['person'] ?? -1);
                    $getperson = $person->get();
                }
                $txt = $fracsys->text("akte-create", (int)$_SESSION['access']);
                $template->assign("title", $txt["title"]);
                $template->assign("text", $txt["text"]);
                $template->assign("name", $main->sonderzeichenhinzufügen($getperson["name"] ?? ""));
                $template->assign("gb", $main->sonderzeichenhinzufügen($getperson["birthday"] ?? ""));
                $template->assign("tel", $main->sonderzeichenhinzufügen($getperson["data"]["tel"] ?? "555"));
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
                $dataarray = array();
                foreach ($_POST as $key => $value) {
                    if ($key !== "release" && $key !== "name" && $key !== "editakte") {
                        $dataarray[$key] = $main->sonderzeichenentfernen($value);
                    }
                }
                $dataarray["creator"] = $_SESSION["name"];
                $akten->update($main->sonderzeichenentfernen($_POST["name"]), $dataarray);
                if ($akten->updaterelese($_POST["release"])) {
                    echo('<script>alert("Die Akte wurde erfolgreich bearbeitet!"); window.location="index.php?site=akte&id=' . $id . '";</script>');
                }
            } else {
                $akte = new aktensys($id);
                $row = $akte->get();
                $isset = count($row) > 0;
                if ($isset) {
                    $template->assign("id", $row["id"]);
                    $template->assign("name", $main->sonderzeichenhinzufügen($row["name"]));
                    $txt = $fracsys->text("akte", (int)$row['access']);
                    foreach ($row["data"] as $key => $value) {
                        if ($key !== "creator" && $key !== "name") {
                            $akten_loop = [];
                            $akten_loop["name"] = $main->sonderzeichenhinzufügen($txt[$key] ?? "");
                            $akten_loop["name1"] = $main->sonderzeichenhinzufügen($txt[$key] ?? "");
                            $akten_loop["key"] = ($key ?? "");
                            $akten_loop["value"] = $main->sonderzeichenhinzufügen($value);
                            $template->assign("akten_loop", $akten_loop);
                        }
                    }
                    $template->assign("releaseselect0", $row["release"] === 0 ? "selected" : "");
                    $template->assign("releaseselect1", $row["release"] === 1 ? "selected" : "");
                    $template->assign("releaseselect2", $row["release"] === 2 ? "selected" : "");
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
                $user_loop["fraction"] = $fracsys->name((int)$row["Access"]);
                $user_loop["rang"] = (int)$row["Rang"] === 1 ? "Leitung" : "Normal";
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

        case "fine":
        {
            $fine = new bußgeld((int)$_SESSION["access"]);
            $getfine = $fine->get();
            $txt = $fracsys->text("fine", $_SESSION["access"]);
            $template->assign("title", $txt["title"] ?? "Bußgeld");
            $template->assign("money", $txt["money"] ?? "Strafe");
            foreach ($getfine as $key => $value) {
                $fine_loop = array();
                $fine_loop["para"] = $main->sonderzeichenhinzufügen($value["paragraf"]);
                $fine_loop["name"] = $main->sonderzeichenhinzufügen($value["name"]);
                $fine_loop["fine"] = $main->sonderzeichenhinzufügen($value['geld']);
                $fine_loop["frac"] = $fracsys->name($value['access']);
                $fine_loop["leader1"] = (int)$_SESSION["rang"] === 1 ? '<td><a class="btn btn-primary" href="index.php?site=fine-edit&id=' . $value['id'] . '">Ändern</a></td>' : "";
                $template->assign("fine_loop", $fine_loop);
            }
            $template->assign("leader", (int)$_SESSION["rang"] === 1);
            $template->assign("leader2", (int)$_SESSION["rang"] === 1);
            $template->assign("leader3", (int)$_SESSION["rang"] === 1);
            $template->assign("hasfine", count($getfine) > 0);
            $template->parse("bußgeld/fine.tpl");
            break;
        }

        case "fine-add":
        {
            if ((int)$_SESSION["rang"] !== 1) {
                header("Location: index.php");
            }
            if (isset($_POST["createfine"])) {
                (int)$access = $_POST["frac"] ?? (int)$_SESSION["access"];
                $fine = new bußgeld((int)$access);
                $fine->add($_POST["paragraf"], $_POST["name"], $_POST["geld"]);
                echo('<script>alert("Der Bußgeld wurde hinzugefügt!"); window.location="index.php?site=fine";</script>');
            }
            $txt = $fracsys->text("fine-add", $_SESSION["access"]);
            $template->assign("title", $txt["title"] ?? "Neue Bußgeld erstellen");
            $template->assign("money", $txt["money"] ?? "Strafe");
            $template->assign("verwaltung", (int)$_SESSION["access"] === 0);
            $template->parse("bußgeld/fine-add.tpl");
            break;
        }

        case "fine-edit":
        {
            $id = $_POST["id"] ?? $_GET["id"] ?? 0;
            if ((int)$_SESSION["rang"] !== 1 || $id === 0) {
                header("Location: index.php");
            }
            if (isset($_POST["editfine"])) {
                $fine = new bußgeld(0, (int)$id);
                $access = (int)$_SESSION["access"] === 0 ? (int)$fine->get()["access"] : (int)$_SESSION["access"];
                $fine->set_access($access);
                $fine->edit($_POST["paragraf"], $_POST["name"], $_POST["geld"]);
                echo('<script>alert("Der Bußgeld wurde bearbeitet!"); window.location="index.php?site=fine";</script>');
            }
            $fine = new bußgeld(0, (int)$id);
            $getfine = $fine->get();
            if (count($getfine) === 0) {
                echo('<script>alert("Das Bußgeld wurde nicht gefunden!"); window.location="index.php?site=fine";</script>');
            }
            $txt = $fracsys->text("fine-edit", $_SESSION["access"]);
            $template->assign("title", $txt["title"] ?? "Bußgeld ändern");
            $template->assign("money", $txt["money"] ?? "Strafe");
            $template->assign("id", $id);
            $template->assign("paragraf", $main->sonderzeichenhinzufügen($getfine["paragraf"]));
            $template->assign("name", $main->sonderzeichenhinzufügen($getfine["name"]));
            $template->assign("geld", $main->sonderzeichenhinzufügen($getfine["geld"]));
            $template->parse("bußgeld/fine-edit.tpl");
            break;
        }

        #endregion bußgeld

        #region person

        case "person":
        {
            require_once(__DIR__ . "/assets/php/person.php");
            $id = $_GET["id"] ?? 0;
            $person = new person($id);
            $getperson = $person->get();
            if (count($getperson) === 0) {
                echo('<script>alert("Die Person wurde nicht gefunden!"); window.location="index.php";</script>');
            }
            if ($id === 0) {
                foreach ($getperson as $key => $value) {
                    $person_loop = [];
                    $person_loop["id"] = $value["id"] ?? "";
                    $person_loop["name"] = $value["name"] ?? "";
                    $person_loop["date"] = $value["birthday"] ?? "";
                    $person_loop["wanted"] = $value["wanted"] ? '<p style="color: #ff0000">JA!</p>' : "Nein";
                    $template->assign("person_loop", $person_loop);
                }
                $template->assign("hasperson", true);
            } else {
                $template->assign("id", $id);
                $template->assign("name", $getperson["name"] ?? "");
                $template->assign("wanted", $getperson["wanted"]);
                $template->assign("wanted1", $getperson["wanted"]);
                $template->assign("dead", !$getperson["isalive"]);
                $template->assign("pstate", (!$getperson["isalive"] ? "dead" : ($getperson["wanted"] ? "wanted" : "")));
                $template->assign("birthday", $getperson["birthday"] ?? "");
                $template->assign("tel", $getperson["data"]["tel"] ?? "");
                $template->assign("frac", $getperson["data"]["frac"] ?? "");
                $template->assign("adress", $getperson["data"]["adress"] ?? "");
                $template->assign("note", $main->sonderzeichenhinzufügen($getperson["data"]["note"] ?? ""));
                $file = "";
                foreach (($getperson["data"]["files"]) as $key => $value) {
                    $file .= '<a class="btn btn-primary" target="_blank" href="/files/' . $value . '">' . $value . '</a>     ';
                }
                $template->assign("files", $file);
                $akte = "";
                $pd = 0;
                $mc = 0;
                $acls = 0;
                require_once(__DIR__ . "/assets/php/aktensys.php");
                $aktensys = new aktensys();
                foreach (($getperson["data"]["akte"]) as $key) {
                    $aktensys->setId($key);
                    if ($aktensys->hasAccess((int)($_SESSION["access"] ?? 3))) {
                        if (str_starts_with($key, "911")) {
                            $pd++;
                            $akte .= '<a class="btn btn-info" href="index.php?site=akte&id=' . $key . '">PD Akte #' . $pd . '</a>     ';
                        }
                        if (str_starts_with($key, "912")) {
                            $mc++;
                            $akte .= '<a class="btn btn-danger" href="index.php?site=akte&id=' . $key . '">MC Akte #' . $mc . '</a>     ';
                        }
                        if (str_starts_with($key, "444")) {
                            $acls++;
                            $akte .= '<a class="btn btn-warning" href="index.php?site=akte&id=' . $key . '">ACLS Akte #' . $acls . '</a>     ';
                        }
                    }
                }
                $template->assign("akte", $akte);
                $template->assign("hasakte", $akte !== "");
                $template->assign("wantedfor", $getperson["data"]["wantedfor"]);
                $template->assign("license", ($getperson["data"]["license"] ?? ""));
                $template->assign("hasperson", false);
            }
            $template->parse("person/person.tpl");
            break;
        }

        case "person-add":
        {
            require_once(__DIR__ . "/assets/php/person.php");
            $person = new person();
            if (isset($_POST["addperson"])) {
                $fadd = [];
                if (isset($_FILES["files"])) {
                    $files = $main->reArrayFiles($_FILES['files']);
                    $uploaddir = __DIR__ . '/files/';
                    foreach ($files as $f) {
                        $uploadfile = $uploaddir . basename($f['name']);
                        if (move_uploaded_file($f['tmp_name'], $uploadfile)) {
                            $fadd[] = basename($f['name']);
                        }
                    }
                }
                $data = [
                    "wantedfor" => ($_POST["wantedfor"] ?? ""),
                    "tel" => ($_POST["tel"] ?? ""),
                    "adress" => ($_POST["adress"] ?? ""),
                    "akte" => ($_POST["akten"] ?? []),
                    "frac" => ($_POST["frac"] ?? ""),
                    "license" => ($_POST["license"] ?? ""),
                    "note" => ($main->sonderzeichenentfernen($_POST["note"] ?? "")),
                    "files" => ($fadd)
                ];

                $id = $person->add($_POST["name"], date("d.m.Y", strtotime($_POST["gb"] ?? date("Y-m-d"))), $data);
                require_once(__DIR__ . "/assets/lib/discord/discord_auth.php");
                $webhook = new discord_webhook();
                $webhook->setTitle("Personenregister Add");
                $webhook->setTxt($_POST["name"] . " wurde hinzugefügt von " . $_SESSION["name"] . "! [Link](https://rpakte.de/index.php?site=person&id=" . $id . ")");
                $webhook->setColor(("00ffff"));
                $webhook->send();
                $person->setID($id);
                $person->setAlive($_POST["alive"] ?? false);
                $person->setWanted($_POST["wanted"] ?? false);
                echo('<script>alert("Die Person wurde erstellt!"); window.location="index.php?site=person&id=' . $id . '";</script>');
            }
            $template->parse("person/person-add.tpl");
            break;
        }

        case "person-edit":
        {
            require_once(__DIR__ . "/assets/php/person.php");
            $id = $_GET["id"] ?? 0;
            $person = new person($id);
            $getperson = $person->get();
            if (count($getperson) === 0) {
                echo('<script>alert("Die Person wurde nicht gefunden!"); window.location="index.php";</script>');
            }
            if (isset($_POST["editperson"])) {
                $fadd = $getperson["data"]["files"];
                if (isset($_FILES["files"])) {
                    $files = $main->reArrayFiles($_FILES['files']);
                    $uploaddir = __DIR__ . '/files/';
                    foreach ($files as $f) {
                        $uploadfile = $uploaddir . basename($f['name']);
                        if (move_uploaded_file($f['tmp_name'], $uploadfile)) {
                            $fadd[] = basename($f['name']);
                        }
                    }
                }
                $data = [
                    "wantedfor" => $_POST["wantedfor"] ?? "",
                    "tel" => $_POST["tel"] ?? "",
                    "adress" => $_POST["adress"] ?? "",
                    "akte" => $_POST["akten"] ?? $getperson["data"]["akte"] ?? [],
                    "files" => $fadd,
                    "license" => ($_POST["license"] ?? ""),
                    "note" => ($main->sonderzeichenentfernen($_POST["note"] ?? $getperson["data"]["note"] ?? "")),
                    "frac" => $_POST["frac"] ?? $getperson["data"]["frac"] ?? ""
                ];
                require_once(__DIR__ . "/assets/lib/discord/discord_auth.php");
                $webhook = new discord_webhook();
                $webhook->setTitle("Personenregister Update");
                $webhook->setTxt($getperson["name"] . " wurde bearbeitet von " . $_SESSION["name"] . "! [Link](https://rpakte.de/index.php?site=person&id=" . $id . ")");
                $webhook->setColor(("00ffff"));
                $webhook->send();

                $person->update($_POST["name"], date("d.m.Y", strtotime($_POST["gb"] ?? date("Y-m-d"))), $data);
                $person->setAlive($_POST["alive"] ?? false);
                $person->setWanted($_POST["wanted"] ?? false);
                echo('<script>alert("Die Person wurde bearbeitet!"); window.location="index.php?site=person&id=' . $id . '";</script>');
            }
            $template->assign("id", $id);
            $template->assign("name", $getperson["name"]);
            $template->assign("gb", date("Y-m-d", strtotime($getperson["birthday"])));
            $template->assign("tel", $getperson["data"]["tel"]);
            $template->assign("adress", $getperson["data"]["adress"]);
            $template->assign("frac", $getperson["data"]["frac"] ?? "");
            $template->assign("wanted", $getperson["wanted"] ? "checked" : "");
            $template->assign("alive", $getperson["isalive"] ? "checked" : "");
            $template->assign("license", ($getperson["data"]["license"] ?? ""));
            $template->assign("note", ($main->sonderzeichenentfernen($getperson["data"]["note"] ?? "")));
            $template->assign("wantedtext", $getperson["wanted"] ? "block" : "none");
            $template->assign("wantedfor", $getperson["data"]["wantedfor"]);
            $template->parse("person/person-edit.tpl");
            break;
        }

        #endregion person

        #region vehicle

        case "vehicle":
        {
            require_once(__DIR__ . "/assets/php/vehicle.php");
            $id = $_GET["id"] ?? 0;
            $vehicle = new vehicle($id);
            $getvehicle = $vehicle->get();
            if (count($getvehicle) === 0) {
                echo('<script>alert("Die Person wurde nicht gefunden!"); window.location="index.php";</script>');
            }
            if ($id === 0) {
                foreach ($getvehicle as $key => $value) {
                    $vehicle_loop = [];
                    $vehicle_loop["id"] = $value["id"] ?? "";
                    $vehicle_loop["number"] = $value["number"] ?? "";
                    $vehicle_loop["type"] = $value["data"]["kfz_typ"] ?? "";
                    $vehicle_loop["wanted"] = $value["wanted"] ? '<p style="color: #ff0000">JA!</p>' : "Nein";
                    $template->assign("vehicle_loop", $vehicle_loop);
                }
                $template->assign("hasperson", true);
            } else {
                require_once(__DIR__ . "/assets/php/person.php");
                $person = new person();
                $pid = $person->getID($getvehicle["data"]["halter"]);
                $template->assign("id", $id);
                $template->assign("number", $getvehicle["number"] ?? "");
                $template->assign("wanted", $getvehicle["wanted"]);
                $template->assign("wanted1", $getvehicle["wanted"]);
                $template->assign("pstate", ($getvehicle["wanted"] ? "wanted" : ""));
                $template->assign("ownerindatabase", $pid !== 0);
                $template->assign("ownerid", $pid);
                $template->assign("owner", $main->sonderzeichenhinzufügen($getvehicle["data"]["halter"] ?? ""));
                $template->assign("tel", $main->sonderzeichenhinzufügen($getvehicle["data"]["halternumber"] ?? ""));
                $template->assign("type", $getvehicle["data"]["kfz_typ"] ?? "");
                $template->assign("color", $getvehicle["data"]["kfz_farbe"] ?? "");
                $template->assign("km", $getvehicle["data"]["kfz_km"]." km" ?? "");
                $template->assign("note", $main->sonderzeichenhinzufügen($getvehicle["data"]["note"] ?? ""));
                $akte = "";
                require_once(__DIR__ . "/assets/php/aktensys.php");
                $aktensys = new aktensys();
                $acl = 0;
                foreach (($getvehicle["data"]["akte"]) as $key) {
                    $aktensys->setId($key);
                    if ($aktensys->hasAccess((int)($_SESSION["access"] ?? 3))) {
                        $acl++;
                        $akte .= '<a class="btn btn-info" href="index.php?site=akte&id=' . $key . '">ACLS Akte #' . $acl . '</a>     ';
                    }
                }
                $template->assign("akte", $akte);
                $template->assign("hasakte", $akte !== "");
                $template->assign("wantedfor", $getvehicle["data"]["wantedfor"] ?? "");
                $template->assign("hasperson", false);
            }
            $template->parse("vehicle/vehicle.tpl");
            break;
        }

        case "vehicle-add":
        {
            require_once(__DIR__ . "/assets/php/vehicle.php");
            $vehicle = new vehicle();
            if (isset($_POST["addvehicle"])) {
                require_once(__DIR__ . "/assets/php/person.php");
                $person = new person();
                $pid = $person->getID($_POST["owner"]);
                $data =["kfz_typ" => $_POST["type"] ?? "",
                        "kfz_farbe" => $_POST["color"] ?? "",
                        "kfz_km" => $_POST["km"] ?? "",
                        "halterid" => $pid ?? 0,
                        "halter" => $_POST["owner"] ?? "",
                        "halternumber" => $_POST["tel"] ?? "",
                        "akte" => [],
                        "wantedfor" => $_POST["wantedfor"] ?? "",
                        "note" => $main->sonderzeichenentfernen($_POST["note"] ?? "")];

                $vehicle->add($_POST["number"], $data, $_POST["wanted"] ?? false);
                echo('<script>alert("Dieses Fahrzeug wurde hinzugefügt!"); window.location="index.php?site=vehicle";</script>');
            }
            $template->parse("vehicle/vehicle-add.tpl");
            break;
        }

        case "vehicle-edit":
        {
            require_once(__DIR__ . "/assets/php/vehicle.php");
            $id = $_GET["id"] ?? 0;
            $vehicle = new vehicle($id);
            $getvehicle= $vehicle->get();
            if (count($getvehicle) === 0) {
                echo('<script>alert("Dieses Fahrzeug wurde nicht gefunden!"); window.location="index.php";</script>');
            }
            if (isset($_POST["editvehicle"])) {
                require_once(__DIR__ . "/assets/php/person.php");$person = new person();
                $pid = $person->getID($_POST["owner"]);
                $data =["kfz_typ" => $_POST["type"] ?? "",
                    "kfz_farbe" => $_POST["color"] ?? "",
                    "kfz_km" => $_POST["km"] ?? "",
                    "halterid" => $pid ?? 0,
                    "halter" => $_POST["owner"] ?? "",
                    "halternumber" => $_POST["tel"] ?? "",
                    "akte" => [],
                    "wantedfor" => $_POST["wantedfor"] ?? "",
                    "note" => $main->sonderzeichenentfernen($_POST["note"] ?? "")];

                $vehicle->update($_POST["number"], $data);
                $vehicle->setWanted($_POST["wanted"] ?? false);
                echo('<script>alert("Dieses Fahrzeug wurde bearbeitet!"); window.location="index.php?site=vehicle&id=' . $id . '";</script>');
            }
            $template->assign("id", $id);
            $template->assign("number", $getvehicle["number"]);
            $template->assign("owner", $getvehicle["data"]["halter"] ?? "");
            $template->assign("tel", $getvehicle["data"]["halternumber"] ?? "555");
            $template->assign("type", $getvehicle["data"]["kfz_typ"] ?? "");
            $template->assign("wanted", $getvehicle["wanted"] ? "checked" : "");
            $template->assign("color", ($getvehicle["data"]["kfz_farbe"] ?? ""));
            $template->assign("km", ($getvehicle["data"]["kfz_km"] ?? ""));
            $template->assign("note", ($main->sonderzeichenentfernen($getvehicle["data"]["note"] ?? "")));
            $template->assign("wantedtext", $getvehicle["wanted"] ? "block" : "none");
            $template->assign("wantedfor", $getvehicle["data"]["wantedfor"]);
            $template->parse("vehicle/vehicle-edit.tpl");
            break;
        }

        #endregion vehicle

        #region index
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
            $akten = $mysql->count("SELECT `ID` FROM `akten`" . ((int)$_SESSION['access'] !== 0 ? " WHERE `Access` = '" . $_SESSION['access'] . "' OR `Freigabe` = '" . $_SESSION['access'] . "'" : ""));
            $rang = $_SESSION['rang'] ?? 0;
            $template->assign("teamsite", $rang > 0);
            $template->assign("aktenansehbar", $akten !== 0);
            $template->assign("pd", (int)$_SESSION["access"] !== 2);
            $template->assign("allakten", $akten);
            $template->parse("login.tpl");
            break;
        }

        #endregion index
    }


}
