<?php

class bußgeld
{
    private int $access;
    private int $id;
    private main $main;

    public function __construct(int $access = 0, int $id = 0)
    {
        $this->id = $id;
        $this->access = $access;
        require_once(__DIR__ . "/main.php");
        $this->main = new main();
    }

    public function get_access(): int
    {
        return $this->access;
    }

    public function get_id(): int
    {
        return $this->id;
    }

    public function set_access(int $access): void
    {
        $this->access = $access;
    }

    public function set_id(int $id): void
    {
        $this->id = $id;
    }

    public function add($paragraf, $name, $geld):int
    {
        require_once(__DIR__ . "/../lib/random/random.php");
        $this->id = $this->id === 0 ? random::getInt() : $this->id;
        if(!isset($_SESSION)){session_start();}
        $this->access = $this->access === 0 ? (int)$_SESSION["access"] : $this->access;
        require_once(__DIR__."/../lib/discord/discord_auth.php");
        require_once(__DIR__."/fracsys.php");
        $fracsys = new fracsys($this->access);
        $webhook = new discord_webhook();
        $webhook->setTitle("Bußgeld Hinzugefügt für das ".$fracsys->name());
        $webhook->setTxt("Ein Bußgeld wurde hinzugefügt von ".$_SESSION["name"]."! [Link](https://rpakte.de/index.php?site=fine)");
        $webhook->setColor(("00ff00"));
        $webhook->send();
        $this->main->getSQL()->query("INSERT INTO `geldkatalog`(`ID`, `Paragraf`, `Name`, `Geld`, `Access`) VALUES ('$this->id','$paragraf','$name','$geld','$this->access')");
        return $this->id;
    }

    public function edit($paragraf, $name, $geld):bool
    {
        if(!isset($_SESSION)){session_start();}
        $this->access = $this->access === 0 ? (int)$_SESSION["access"] : $this->access;

        require_once(__DIR__."/../lib/discord/discord_auth.php");
        $webhook = new discord_webhook();
        require_once(__DIR__."/fracsys.php");
        $fracsys = new fracsys($this->access);
        $webhook->setTitle("Bußgeld Edit für das ".$fracsys->name());
        $webhook->setTxt("Ein Bußgeld wurde geändert von ".$_SESSION["name"]."! [Link](https://rpakte.de/index.php?site=fine)");
        $webhook->setColor(("00ffff"));
        $webhook->send();

        return $this->main->getSQL()->query("UPDATE `geldkatalog` SET `Paragraf`='$paragraf',`Name`='$name',`Geld`='$geld',`Access`='$this->access' WHERE `ID`='$this->id'");
    }

    public function delete():bool
    {
        return $this->main->getSQL()->query("DELETE FROM `geldkatalog` WHERE `ID`='$this->id'");
    }

    public function get():array{
        $a = array();
        $mysql = $this->main->getSQL();
        if (($this->id !== 0) && $mysql->count("SELECT `ID` FROM `geldkatalog` ".($this->access===0?"":"WHERE `Access`='$this->access'"))< 1) {
            return array();
        }
        $result = ($mysql->result("SELECT * FROM `geldkatalog`" . ($this->id !== 0 ? " WHERE `ID`='$this->id'" :($this->access===0?"":" WHERE `Access`='$this->access'"))));
        if($result===null){
            return array();
        }
        if ($this->id !== 0) {
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['ID'];
                $a["id"] = $id;
                $a["paragraf"] = $row["Paragraf"];
                $a["name"] = $row["Name"];
                $a["geld"] = $row["Geld"];
                $a["access"] = (int)$row["Access"];
                return $a;
            }
        } else {
            while ($row = mysqli_fetch_array($result)) {
                $id = $row["Paragraf"];
                $a[$id]["id"] = $row['ID'];
                $a[$id]["paragraf"] = $row["Paragraf"];
                $a[$id]["name"] = $row["Name"];
                $a[$id]["geld"] = $row["Geld"];
                $a[$id]["access"] = (int)$row["Access"];
            }
        }
        return $a;
    }

}