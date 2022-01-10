<?php
$ip = ($_SERVER['REMOTE_ADDR']) ?? "";
if($ip===""){
    header('HTTP/1.0 502 Bad Gateway');
}
$method = $_SERVER['REQUEST_METHOD'] ?? "";
require_once(__DIR__ .'/../assets/php/api.php');
$api = new api($ip);

switch($method){

        case 'GET':
            $action= $_GET['action'] ?? "";
            switch($action){

                case 'akte':
                    if($api->hasPermissions(1)) {
                        header("Content-Type: application/json");
                        $id = $_GET['id'] ?? 0;
                        require_once(__DIR__ . "/../assets/php/aktensys.php");
                        $akte = new aktensys($id);
                        try {
                            if(count($akte->get())>0) {
                                echo json_encode($akte->get(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
                            }else{
                                echo json_encode(["error" => "Keine Akte mit dieser ID gefunden"], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
                            }
                        } catch (JsonException $e) {
                            header('HTTP/1.1 500 Internal Server Error');
                        }
                    }else{
                        header('HTTP/1.1 401 Unauthorized');
                    }
                    break;

                case 'fine':{
                    if($api->hasPermissions(1)) {
                        header("Content-Type: application/json");
                        $access = $_GET['access'] ?? 0;
                        $id = $_GET['id'] ?? 0;
                        require_once(__DIR__ . "/../assets/php/bußgeld.php");
                        $fine = new bußgeld($access,$id);
                        try {
                            if(count($fine->get())>0) {
                                echo json_encode($fine->get(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
                            }else{
                                echo json_encode(["error" => "Keine Strafe mit dieser ID gefunden"], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
                            }
                        } catch (JsonException $e) {
                            header('HTTP/1.1 500 Internal Server Error');
                        }
                    }else{
                        header('HTTP/1.1 401 Unauthorized');
                    }
                    break;
                }

                case 'person':{
                    if($api->hasPermissions(1)) {
                        header("Content-Type: application/json");
                        $id = $_GET['id'] ?? 0;
                        require_once(__DIR__ . "/../assets/php/person.php");
                        $person = new person($id);
                        try {
                            if(count($person->get())>0) {
                                echo json_encode($person->get(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
                            }else{
                                header('HTTP/1.1 503 Service Unavailable');
                            }
                        } catch (JsonException $e) {
                            header('HTTP/1.1 500 Internal Server Error');
                        }
                    }else{
                        header('HTTP/1.1 401 Unauthorized');
                    }
                    break;
                }
                default:
                    header('HTTP/1.0 400 Bad Request');
                    break;
            }
            break;

        case 'POST':
            $action= $_POST['action'] ?? "";
            switch($action){

                case "akte":{
                    if($api->hasPermissions(2)){
                        header("Content-Type: application/json");
                        require_once(__DIR__ . "/../assets/php/aktensys.php");
                        $aktensys = new aktensys();
                        try {
                            $id=0;
                            if(isset($_POST['name'],$_POST["access"],$_POST["straftat"],$_POST["vernehmung"],$_POST["aufklarung"],$_POST["urteil"])){
                                $date = $_POST['date'] ?? date("d.m.Y");$creator = $_POST['creator'] ?? "root";$gb = $_POST['gb'] ?? "";
                                $tel = $_POST['tel'] ?? "";;
                                $id = $aktensys->set($_POST['name'],$date,$_POST["access"],$creator,$gb,$tel,$_POST['straftat'],$_POST['vernehmung'],$_POST['aufklarung'],$_POST['urteil']);
                            }
                            if($id!==0){
                                $aktensys->setId($id);
                                echo json_encode($aktensys->get(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
                            }else{
                                header('HTTP/1.0 400 Bad Request');
                            }
                        } catch (JsonException $e) {
                            header('HTTP/1.1 500 Internal Server Error');
                        }
                    }else{
                        header('HTTP/1.1 401 Unauthorized');
                    }
                    break;
                }

                case "fine":{
                    if($api->hasPermissions(2)){
                        header("Content-Type: application/json");
                        if(isset($_POST["access"],$_POST["paragraf"],$_POST["name"],$_POST["strafe"])) {
                            require_once(__DIR__ . "/../assets/php/bußgeld.php");
                            $fine = new bußgeld((int)$_POST["access"]);
                            $id = $fine->add($_POST["paragraf"],$_POST["name"],$_POST["strafe"]);
                            $fine->set_id($id);
                            try {
                                echo json_encode($fine->get(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
                            } catch (JsonException $e) {
                                header('HTTP/1.1 500 Internal Server Error');
                            }
                        }else{
                            header('HTTP/1.0 400 Bad Request');
                        }
                    }
                    else{
                        header('HTTP/1.1 401 Unauthorized');
                    }
                }

                case "person":{
                    if($api->hasPermissions(2)){
                        header("Content-Type: application/json");
                        if(isset($_POST["name"],$_POST["birthday"],$_POST["data"])) {
                            require_once(__DIR__ . "/../assets/php/person.php");
                            $person = new person();
                            try {
                                $id = $person->add($_POST["name"], $_POST["birthday"], json_decode($_POST["data"], true, 512, JSON_THROW_ON_ERROR));
                                $person->set_id($id);
                                echo json_encode($person->get(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
                            } catch (JsonException $e) {
                                header('HTTP/1.1 500 Internal Server Error');
                            }
                        }else{
                            header('HTTP/1.0 400 Bad Request');
                        }
                    }else{
                        header('HTTP/1.1 401 Unauthorized');
                    }
                    break;
                }

                default:
                    header('HTTP/1.0 400 Bad Request');
                    break;
            }
            break;

        case 'PUT':{
            $action= $_POST['action'] ?? "";
            switch($action){

                case "akte":{
                    if($api->hasPermissions(2)){
                        header("Content-Type: application/json");
                        require_once(__DIR__ . "/../assets/php/aktensys.php");

                        try {
                            if(isset($_POST['name'],$_POST["id"],$_POST["straftat"],$_POST["vernehmung"],$_POST["aufklarung"],$_POST["urteil"])){
                                $aktensys = new aktensys((int)$_POST["id"]);
                                $date = $_POST['date'] ?? date("d.m.Y");$creator = $_POST['creator'] ?? "root";$gb = $_POST['gb'] ?? "";
                                $tel = $_POST['tel'] ?? "";
                                $aktensys->update($_POST['name'],$date,$creator,$gb,$tel,$_POST['straftat'],$_POST['vernehmung'],$_POST['aufklarung'],$_POST['urteil']);
                                echo json_encode($aktensys->get(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
                            }else if(isset($_POST["id"],$_POST["release"])) {
                                $aktensys = new aktensys((int)$_POST["id"]);
                                $aktensys->updaterelese((int)$_POST["release"]);
                                echo json_encode($aktensys->get(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
                            }else{
                                header('HTTP/1.0 400 Bad Request');
                            }
                        } catch (JsonException $e) {
                            header('HTTP/1.1 500 Internal Server Error');
                        }
                    }else{
                        header('HTTP/1.1 401 Unauthorized');
                    }
                    break;
                }

                case "fine":{
                    if($api->hasPermissions(2)){
                        header("Content-Type: application/json");
                        if(isset($_POST["id"],$_POST["access"],$_POST["paragraf"],$_POST["name"],$_POST["strafe"])) {
                            require_once(__DIR__ . "/../assets/php/bußgeld.php");
                            $fine = new bußgeld((int)$_POST["access"],(int)$_POST["id"]);
                            $fine->edit($_POST["paragraf"],$_POST["name"],$_POST["strafe"]);
                            try {
                                echo json_encode($fine->get(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
                            } catch (JsonException $e) {
                                header('HTTP/1.1 500 Internal Server Error');
                            }
                        }else{
                            header('HTTP/1.0 400 Bad Request');
                        }
                    }
                    else{
                        header('HTTP/1.1 401 Unauthorized');
                    }
                }

                case "person":{
                    if($api->hasPermissions(2)){
                        header("Content-Type: application/json");
                        if(isset($_POST["id"],$_POST["name"],$_POST["birthday"],$_POST["data"],$_POST["wanted"],$_POST["isalive"])) {
                            require_once(__DIR__ . "/../assets/php/person.php");
                            $person = new person((int)$_POST["id"]);
                            try {
                                $person->update($_POST["name"], $_POST["birthday"], json_decode($_POST["data"], true, 512, JSON_THROW_ON_ERROR));
                                $person->setWanted((bool)$_POST["wanted"]);
                                $person->setAlive((bool)$_POST["isalive"]);
                                echo json_encode($person->get(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
                            } catch (JsonException $e) {
                                header('HTTP/1.1 500 Internal Server Error');
                            }
                        }else if(isset($_POST["id"],$_POST["wanted"])){
                            require_once(__DIR__ . "/../assets/php/person.php");
                            $person = new person((int)$_POST["id"]);
                            $person->setWanted((bool)$_POST["wanted"]);
                            try {
                                echo json_encode($person->get(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
                            } catch (JsonException $e) {
                                header('HTTP/1.1 500 Internal Server Error');
                            }
                        }else if(isset($_POST["id"],$_POST["isalive"])){
                            require_once(__DIR__ . "/../assets/php/person.php");
                            $person = new person((int)$_POST["id"]);
                            $person->setAlive((bool)$_POST["isalive"]);
                            try {
                                echo json_encode($person->get(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
                            } catch (JsonException $e) {
                                header('HTTP/1.1 500 Internal Server Error');
                            }
                        }else{
                            header('HTTP/1.0 400 Bad Request');
                        }
                    }else{
                        header('HTTP/1.1 401 Unauthorized');
                    }
                    break;
                }

                default:
                    header('HTTP/1.0 400 Bad Request');
                    break;
            }
            break;
        }

        case 'DELETE':{
            $action= $_GET['action'] ?? "";
            switch($action){
                case "person":{
                    if($api->hasPermissions(3)){
                        if(isset($_GET["id"])){
                            require_once(__DIR__ . "/../assets/php/person.php");
                            $person = new person((int)$_GET["id"]);
                            if($person->delete()){
                                header('HTTP/1.0 202 Accepted');
                            }else{
                                header('HTTP/1.0 500 Internal Server Error');
                            }
                        }else{
                            header('HTTP/1.0 400 Bad Request');
                        }
                    }else{
                        header('HTTP/1.1 401 Unauthorized');
                    }
                    break;
                }

                case "fine":{
                    if($api->hasPermissions(3)){
                        if(isset($_GET["id"])){
                            require_once(__DIR__ . "/../assets/php/bußgeld.php");
                            $fine = new bußgeld((int)$_GET["id"]);
                            if($fine->delete()){
                                header('HTTP/1.0 202 Accepted');
                            }else{
                                header('HTTP/1.0 500 Internal Server Error');
                            }
                        }else{
                            header('HTTP/1.0 400 Bad Request');
                        }
                    }else{
                        header('HTTP/1.1 401 Unauthorized');
                    }
                    break;
                }

                case "akte":{
                    if($api->hasPermissions(3)){
                        if(isset($_GET["id"])){
                            require_once(__DIR__ . "/../assets/php/aktensys.php");
                            $akte = new aktensys((int)$_GET["id"]);
                            if($akte->delete()){
                                header('HTTP/1.0 202 Accepted');
                            }else{
                                header('HTTP/1.0 500 Internal Server Error');
                            }
                        }else{
                            header('HTTP/1.0 400 Bad Request');
                        }
                    }else{
                        header('HTTP/1.1 401 Unauthorized');
                    }
                    break;
                }

                default:
                    header('HTTP/1.0 400 Bad Request');
                    break;
            }
            break;
        }

        default:
            header('HTTP/1.0 401 Bad Request');
            break;

}

