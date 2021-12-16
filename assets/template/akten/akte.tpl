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
        <a href="index.php?site=pw-edit">Password Ändern</a>
        <a href="index.php?site=logout">Logout</a>

    </div>
        <div class="login-form" style="height: 90%; width: 60%; background: #3e3c3c; text-align: center;">
            {if pd}
            <h2>PD Akte</h2><br>
            <table class="table table-responsive-lg table-bordered table-dark">
                <tbody>
                    <tr>
                        <th scope="row">ID</th>
                        <td>{id}</td>
                    </tr>
                    <tr>
                        <th scope="row">Name</th>
                        <td>{name}</td>
                    </tr>
                    <tr>
                        <th scope="row">Datum</th>
                        <td>{date}</td>
                    </tr>
                    <tr>
                        <th scope="row">Einreise datum</th>
                        <td>{gb}</td>
                    </tr>
                    <tr>
                        <th scope="row">Durchwahl</th>
                        <td>{tel}</td>
                    </tr>
                    <tr>
                        <th scope="row">Straftat</th>
                        <td>{straftat}</td>
                    </tr>
                    <tr>
                        <th scope="row">Vernehmung</th>
                        <td>{vernehmung}</td>
                    </tr>
                    <tr>
                        <th scope="row">Aufklärung</th>
                        <td>{aufklarung}</td>
                    </tr>
                    <tr>
                        <th scope="row">Urteil</th>
                        <td>{urteil}</td>
                    </tr>
                </tbody>
            </table>
            <h3><b>Wurde von</b> {creator} <b>erstellt</b></h3>
            {endif pd}
            {if not pd}
            <h2>MD Akte</h2><br>
            <table class="table table-responsive-lg table-bordered table-dark">
                <tbody>
                <tr>
                    <th scope="row">ID</th>
                    <td>{id}</td>
                </tr>
                <tr>
                    <th scope="row">Name</th>
                    <td>{name}</td>
                </tr>
                <tr>
                    <th scope="row">Datum</th>
                    <td>{date}</td>
                </tr>
                <tr>
                    <th scope="row">Geburtstag</th>
                    <td>{gb}</td>
                </tr>
                <tr>
                    <th scope="row">Durchwahl</th>
                    <td>{tel}</td>
                </tr>
                <tr>
                    <th scope="row">Verletzungen</th>
                    <td>{straftat}</td>
                </tr>
                <tr>
                    <th scope="row">Was ist Passiert</th>
                    <td>{vernehmung}</td>
                </tr>
                <tr>
                    <th scope="row">Wie war die Behandlung</th>
                    <td>{aufklarung}</td>
                </tr>
                <tr>
                    <th scope="row">Was muss beachtet werden</th>
                    <td>{urteil}</td>
                </tr>
                </tbody>
            </table>
            <h3><b>Wurde von</b> {creator} <b>erstellt</b></h3>
            {endif not pd}

           <p><a class="btn btn-success" href="index.php?site=akten-edit&id={id}">Akte ändern</a>  {if rang}<a class="btn btn-warning" href="index.php?site=akten-delete&id={id}">Akte Löschen</a>{endif rang}</p>
            <a class="btn btn-danger" href="index.php?site=akten-all">Zurück</a>
        </div>
    </div>

</body>
<script type="text/javascript">
    $(".num").counterUp({delay:10,time:1000});
</script>
</html>