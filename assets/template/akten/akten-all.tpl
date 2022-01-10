<html>
<head>

    <meta charset="utf-8">
    <title>AktenSystem</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login/style.css">
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
    {if hasakten}
    <center>
        <h1>Webinterface von AktenSystem</h1>
        <br><br><br><br><br>
        <div class="inter" style="width: 80%;position: absolute;top: 100px;left: 50%;transform: translate(-50%, 0%);">
            <table id="Table" class="table table-striped table-dark" style="width: 100%;" data-toggle="table" data-pagination="true"
                   data-search="true">
                <thead>
                <tr>
                    <th scope="col" data-sortable="true" data-field="Akte">Akte</th>
                    <th scope="col" data-sortable="true" data-field="name">Name</th>
                    <th scope="col" data-sortable="true" data-field="date">Datum</th>
                    <th scope="col" data-sortable="true" data-field="creater">Ersteller</th>
                    <th scope="col" data-sortable="true" data-field="frac">Fraction</th>
                    <th scope="col" data-field="open">&Ouml;ffnen</th>
                </tr>
                </thead>
                <tbody>
                {loop akten_loop}
                <tr>
                    <th scope="row">{akten_loop_id}</th>
                    <td>{akten_loop_name}</td>
                    <td>{akten_loop_date}</td>
                    <td>{akten_loop_creator}</td>
                    <td>{akten_loop_frac}</td>
                    <td><a class="btn btn-primary" href="index.php?site=akte&id={akten_loop_id}">Akte &Ouml;ffnen</a></td>
                </tr>
                {/loop akten_loop}
                </tbody>
            </table>
        </div>
            </center>
    </div>
    {/if hasakten}
    {if not hasakten}
    <div class="login-form" style="text-align: center;">
        <h3 style="color: black">Es gibt keine Akten!</h3>
        <br><br><br><br><br><br>
        <a class="btn btn-danger" href="index.php">Zurück</a>
    </div>
    {/if not hasakten}

</div>
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
<script type="text/javascript">

    function togglesidebar() {
        var sidebarbig = document.getElementById("sidebarbig");
        var sidebarsmall = document.getElementById("sidebarsmall");
        if(sidebarbig.classList.contains("close")){
            sidebarbig.classList.replace("close","open");
            sidebarsmall.classList.replace("open","close");
        }else{
            sidebarbig.classList.replace("open","close");
            sidebarsmall.classList.replace("close","open");
        }
    }
</script>
</body>
</html>