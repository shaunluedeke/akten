<?php
class api
{
    private string $api_key;
    private main $main;
    public function __construct(string $ip="")
    {
        $this->api_key = $ip;
        require_once(__DIR__ . "/main.php");
        $this->main = new main();
    }

    public function get_api_key():string
    {
        return $this->api_key;
    }

    public function hasPermissions(int $rang):bool{
        if($this->api_key === ""){
            return false;
        }
        if($this->main->getSQL()->count("SELECT `Rang` FROM `apiaccess` WHERE `IP` = '".$this->api_key."'")<1){
            return false;
        }
        $result = $this->main->getSQL()->result("SELECT `Rang`,`Blocked` FROM `apiaccess` WHERE `IP` = '".$this->api_key."'");
        while($row = mysqli_fetch_array($result)){
            if($row["Rang"] >= $rang && !(bool)$row["Blocked"]){
                return true;
            }
        }
        return false;
    }



}