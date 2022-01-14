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
      background-image: linear-gradient(120deg,#2d3436,#0a3d62);
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
      background: linear-gradient(120deg,#0a3d62,#2d3436,#0652DD);
      background-size: 200%;
      color: #fff;
      outline: none;
      cursor: pointer;
      transition: .5s;
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
<script type="text/javascript" color="76, 209, 55" opacity="1.4" zindex="-2" count="100" src="http://www.cssscript.com/demo/interactive-particle-nest-system-with-javascript-and-canvas-canvas-nest-js/canvas-nest.js"></script><canvas id="c_n2" width="725" height="913" style="position: fixed; top: 0px; left: 0px; z-index: -2; opacity: 0.7;"></canvas>

<form action="index.php?site=register" method="POST" class="login-form">
  <h1>User Hinzufügen</h1>

  <div class="txtb">
    <input type="text" name="usernam" required>
    <span data-placeholder="Username" ></span>
  </div>

  <div class="txtb">
    <input type="number" name="ran" value="0" max="1" min="0" required>
    <span data-placeholder="Rang"></span>
  </div>
  {if access}
    <div class="txtb">
    <input type="number" name="access" max="3" min="0" required>
    <span data-placeholder="Access"></span>
    </div>
  {/if access}
  <input type="submit" class="logbtn" name ="register" value="Hinzufügen">



</form>

</body>
</html>