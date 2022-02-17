<html>
<head>

    <meta charset="utf-8">
    <title>Akten Teammangagment</title>
    <link rel="shortcut icon" type="image/png" href="/assets/img/logo.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login/style.css">
    <link rel="stylesheet" href="assets/css/bootstap/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css">

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
        function openregisterclick(){
            document.getElementById('register').style.width = '40%';
            document.getElementById('register').style.height = '40%';
        }
    </script>
</head>
<body>
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
</div>
<div class="inter">
    <script type="text/javascript" color="200, 0, 0" opacity="1.6" zindex="-2" count="150" src="http://www.cssscript.com/demo/interactive-particle-nest-system-with-javascript-and-canvas-canvas-nest-js/canvas-nest.js"></script><canvas id="c_n2" width="725" height="913" style="position: fixed; top: 0px; left: 0px; z-index: -2; opacity: 0.7;"></canvas>
    <center>
        <h1>Webinterface von AktenSystem</h1>
        <br>

        <h2>Accounts</h2>
        <br><br><br><br><br>
        <div class="inter" style="width: 70%;position: absolute;top: 55%;left: 50%;transform: translate(-50%, 0%);">
            <table id="Table" class="table table-striped table-dark" style="width: 100%;" data-toggle="table" data-pagination="true"
                   data-search="true">
                <thead>
                <tr>
                    <th scope="col" data-sortable="true" data-field="name">Name</th>
                    <th scope="col" data-sortable="true" data-field="rang">Rang</th>
                    <th scope="col" data-sortable="true" data-field="frac">Fraction</th>
                    <th scope="col" data-field="open">Infos</th>
                </tr>
                </thead>
                <tbody>
                {loop user_loop}
                <tr>
                    <th scope="row">{user_loop_name}</th>
                    <td>{user_loop_rang}</td>
                    <td>{user_loop_fraction}</td>
                    <td><a class="btn btn-primary" href="index.php?site=user-check&name={user_loop_name}">INFO</a></td>
                </tr>
                {/loop user_loop}

                </tbody>
            </table>

        </div>
</div>
<footer class="bg-dark text-center text-white " style="position: fixed;bottom:0; width:100%; height:50px; padding: 7px;">
    <a href="index.php?site=register" class="btn btn-primary">User Hinzufügen</a>
</footer>

</center>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
</body>
</html>