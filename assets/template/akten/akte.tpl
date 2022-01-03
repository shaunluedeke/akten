<html>
<head>

    <meta charset="utf-8">
    <title>AktenSystem</title>
    <link rel="shortcut icon" type="image/png" href="/img/logo.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login/style.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <link href="assets/css/bootstap/bootstrap.min.css" rel="stylesheet">
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
        <div class="login-form" style="height: 90%; width: 60%; background: #3e3c3c; text-align: center;">
            <h2>{aktenname}</h2><br>
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
                    {loop akten_loop}
                    <tr>
                        <th scope="row">{akten_loop_key}</th>
                        <td>{akten_loop_value}</td>
                    </tr>
                    {/loop}
                </tbody>
            </table>
            <h3><b>Wurde von</b> {creator} <b>erstellt</b></h3>
            <h3>{release}</h3><br>
            {if released}
                <p><a class="btn btn-success" href="index.php?site=akten-edit&id={id}">Akte ändern</a>  {if rang}<a class="btn btn-warning" href="index.php?site=akten-delete&id={id}">Akte Löschen</a>{/if}</p>

            <a class="btn btn-danger" href="index.php?site=akten-all">Zurück</a>
        </div>
    </div>

</body>
</html>