<?php


require(__DIR__ . "/../config/discord_auth_config.php");

class discord_auth
{

    private string $client_id;
    private string $client_secret;
    private string $redirect;

    private string $tokenURL = 'https://discordapp.com/api/oauth2/token';
    private string $apiURLBase = 'https://discordapp.com/api/users/@me';

    public function __construct ( string $redirect="", string $client_id="", string $client_secret="") {
        $this -> client_id = $client_id===""?discord_auth_config::$client_id:$client_id;
        $this -> client_secret = $client_secret===""?discord_auth_config::$client_secret:$client_secret;
        $this -> redirect = $redirect===""?discord_auth_config::$redirect:$redirect;
    }


    public function login():void{
        header('Location: https://discordapp.com/api/oauth2/authorize' . '?' . http_build_query(array(
                "client_id" => $this -> client_id,
                "redirect_uri" => $this -> redirect,
                "response_type" => 'code',
                "scope" => discord_auth_config::$scope)));
        die();
    }

    public function get_token ($code) {
        $ch = curl_init($this -> tokenURL);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            "grant_type" => "authorization_code",
            "client_id" => $this -> client_id,
            "client_secret" => $this -> client_secret,
            "redirect_uri" => $this -> redirect,
            "code" => $code)));
        $headers[] = 'Accept: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        try {
            return json_decode($response, false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
        }
        return array();
    }

    public function get_info ($access_token) {
        $ch = curl_init($this -> apiURLBase);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Bearer ' . $access_token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        try {
            return json_decode($response, false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
        }
        return array();
    }

    public function getGuilds($access_token)
    {
        $ch = curl_init('https://discord.com/api/users/@me/guilds');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = array('Accept: application/json');
        if (isset($_SESSION['access_token'])) {
            $headers[] = 'Authorization: Bearer ' . $access_token;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        try {
            return json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
        }
        return array();
    }

}

class discord
{
    private $info;
    public function __construct ($info) {
        $this -> info = $info;
    }
    public function getID():string{
        return $this->info->id;
    }
    public function getDiscrimination():string{
        return $this->info->discriminator;
    }
    public function getName():string{
        return $this->info->username;
    }
    public function getNameComplite(): string
    {
        $info = $this->info;
        return $info->username."#".$info->discriminator;
    }
    public function getEmail(): string
    {
        return $this->info->email;
    }
    public function getVerified(): bool
    {
        return $this->info->verified;
    }
    public function getLocation(): string
    {
        return $this->info->locale;
    }

    public function getBannercolor(): string
    {
        return $this->info->banner_color;
    }

    public function getBanner(): string
    {
        $info = $this->info;
        $avatar = $info->banner;
        if($avatar===null || $avatar ===" "|| $avatar ===""){
            return  $this->getBannercolor();
        }
        $ext = substr($avatar, 0, 2);
        if ($ext === "a_") {$avatar.= ".gif";} else {$avatar.= ".png";}

        return "https://cdn.discordapp.com/banner/".$info->id."/".$avatar;
    }

    public function getAvatar(): string
    {
        $info = $this->info;
        $avatar = $info->avatar;

        $ext = substr($avatar, 0, 2);
        if ($ext === "a_") {$avatar.= ".gif";} else {$avatar.= ".png";}

        return "https://cdn.discordapp.com/avatars/".$this->info->id."/".$avatar;
    }

    public function get():array{
        $a=array();
        $a["name"] = $this->getName();
        $a["email"] = $this->getEmail();
        $a["location"] = $this->getLocation();
        $a["avatar"] = $this->getAvatar();
        $a["isverified"] = $this->getVerified();
        return $a;
    }
}

class discord_server{
    private $guild;

    public function __construct($guild){$this->guild=$guild;}

    public function getName($server=0):string{
        return $this->guild["".$server]["name"];
    }

    public function getID($server=0):string{
        return $this->guild["".$server]["id"];
    }

    public function getIcon($server=0):string{
        $avatar = $this->guild["".$server]["icon"];
        if($avatar!==null&&$server!==""&&$server!==" ") {
            $ext = substr($avatar, 0, 2);
            if ($ext === "a_") {
                $avatar .= ".gif";
            } else {
                $avatar .= ".png";
            }
            return "https://cdn.discordapp.com/icons/" . $this->getID($server) . "/$avatar?size=256";
        }
        return "assets/img/none.png";
    }

    public function getPermissions($server=0):int{
        return $this->guild["".$server]["permissions"];
    }

    public function getALL(bool $all=true,$server=0):array{
        $a=array();
        if($all){
            foreach(array_keys($this->guild) as $key){
                $a[$key]["name"]=$this->getName($key);
                $a[$key]["id"]=$this->getID($key);
                $a[$key]["icon"]=$this->getIcon($key);
                $a[$key]["permission"]=$this->getPermissions($server);
                $a[$key]["isowner"]=$this->hasPermission($key);
            }
            return $a;
        }
        $a["name"]=$this->getName($server);
        $a["id"]=$this->getID($server);
        $a["icon"]=$this->getIcon($server);
        $a["permission"]=$this->getPermissions($server);
        $a["isowner"]=$this->hasPermission($server);
        return $a;
    }

    public function hasPermission($server=0):bool{
        return ($this->getPermissions($server) & 2146958591) === 2146958591;
    }

}

class discord_webhook{

    private string $webhookurl;
    private string $txt="Das ist ein Test";
    private string $title="Discord Webhook";
    private string $avatar="";
    private string $username="Akten System";
    private string $hex="3366ff";
    private string $footer="";

    public function __construct(string $url="")
    {
        $this->webhookurl = $url===""?discord_auth_config::$webhookurl:$url;
    }

    public function setTxt(string $txt): void
    {
        $this->txt = $txt;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setAvatar(string $title): void
    {
        $this->avatar = '"avatar_url" => '.$title;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setColor(string $hex): void
    {
        $this->hex = $hex;
    }

    public function setFooter(string $footer): void
    {
        $this->footer = $footer;
    }

    public function getData():string{
        $timestamp = date("c");

        try {
            return json_encode([

                // Username
                "username" => $this->username,


                "tts" => false,
                "embeds" => [
                    [
                        "title" => $this->title,
                        "type" => "rich",
                        "description" => $this->txt,
                        "timestamp" => $timestamp,
                        "color" => hexdec($this->hex),

                        // Footer
                        "footer" => [
                            "text" => $this->footer,
                        ],

                        // Image to send
                        "image" => [
                            "url" => $this->avatar
                        ],
                    ]
                ]

            ], JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        } catch (JsonException $e) {
        }
        return "";
    }

    public function send():void{
        $ch = curl_init($this->webhookurl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getData());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_exec($ch);
        curl_close($ch);
    }
}