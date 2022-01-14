<?php

class vehicle
{
    private int $id;
    private main $main;

    public function __construct(int $id = 0)
    {
        $this->id = $id;
        require_once(__DIR__ . "/main.php");
        $this->main = new main();
    }

    public function setID(int $id): void
    {
        $this->id = $id;
    }

    public function get(): array
    {
        $a = array();
        $result = ($this->main->getSQL()->result("SELECT * FROM `vehicle`" . ($this->id !== 0 ? " WHERE `ID`='$this->id'" : "")));
        if ($this->id !== 0) {
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['ID'];
                $a["id"] = (int)$id;
                $a["number"] = $row["Number"];
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
                $a[$id]["id"] = (int)$id;
                $a[$id]["number"] = $row["Number"];
                $a[$id]["wanted"] = (bool)$row["Wanted"];
                try {
                    $a[$id]["data"] = json_decode($row["Data"], true, 512, JSON_THROW_ON_ERROR);
                } catch (JsonException $e) {
                }
            }
        }
        return $a;
    }

    public function add(string $number, array $data,bool $wanted = false): bool
    {
        require_once(__DIR__."/../lib/discord/discord_auth.php");
        $webhook = new discord_webhook();
        $webhook->setTitle("Fahrzeug Add");
        $webhook->setTxt("Eine Fahrzeug wurde hinzugefügt von ".$_SESSION["name"]."! [Link](https://rpakte.de/index.php?site=vehicle)");
        $webhook->setColor(("00ffff"));
        $webhook->send();
        try {return $this->main->getSQL()->query("INSERT INTO `vehicle`(`Number`, `Data`, `Wanted`) VALUES ('".strtoupper($number)."','".json_encode($data, JSON_THROW_ON_ERROR)."','".($wanted ? 1:0)."')");} catch (JsonException $e) {}
        return false;
    }

    public function update(string $name,array $data): bool
    {
        try {return $this->main->getSQL()->query("UPDATE `vehicle` SET `Number`='$name', `Data`='".json_encode($data, JSON_THROW_ON_ERROR)."' WHERE `ID`='$this->id'");} catch (JsonException $e) {}
        return false;
    }

    public function delete(): bool
    {
        return $this->main->getSQL()->query("DELETE FROM `vehicle` WHERE `ID`='$this->id'");
    }

    public function setWanted(bool $value = false): bool
    {
        $data = $this->get();
        if ($data["wanted"] !== $value) {
            require_once(__DIR__ . "/../lib/discord/discord_auth.php");
            $webhook = new discord_webhook();
            $webhook->setTitle("Fahrzeug Update");
            $webhook->setTxt("Das Fahrzeug mit dem Kennzeichen ".$data["number"] . " wird " . ($value ? "Gesucht!" : "nicht mehr Gesucht!"));
            $webhook->setColor(($value ? "FF0000" : "00FF00"));
            $webhook->send();
        }
        return $this->main->getSQL()->query("UPDATE `vehicle` SET `Wanted`='" . ($value ? "1" : "0") . "' WHERE `ID`='$this->id'");
    }

    public function getID(string $name = ""): int
    {
        if ($name === "") {
            return $this->id;
        }
        $mysql = $this->main->getSQL();
        $result = $mysql->result("SELECT `ID` FROM `vehicle` WHERE `Number`='$name'");
        while ($row = mysqli_fetch_array($result)) {
            return $row['ID'];
        }
        return 0;
    }

    public function addAkte($id): bool
    {
        $d = $this->get();
        $a = $d["data"]["akte"] ?? array();
        $a[] = $id;
        $d["data"]["akte"] = $a;
        return $this->update($d["number"], $d["data"]);
    }

    public function removeAkte($id): bool
    {
        $d = $this->get();
        if (!isset($d["data"]["akte"])) {
            return false;
        }
        $key = array_search($id, $d["data"]["akte"], true);
        if (false !== $key) {
            unset($d["data"]["akte"][$key]);
        }
        return $this->update($d["name"], $d["data"]);
    }
}