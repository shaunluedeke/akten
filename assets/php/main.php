<?php
class main
{
    public function __construct()
    {
    }

    public function init(): bool
    {
        $mysql = $this->getSQL();
        return  $mysql->query("CREATE TABLE IF NOT EXISTS `login` ( `ID` INT(16) NOT NULL AUTO_INCREMENT , `Username` VARCHAR(255) NOT NULL , `PW` TEXT NOT NULL , `Rang` INT(1) NOT NULL , `Access` INT(1) NOT NULL , PRIMARY KEY (`ID`)) ENGINE = InnoDB;") &&
                $mysql->query("CREATE TABLE IF NOT EXISTS `akten` ( `ID` INT(16) NOT NULL AUTO_INCREMENT , `Name` TEXT NOT NULL , `Data` TEXT NOT NULL , `Access` INT(1) NOT NULL , `Freigabe` INT(1) NOT NULL DEFAULT '0' ,PRIMARY KEY (`ID`)) ENGINE = InnoDB;") &&
                $mysql->query("CREATE TABLE IF NOT EXISTS `personregister` ( `ID` INT(16) NOT NULL AUTO_INCREMENT , `Name` VARCHAR(200) NOT NULL , `Birthday` VARCHAR(200) NOT NULL , `Data` TEXT NOT NULL , `IsAlive` BOOLEAN NOT NULL DEFAULT '1', `Wanted` BOOLEAN NOT NULL DEFAULT '0', PRIMARY KEY (`ID`)) ENGINE = InnoDB;") &&
                $mysql->query("CREATE TABLE IF NOT EXISTS `geldkatalog` ( `ID` INT(16) NOT NULL AUTO_INCREMENT , `Paragraf` VARCHAR(200) NOT NULL , `Name` VARCHAR(200) NOT NULL , `Geld` VARCHAR(200) NOT NULL , `Access` INT NOT NULL , PRIMARY KEY (`ID`)) ENGINE = InnoDB;")&&
                $mysql->query("CREATE TABLE IF NOT EXISTS `apiaccess` ( `ID` INT(16) NOT NULL AUTO_INCREMENT , `IP` VARCHAR(200) NOT NULL , `Rang` INT(1) NOT NULL , `Token` VARCHAR(200) NOT NULL, `Blocked` BOOLEAN NOT NULL DEFAULT FALSE , PRIMARY KEY (`ID`)) ENGINE = InnoDB;")&&
                $mysql->query("CREATE TABLE IF NOT EXISTS `frac` ( `Access` INT(16) NOT NULL AUTO_INCREMENT , `Name` VARCHAR(200) NOT NULL , `Textfile` VARCHAR(200) NOT NULL, `AktenID` INT(16) NOT NULL, PRIMARY KEY (`Access`)) ENGINE = InnoDB;");
    }

    public function login(string $username, string $password): bool
    {
        $mysql = $this->getSQL();
        $usercrypt = base64_encode($username);
        $pwencrypt = hash('sha256', md5($password));
        if ($mysql->count("SELECT `PW` FROM `login` WHERE `Username`='$usercrypt'") > 0) {
            $result = $mysql->result("SELECT * FROM `login` WHERE `Username`='$usercrypt'");
            while($row= mysqli_fetch_array($result)){
                if($row["PW"]===$pwencrypt){
                    if(!isset($_SESSION)){session_start();}
                    $_SESSION["login"]=1;
                    $_SESSION["name"]=base64_decode($row["Username"]);
                    $_SESSION["rang"]=(int)$row["Rang"];
                    $_SESSION["access"]=(int)$row["Access"];
                    return true;
                }
            }
        }
        return false;
    }

    public function register(string $username, string $password = "", int $rang = 0, int $access = 0): string
    {
        $mysql = $this->getSQL();
        $usercrypt = base64_encode($username);
        if ($mysql->count("SELECT `ID` FROM `login` WHERE `Username`='$usercrypt'") > 0) {
            return "#ERROR 1#";
        }
        $pw = $password === "" ? $this->generatePW() : $password;
        $pwencrypt = hash('sha256', md5($pw));
        if (!$mysql->query("INSERT INTO `login`(`ID`, `Username`, `PW`, `Rang`, `Access`) VALUES (null,'$usercrypt','$pwencrypt','$rang','$access')")) {
            return "#ERROR 2#";
        }
        return $pw;
    }

    private function generatePW(): string
    {
        require(__DIR__ . "/../lib/random/random.php");
        $random = random::getString(12);
        $mysql = $this->getSQL();
        while ($mysql->count("SELECT `ID` FROM `login` WHERE `PW`='$random'") > 0) {
            $random = random::getString(12);
        }
        return $random;
    }

    public function generateAktenID(int $access):int{
        require_once(__DIR__ . "/../lib/random/random.php");
        require_once(__DIR__ ."/fracsys.php");
        $fracsys = new fracsys($access);
        $mysql = $this->getSQL();
        $random = $fracsys->aktenid().random::getInt(5,false);
        while ($mysql->count("SELECT `ID` FROM `akten` WHERE `ID`='$random'") > 0) {
            $random = $fracsys->aktenid().random::getInt(5,false);
        }
        return $random;
    }

    public function getUser(int $id=0):array{
        $a = array();
        $mysql = $this->getSQL();
        $wid = $id===0 ? "" : " WHERE `ID`='$id'";
        $result = $mysql->result("SELECT * FROM `login`".$wid);
        if($id===0) {
            while($row=mysqli_fetch_array($result)){
                $nid = $row["ID"];
                $a[$nid]["ID"]=$nid;
                $a[$nid]["name"]=base64_decode($row["Username"]);
                $a[$nid]["rang"]=($row["Rang"]);
                $a[$nid]["access"]=($row["Access"]);
            }
        }else{
            while($row=mysqli_fetch_array($result)){
                $a["ID"]=$row["ID"];
                $a["name"]=base64_decode($row["Username"]);
                $a["rang"]=($row["Rang"]);
                $a["access"]=($row["Access"]);
            }
        }

        return $a;
    }

    public function getSQL(): mysql_connetion
    {
        require_once(__DIR__ . "/../lib/mysql/mysql_connetion.php");
        return new mysql_connetion();
    }

    public function sonderzeichenentfernen($string):string
    {
        return str_replace(array("ä", "ü", "ö", "Ä", "Ü", "Ö", "ß", "´","§","&"),
            array("&auml;", "&uuml;", "&ouml;", "&Auml;", "&Uuml;", "&Ouml;", "&szlig;", "","&sect;","&amp;"), $string);

    }

    public function sonderzeichenhinzufügen($string):string
    {
        return str_replace(array("&auml;", "&uuml;", "&ouml;", "&Auml;", "&Uuml;", "&Ouml;", "&szlig;", "´","&sect;","&amp;"),
            array("ä", "ü", "ö", "Ä", "Ü", "Ö", "ß", "","§","&"), $string);
    }
}