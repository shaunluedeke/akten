<html>
<head>

    <meta charset="utf-8">
    <title>AktenSystem</title>
    <link rel="shortcut icon" type="image/png" href="/img/logo.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login/style.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    <link rel="stylesheet" href="assets/css/bootstap/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <script>
        function openSlideMenu(){
            document.getElementById('menu').style.width = '250px';
            document.getElementById('content').style.marginLeft = '250px';
        }
        function closeSlideMenu(){
            document.getElementById('menu').style.width = '0';
            document.getElementById('content').style.marginLeft = '0';
        }
    </script>
    <style>
        .form{
            width: 75%;
            margin: auto;
            background: rgba(18,17,17,0.48);
            padding: 10px 15px;
            border-radius: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<script type="text/javascript" color="200, 0, 0" opacity="1.6" zindex="-2" count="150" src="http://www.cssscript.com/demo/interactive-particle-nest-system-with-javascript-and-canvas-canvas-nest-js/canvas-nest.js"></script><canvas id="c_n2" width="725" height="913" style="position: fixed; top: 0px; left: 0px; z-index: -2; opacity: 0.7;"></canvas>
<div id="content">

    <span class="slide">
      <a onclick="openSlideMenu()">
        <i class="fas fa-bars"></i>
      </a>
    </span>

    <div id="menu" class="nav">
        <a class="close" onclick="closeSlideMenu()">
            <i class="fas fa-times"></i>
        </a>
        <a href="index.php">Home</a>


    </div>
    {if verwaltung}
    <div class="form">
        <h1>Neue PD Akte erstellen</h1>
        <form action="index.php?site=akten-create&frac=pd" method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" name="name" placeholder="Name" required>
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Geburtstag</label>
                <input type="text" class="form-control" name="gb" placeholder="Geburtstag">
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Telefonnummer</label>
                <input type="text" class="form-control" name="tel" placeholder="555">
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Wann ist es Passiert</label>
                <input type="date" class="form-control" name="date" value="{date}" required>
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Straftat</label>
                <input type="text" class="form-control" name="straftat" placeholder="Straftat" required>
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Vernehmung</label>
                <textarea class="form-control" name="vernehmung" placeholder="Vernehmung"></textarea>
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Aufklärung</label>
                <textarea class="form-control" name="aufklaerung" placeholder="Aufklärung"></textarea>
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Urteil</label>
                <input type="text" class="form-control" name="urteil" placeholder="Urteil" required>
            </div>
            <br>
            <button type="submit" name="createakte" class="btn btn-primary">Speichern</button>
        </form>
        <br><br><br>
        <h1>Neue MD Akte erstellen</h1>
        <form action="index.php?site=akten-create&frac=md" method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" name="name" placeholder="Name" required>
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Geburtstag</label>
                <input type="text" class="form-control" name="gb" placeholder="Geburtstag">
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Telefonnummer</label>
                <input type="text" class="form-control" name="tel" placeholder="555">
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Wann ist es Passiert</label>
                <input type="date" class="form-control" name="date" value="{date}" required>
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Verletzungen</label>
                <input type="text" class="form-control" name="straftat" placeholder="Verletzungen" required>
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Was ist Passiert</label>
                <textarea class="form-control" name="vernehmung" placeholder="Was ist Passiert"></textarea>
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Wie war die Behandlung</label>
                <textarea class="form-control" name="aufklaerung" placeholder="Wie war die Behandlung"></textarea>
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Was muss beachtet werden</label>
                <input type="text" class="form-control" name="urteil" placeholder="Was muss beachtet werden">
            </div>
            <br>
            <button type="submit" name="createakte" class="btn btn-primary">Speichern</button>
        </form>
    </div>
    {endif verwaltung}
    {if not verwaltung}
    <div class="form">
        <h1>Neue Akte erstellen</h1>
        {if pd}
        <form action="index.php?site=akten-create&frac=pd" method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" name="name" placeholder="Name" required>
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Geburtstag</label>
                <input type="text" class="form-control" name="gb" placeholder="Geburtstag">
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Telefonnummer</label>
                <input type="text" class="form-control" name="tel" placeholder="555">
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Wann ist es Passiert</label>
                <input type="date" class="form-control" name="date" value="{date}" required>
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Straftat</label>
                <input type="text" class="form-control" name="straftat" placeholder="Straftat" required>
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Vernehmung</label>
                <textarea class="form-control" name="vernehmung" placeholder="Vernehmung"></textarea>
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Aufklärung</label>
                <textarea class="form-control" name="aufklaerung" placeholder="Aufklärung"></textarea>
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Urteil</label>
                <input type="text" class="form-control" name="urteil" placeholder="Urteil" required>
            </div>
            <br>
            <button type="submit" name="createakte" class="btn btn-primary">Speichern</button>
        </form>
        {endif pd}
        {if not pd}
        <form action="index.php?site=akten-create&frac=md" method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" name="name" placeholder="Name" required>
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Geburtstag</label>
                <input type="text" class="form-control" name="gb" placeholder="Geburtstag">
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Telefonnummer</label>
                <input type="text" class="form-control" name="tel" placeholder="555">
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Wann ist es Passiert</label>
                <input type="date" class="form-control" name="date" value="{date}" required>
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Verletzungen</label>
                <input type="text" class="form-control" name="straftat" placeholder="Verletzungen" required>
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Was ist Passiert</label>
                <textarea class="form-control" name="vernehmung" placeholder="Was ist Passiert"></textarea>
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Wie war die Behandlung</label>
                <textarea class="form-control" name="aufklaerung" placeholder="Wie war die Behandlung"></textarea>
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Was muss beachtet werden</label>
                <input type="text" class="form-control" name="urteil" placeholder="Was muss beachtet werden">
            </div>
            <br>
            <button type="submit" name="createakte" class="btn btn-primary">Speichern</button>
        </form>
        {endif not pd}
    </div>
    {endif not verwaltung}
</div>

</body>
</html>