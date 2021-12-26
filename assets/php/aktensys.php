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
            $mysql = $this->main->getSQL();
            return $mysql->query("DELETE FROM `akten` WHERE `ID`='$this->id'");
        }
        return false;
    }

    public function set($name, $date, $access, $creator, $gb, $tel, $straftat, $vernehmung, $aufklarung, $urteil): int
    {
        $id = $this->main->generateAktenID($access === 1);
        $data = array();
        $data["date"] = $date;
        $data["creator"] = $creator;
        $data["gb"] = $gb;
        $data["tel"] = $tel;
        $data["straftat"] = $straftat;
        $data["vernehmung"] = $vernehmung;
        $data["aufklarung"] = $aufklarung;
        $data["urteil"] = $urteil;
        try {
            $this->main->getSQL()->query("INSERT INTO `akten`(`ID`, `Name`, `Data`, `Access`) VALUES ('$id','$name','" . json_encode($data, JSON_THROW_ON_ERROR) . "','$access')");
        } catch (JsonException $e) {
        }
        return $id;
    }

    public function update(string $name, string $date, string $creator, string $gb, string $tel, string $straftat, string $vernehmung, string $aufklarung, string $urteil): bool
    {
        if($this->id===0){
            return false;
        }
        $data = array();
        $data["date"] = $date;
        $data["creator"] = $creator;
        $data["gb"] = $gb;
        $data["tel"] = $tel;
        $data["straftat"] = $straftat;
        $data["vernehmung"] = $vernehmung;
        $data["aufklarung"] = $aufklarung;
        $data["urteil"] = $urteil;
        try {
            return $this->main->getSQL()->query("UPDATE `akten` SET `Name`='$name',`Data`='" . json_encode($data, JSON_THROW_ON_ERROR) . "' WHERE `ID`='$this->id'");
        } catch (JsonException $e) {
        }
        return false;
    }

    public function updaterelese(int $fracid):bool{
        if($this->id===0){
            return false;
        }
        return $this->main->getSQL()->query("UPDATE `akten` SET `Freigabe`='$fracid' WHERE `ID`='$fracid'");
    }
}