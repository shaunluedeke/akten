<?php

class person
{
    private int $id;
    private main $main;

    public function __construct(int $id=0)
    {
        $this->id = $id;
        require_once(__DIR__ . "/main.php");
        $this->main = new main();
    }

    public function setID(int $id):void
    {
        $this->id = $id;
    }

    public function get($id=0):array{
        $a = array();
        $mysql = $this->main->getSQL();
        $id = $id !== 0 ? $id : $this->id;
        if (($id !== 0) && $mysql->count("SELECT `ID` FROM `personregister`")< 1) {
            return array();
        }
        $result = ($mysql->result("SELECT * FROM `personregister`" . ($id !== 0 ? " WHERE `ID`='$id'" :"")));
        if ($id !== 0) {
            while ($row = mysqli_fetch_array($result)) {
                $rid = $row['ID'];
                $a["id"] = $rid;
                $a["name"] = $row["Name"];
                $a["birthday"] = $row["Birthday"];
                $a["isalive"] = (bool)$row["IsAlive"];
                $a["wanted"] = (bool)$row["Wanted"];
                try {
                    $a["data"] = json_decode($row["Data"], true, 512, JSON_THROW_ON_ERROR);
                } catch (JsonException $e) {
                }
                return $a;
            }
        } else {
            while ($row = mysqli_fetch_array($result)) {
                $rid = $row['ID'];
                $a[$rid]["id"] = $rid;
                $a[$rid]["name"] = $row["Name"];
                $a[$rid]["birthday"] = $row["Birthday"];
                $a[$rid]["isalive"] = (bool)$row["IsAlive"];
                $a[$rid]["wanted"] = (bool)$row["Wanted"];
                try {
                    $a[$rid]["data"] = json_decode($row["Data"], true, 512, JSON_THROW_ON_ERROR);
                } catch (JsonException $e) {
                }
            }
        }
        return $a;
    }

    public function add(string $name,string $birthday,array $data):int{
        $mysql = $this->main->getSQL();
        try {
            $json = json_encode($data, JSON_THROW_ON_ERROR);
            $id = $this->randomint();
            $mysql->query("INSERT INTO `personregister` (`ID`,`Name`, `Birthday`, `Data`, `IsAlive`, `Wanted`) VALUES ('$id','$name', '$birthday', '$json', '1', '0')");
            return $id;
        } catch (JsonException $e) {
            var_dump($e->getMessage());
        }
        return 0;
    }

    public function update(string $name,string $birthday,array $data):bool{
        $mysql = $this->main->getSQL();
        try {
            $json = json_encode($data, JSON_THROW_ON_ERROR);
            return $mysql->query("UPDATE `personregister` SET `Name`='$name', `Birthday`='$birthday', `Data`='$json' WHERE `ID`='$this->id'");
        } catch (JsonException $e) {
        }
        return false;
    }

    public function delete():bool{
        $mysql = $this->main->getSQL();
        return $mysql->query("DELETE FROM `personregister` WHERE `ID`='$this->id'");
    }

    public function setAlive(bool $value = true):bool{
        $mysql = $this->main->getSQL();
        $data = $this->get();
        if($data["isalive"]!==$value){
            require_once(__DIR__."/../lib/discord/discord_auth.php");
            $webhook = new discord_webhook();
            $webhook->setTitle("Personenregister Update");
            $webhook->setTxt($data["name"] ." ist ". ($value ? "am Leben!" : "Verstorben!"));
            $webhook->setColor(($value ? "000000" : "FFFFFF"));
            $webhook->send();
        }
        return $mysql->query("UPDATE `personregister` SET `IsAlive`='" . ($value ? "1" : "0") . "' WHERE `ID`='$this->id'");
    }

    public function setWanted(bool $value=false):bool{
        $mysql = $this->main->getSQL();
        $data = $this->get();
        if($data["wanted"]!==$value){
            require_once(__DIR__."/../lib/discord/discord_auth.php");
            $webhook = new discord_webhook();
            $webhook->setTitle("Personenregister Update");
            $webhook->setTxt($data["name"] ." wird ". ($value ? "Gesucht!" : "nicht mehr Gesucht!"));
            $webhook->setColor(($value ? "FF0000" : "00FF00"));
            $webhook->send();
        }
        return $mysql->query("UPDATE `personregister` SET `Wanted`='" . ($value ? "1" : "0") . "' WHERE `ID`='$this->id'");
    }

    private function randomint():int{
        require_once(__DIR__."/../lib/random/random.php");
        $i = $this->main->getSQL()->count("SELECT `ID` FROM `personregister`")+1;
        while($this->main->getSQL()->count("SELECT `ID` FROM `personregister` WHERE `ID`='$i'")>0){
            $i = $this->main->getSQL()->count("SELECT `ID` FROM `personregister`")+1;
        }
        return $i;
    }

    public function getID(string $name=""):int{
        if($name === ""){
            return $this->id;
        }
        $mysql = $this->main->getSQL();
        $result = $mysql->result("SELECT `ID` FROM `personregister` WHERE `Name`='$name'");
        while ($row = mysqli_fetch_array($result)) {
            return $row['ID'];
        }
        return 0;
    }

    public function addAkte($id):bool{
        if($this->id === 0){
            return false;
        }
        $d = $this->get();
        $a = $d["data"]["akte"] ?? array();
        $a[] = $id;
        $d["data"]["akte"] = $a;
        return $this->update($d["name"],$d["birthday"],$d["data"]);
    }

    public function removeAkte($id):bool{
        if($this->id === 0){
            return false;
        }
        $d = $this->get();
        if(!isset($d["data"]["akte"])){
            return false;
        }
        $key = array_search($id, $d["data"]["akte"], true);
        if (false !== $key) {
            unset($d["data"]["akte"][$key]);
        }
        return $this->update($d["name"],$d["birthday"],$d["data"]);
    }

    public function sync():bool{
        try{
            $api = $this->main->sendAPIrequest("GET","?action=character");
            if(count($api)>0 && isset($api["status"])===false){
                foreach($api as $key => $value){
                    if($this->main->getSQL()->count("SELECT * FROM `personregister` WHERE `Name`='".$value["charname"]."'")<1){
                        $data = [
                            "wantedfor" => (""),
                            "tel" => ($value["sim"] ?? ""),
                            "adress" => ($value["address"] ?? ""),
                            "akte" => ([]),
                            "frac" => (""),
                            "license" => (""),
                            "note" => "",
                            "files" => ([])
                        ];
                        $this->add($value["charname"], date("d.m.Y", strtotime($value["birthdate"])), $data);
                    }
                }
            }
            return true;
        }catch(Exception $e){}
        return false;
    }
}