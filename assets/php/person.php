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

    public function set_id(int $id):void
    {
        $this->id = $id;
    }

    public function get():array{
        $a = array();
        $mysql = $this->main->getSQL();
        if (($this->id !== 0) && $mysql->count("SELECT `ID` FROM `personregister`")< 1) {
            return array();
        }
        $result = ($mysql->result("SELECT * FROM `personregister`" . ($this->id !== 0 ? " WHERE `ID`='$this->id'" :"")));
        if ($this->id !== 0) {
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['ID'];
                $a["id"] = $id;
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
                $id = $row['ID'];
                $a[$id]["id"] = $id;
                $a[$id]["name"] = $row["Name"];
                $a[$id]["birthday"] = $row["Birthday"];
                $a[$id]["isalive"] = (bool)$row["IsAlive"];
                $a[$id]["wanted"] = (bool)$row["Wanted"];
                try {
                    $a[$id]["data"] = json_decode($row["Data"], true, 512, JSON_THROW_ON_ERROR);
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
        return $mysql->query("UPDATE `personregister` SET `IsAlive`='" . ($value ? "1" : "0") . "' WHERE `ID`='$this->id'");
    }

    public function setWanted(bool $value=false):bool{
        $mysql = $this->main->getSQL();
        return $mysql->query("UPDATE `personregister` SET `Wanted`='" . ($value ? "1" : "0") . "' WHERE `ID`='$this->id'");
    }

    private function randomint():int{
        require_once(__DIR__."/../lib/random/random.php");
        $i = random::getInt(8);
        while($this->main->getSQL()->count("SELECT `ID` FROM `personregister` WHERE `ID`='$i'")>0){
            $i = random::getInt(8);
        }
        return $i;
    }

}