<?php

class aktensys
{
    private int $id;
    private main $main;

    public function __construct(int $id = 0)
    {
        $this->id = $id;
        require_once(__DIR__ . "/main.php");
        $this->main = new main();
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function get(int $fracid=0): array
    {
        $a = array();
        $mysql = $this->main->getSQL();
        if (($this->id !== 0) && $mysql->count("SELECT `ID` FROM `akten`".($fracid!==0? "WHERE `Access`='$fracid' OR `Freigabe`='$fracid'" : "")) < 1) {
            return array();
        }
        $result = ($mysql->result("SELECT * FROM `akten`" . ($this->id !== 0 ? " WHERE `ID`='$this->id'" : ($fracid!==0? "WHERE `Access`='$fracid' OR `Freigabe`='$fracid'"  : ""))));
        if ($this->id !== 0) {
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['ID'];
                $a["id"] = $id;
                $a["name"] = $row["Name"];
                $a["access"] = (int)$row["Access"];
                $a["release"] = (int)$row["Freigabe"];
                try {
                    $a["data"] = json_decode($row["Data"], true, 512, JSON_THROW_ON_ERROR);
                } catch (JsonException $e) {
                }
                return $a;
            }
        } else {
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['ID'];
                $a[$id]["id"] = $id;
                $a[$id]["name"] = $row["Name"];
                $a[$id]["access"] = (int)$row["Access"];
                $a[$id]["release"] = (int)$row["Freigabe"];
                try {
                    $a[$id]["data"] = json_decode($row["Data"], true, 512, JSON_THROW_ON_ERROR);
                } catch (JsonException $e) {
                }
            }
        }
        return $a;
    }

    public function delete(): bool
    {
        if ($this->id !== 0) {
            require_once(__DIR__ . '/person.php');
            $person = new person();
            $pid = $person->getID($this->get()["name"]);
            if($pid !== 0) {
                $person->setID($pid);
                $person->removeAkte($this->id);
            }
            require_once(__DIR__."/../lib/discord/discord_auth.php");
            $webhook = new discord_webhook();
            require_once(__DIR__."/fracsys.php");
            $fracsys = new fracsys($this->get()["access"]);
            $webhook->setTitle("AktenSystem Delete (".$fracsys->name().")");
            $webhook->setTxt("Eine Akte wurde gelöscht von ".$_SESSION["name"]."! [Link](https://rpakte.de/index.php?site=akten-all)");
            $webhook->setColor(("ff0000"));
            $webhook->send();
            return $this->main->getSQL()->query("DELETE FROM `akten` WHERE `ID`='$this->id'");
        }
        return false;
    }

    public function set($name, $access,array $data): int
    {
        $id = $this->main->generateAktenID((int)$access);
        try {
            $this->main->getSQL()->query("INSERT INTO `akten`(`ID`, `Name`, `Data`, `Access`) VALUES ('$id','$name','" . json_encode($data, JSON_THROW_ON_ERROR) . "','$access')");
            require_once(__DIR__ . '/person.php');
            $person = new person();
            $pid = $person->getID($name);
            if ($pid === 0) {
                $data = [
                    "tel" => $data["tel"] ?? "",
                    "adress" => $data["adress"] ?? "",
                    "akte" => [],
                    "wantedfor" => "",
                    "note" => "",
                    "files" => []
                ];
                $pid = $person->add($name, date("d.m.Y",strtotime($data["gb"] ?? date("Y-m-d"))),$data);
            }
            $person->setID($pid);
            $person->addAkte($id);
            require_once(__DIR__."/fracsys.php");
            $fracsys = new fracsys($access);
            require_once(__DIR__."/../lib/discord/discord_auth.php");
            $webhook = new discord_webhook();
            $webhook->setTitle("AktenSystem Add (".$fracsys->name().")");
            $webhook->setTxt("Eine Akte wurde hinzugefügt von ".$_SESSION["name"]."! [Link](https://rpakte.de/index.php?site=akte&id=".$id.")");
            $webhook->setColor(("00ffff"));
            $webhook->send();

            if((int)$access === 3) {
                require_once(__DIR__."/vehicle.php");
                $vehicle = new vehicle();
                $vid = $vehicle->getID(strtoupper($data["kfz"]));
                if($vid === 0) {$vid = $vehicle->add($data["kfz"],["kfz_typ"=>"","kfz_farbe"=>"","kfz_km"=>"","halterid"=>$pid??0,"halter"=>$name??"","halternumber"=>$data["tel"] ??"","akte" => [],"wantedfor" => "", "note" => ""]);}
                $vehicle->setID($vid);
                $vehicle->addAkte($id);
            }

        } catch (JsonException $e) {
        }
        return $id;
    }

    public function update($name,array $data): bool
    {
        if($this->id===0){
            return false;
        }
        try {
            require_once(__DIR__."/fracsys.php");
            $fracsys = new fracsys($this->get()["access"]);
            require_once(__DIR__."/../lib/discord/discord_auth.php");
            $webhook = new discord_webhook();
            $webhook->setTitle("AktenSystem Update (".$fracsys->name().")");
            $webhook->setTxt("Eine Akte wurde geändert von ".$_SESSION["name"]."! [Link](https://rpakte.de/index.php?site=akte&id=".$this->id.")");
            $webhook->setColor(("00ffff"));
            $webhook->send();
            return $this->main->getSQL()->query("UPDATE `akten` SET `Name`='$name',`Data`='" . json_encode($data, JSON_THROW_ON_ERROR) . "' WHERE `ID`='$this->id'");
        } catch (JsonException $e) {
        }
        return false;
    }

    public function updaterelese($fracid):bool{
        if($this->id===0){
            return false;
        }
        return $this->main->getSQL()->query("UPDATE `akten` SET `Freigabe`='$fracid' WHERE `ID`='$this->id'");
    }

    public function hasAccess($fracid):bool{
        if($this->id===0){
            return false;
        }
        if($fracid===0){
            return true;
        }
        $a = $this->get();
        return ($fracid === ($a["access"] ?? $fracid) || $fracid === ($a["release"] ?? $fracid));
    }
}