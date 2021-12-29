<?php

class fracsys
{

    private int $access;
    private main $main;

    public function __construct(int $access)
    {
        $this->access = $access;
        require_once(__DIR__ .'/main.php');
        $this->main = new main();
    }

    public function setAccess(int $access): void
    {
        $this->access = $access;
    }

    public function getAccess():int
    {
        return $this->access;
    }

    public function name($access=0):string
    {
        $mysql = $this->main->getSQL();
        $access = $access===0 ? $this->access : $access;
        if($access===0)
        {
            return 'Verwaltung';
        }
        $result = ($mysql->result("SELECT `Name` FROM `frac` WHERE `Access` = '$access'"));
        if($result===null){
            return 'Keine Fraction';
        }
        while($row = mysqli_fetch_array($result)){
            return $row['Name'];
        }
        return 'Keine Fraction';
    }

    public function text(string $key="",$access=0):array
    {
        $mysql = $this->main->getSQL();
        $access = $access===0 ? $this->access : $access;
        $result = ($mysql->result("SELECT `Textfile` FROM `frac` WHERE `Access` = '$access'"));
        if($result===null){
            return [];
        }
        while($row = mysqli_fetch_array($result)){
            try {
                $a = json_decode(file_get_contents(__DIR__."/../textfiles/".$row['Textfile'].".json"), true, 512, JSON_THROW_ON_ERROR);
                if($key!==""){
                    return $a[$key];
                }
                return $a;
            }catch (JsonException $e){}
        }
        return [];
    }

    public function aktenid($access=0):int
    {
        $mysql = $this->main->getSQL();
        $access = $access===0 ? $this->access : $access;
        $result = ($mysql->result("SELECT `AktenID` FROM `frac` WHERE `Access` = '$access'"));
        if($result===null){
            return 0;
        }
        while($row = mysqli_fetch_array($result)){
            return (int)$row['AktenID'];
        }
        return 0;
    }
}