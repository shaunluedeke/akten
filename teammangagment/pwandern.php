<?php
session_start();
require(__DIR__.'/../assets/php/api/mysql/mysql_connetion.php');
$mysql = new mysql_connetion;
if(isset($_POST['logi']))
{
    if(empty($_POST['pwneu'])||empty($_POST['pwalt']))
    {

        ?> <script "text/javascript">
        alert("Du hast nicht alles eingegeben!");

        </script> <?php

    }else{
        $name = $_SESSION["username"];
        $db_res = $mysql->result("SELECT * FROM `login` WHERE `User` = '".$name."'");
        $row = mysqli_fetch_array($db_res);
        $pwalt = md5($_POST["pwalt"]);
        $pwres=$row["PW"];
        if($pwalt===$pwres) {
            $pwneu = md5($_POST["pwneu"]);

            mysql_connetion::query("UPDATE `login` SET `PW`='" . $pwneu . "' WHERE `User` = '" . $name . "'");
            ?> <script> alert("Du hast das Password ge&auml;ndert!"); </script><?php

        }else{
            ?> <script> alert("Das Alte Password Stimmt nicht!"); </script><?php
        }

        self.close();
        top.close();
    }

}
?>
<html lang="de" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Akten Teammangagment</title>
    <link rel="shortcut icon" type="image/png" href="/img/logo.png">
    <style>

        *{
            margin: 0;
            padding: 0;
            text-decoration: none;
            font-family: montserrat;
            box-sizing: border-box;
        }

        body{
            min-height: 100vh;
            background: #2C2F33 !important;
        }


        .login-form{
            width: 360px;
            background: #f1f1f1;
            height: 580px;
            padding: 80px 40px;
            border-radius: 10px;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%,-50%);
            animation: 5s rgb infinite;
        }

        .login-form h1{
            text-align: center;
            margin-bottom: 60px;
        }

        .txtb{
            border-bottom: 2px solid #adadad;
            position: relative;
            margin: 30px 0;
        }

        .txtb input{
            font-size: 15px;
            color: #333;
            border: none;
            width: 100%;
            outline: none;
            background: none;
            padding: 0 5px;
            height: 40px;
        }
        .container {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default radio button */
        .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        /* Create a custom radio button */
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #333333;
            border-radius: 50%;
        }

        /* On mouse-over, add a grey background color */
        .container:hover input ~ .checkmark {
            background-color: #ccc;
        }

        /* When the radio button is checked, add a blue background */
        .container input:checked ~ .checkmark {
            background-color: #2196F3;
        }

        /* Create the indicator (the dot/circle - hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the indicator (dot/circle) when checked */
        .container input:checked ~ .checkmark:after {
            display: block;
        }

        /* Style the indicator (dot/circle) */
        .container .checkmark:after {
            top: 9px;
            left: 9px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: white;
        }
        .txtb span::before{
            content: attr(data-placeholder);
            position: absolute;
            top: 50%;
            left: 5px;
            color: #adadad;
            transform: translateY(-50%);
            z-index: -1;
            transition: .5s;
        }

        .txtb span::after{
            content: '';
            position: absolute;
            color: #636e72;
            width: 0%;
            height: 2px;
            transition: .5s;
        }

        .focus + span::before{
            top: -5px;
        }
        .focus + span::after{
            width: 100%;
        }

        .logbtn{
            display: block;
            width: 100%;
            height: 50px;
            border: none;
            background: #2C2F33 !important;
            background-size: 200%;
            color: #fff;
            outline: none;
            cursor: pointer;
            transition: .5s;
        }

        .logbtn:hover{
            background-position: right;
            background: #86000d !important;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #86000d;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #86000d;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
        @keyframes rgb {

        }

        .logbtn:hover{
            background-position: right;
        }

        .bottom-text{
            margin-top: 60px;
            text-align: center;
            font-size: 13px;
        }

    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
</head>
<body>
<script type="text/javascript" color="200, 0, 0" opacity="1.6" zindex="-2" count="150" src="http://www.cssscript.com/demo/interactive-particle-nest-system-with-javascript-and-canvas-canvas-nest-js/canvas-nest.js"></script><canvas id="c_n2" width="725" height="913" style="position: fixed; top: 0px; left: 0px; z-index: -2; opacity: 0.7;"></canvas>

<form action="pwandern.php" method="POST" class="login-form">
    <h1>Password andern</h1>

    <div class="txtb">
        <input type="password" name="pwalt">
        <span data-placeholder="Altes Password" required></span>
    </div>
    <div class="txtb">
        <input type="password" name="pwneu" required>
        <span data-placeholder="Neues Password"></span>
    </div>


    <br>
    <br> <br>
    <br>

    <input type="submit" class="logbtn" name ="logi" value="Ändern">



</form>

<script type="text/javascript">
    $(".txtb input").on("focus",function(){
        $(this).addClass("focus");
    });

    $(".txtb input").on("blur",function(){
        if($(this).val() == "")
            $(this).removeClass("focus");
    });

</script>


</body>
</html>