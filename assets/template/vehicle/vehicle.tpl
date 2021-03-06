<html>
<head>

    <meta charset="utf-8">
    <title>AktenSystem</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css">

    <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <link href="assets/css/bootstap/bootstrap.min.css" rel="stylesheet">

    <style>

        .wanted{
            animation-name: wantedani;
            animation-duration: 1500ms;
            animation-iteration-count: infinite;
            box-shadow: 0 0 50px 4px #0ff;
        }
        @keyframes wantedani {
            0%{
                box-shadow: 0 0 50px 4px #0ff,0 0 20px 2px #0ff;
            }
            50%{
                box-shadow: 0 0 50px 4px #ff2f2f,0 0 20px 2px #ff2f2f;
            }
            100%{
                box-shadow: 0 0 50px 4px #0ff,0 0 20px 2px #0ff;
            }
        }
    </style>

    <script>
        function openSlideMenu() {
            document.getElementById('menu').style.width = '250px';
            document.getElementById('content').style.marginLeft = '250px';
        }

        function closeSlideMenu() {
            document.getElementById('menu').style.width = '0';
            document.getElementById('content').style.marginLeft = '0';
        }
    </script>
</head>
<body>
<script type="text/javascript" color="200, 0, 0" opacity="1.6" zindex="-2" count="150"
        src="http://www.cssscript.com/demo/interactive-particle-nest-system-with-javascript-and-canvas-canvas-nest-js/canvas-nest.js"></script>
<canvas id="c_n2" width="725" height="913"
        style="position: fixed; top: 0px; left: 0px; z-index: -2; opacity: 0.7;"></canvas>
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
        <a href="index.php?site=pw-edit">Password ??ndern</a>
        <a href="index.php?site=logout">Logout</a>


    </div>
    {if hasperson}
    <center>
        <h1>Webinterface von AktenSystem</h1>
        <br><br><br><br><br>
        <div class="inter" style="width: 80%;position: absolute;top: 100px;left: 50%;transform: translate(-50%, 0%);">
            <table id="Table" class="table table-striped table-dark" style="width: 100%;" data-toggle="table"
                   data-pagination="true"
                   data-search="true">
                <thead>
                <tr>
                    <th scope="col" data-sortable="true" data-field="Akte">ID</th>
                    <th scope="col" data-sortable="true" data-field="name">Kennzeichen</th>
                    <th scope="col" data-sortable="true" data-field="date">Type</th>
                    <th scope="col" data-sortable="true" data-field="creater">GESUCHT</th>
                    <th scope="col" data-field="open1">Erstellen</th>
                    <th scope="col" data-field="open">&Ouml;ffnen</th>
                </tr>
                </thead>
                <tbody>
                {loop vehicle_loop}
                <tr>
                    <th scope="row">{vehicle_loop_id}</th>
                    <td>{vehicle_loop_number}</td>
                    <td>{vehicle_loop_type}</td>
                    <td>{vehicle_loop_wanted}</td>
                    <td><a class="btn btn-success" href="index.php?site=akten-create&vehicle={vehicle_loop_id}">Akte Erstellen</a>
                    <td><a class="btn btn-primary" href="index.php?site=vehicle&id={vehicle_loop_id}">Daten &Ouml;ffnen</a>
                    </td>
                </tr>
                {/loop vehicle_loop}
                <tr aria-sort="none"><td colspan="6" style="text-align: center"><a class="btn btn-success" href="index.php?site=vehicle-add">Hinzuf??gen</a></td></tr>
                </tbody>
            </table>
        </div>
    </center>
</div>
{/if hasperson}
{if not hasperson}
        <div id="content">
                <div class="login-form {pstate}" style="text-align: center;height: 90%; width: 60%; background: #3e3c3c; ">
                <h2>Kennzeichen: {number}</h2><br>
                <table class="table table-responsive-lg table-bordered table-dark">
                    <tbody>
                    <tr>
                        <th scope="row">ID</th>
                        <td>{id}</td>
                    </tr>
                    <tr>
                        <th scope="row">Kennzeichen</th>
                        <td>{number}</td>
                    </tr>
                    <tr>
                        <th scope="row">Halter</th>
                        {if ownerindatabase}<td><a href="index.php?site=person&id={ownerid}">{owner}</a></td>{/if ownerindatabase}
                        {if not ownerindatabase}<td>{owner}</td>{/if not ownerindatabase}
                    </tr>
                    <tr>
                        <th scope="row">Telefonnummer</th>
                        <td>{tel}</td>
                    </tr>

                    <tr>
                        <th scope="row">Type</th>
                        <td>{type}</td>
                    </tr>
                    <tr>
                        <th scope="row">Farbe</th>
                        <td>{color}</td>
                    </tr>
                    <tr>
                        <th scope="row">Kilometerstand</th>
                        <td>{km}</td>
                    </tr>
                    {if wanted}
                    <tr>
                        <th scope="row">Wird gesucht f??r</th>
                        <td>{wantedfor}</td>
                    </tr>
                    {/if wanted}
                    {if hasakte}
                        <tr>
                            <th scope="row">Akten</th>
                            <td>{akte}</td>
                        </tr>
                    {/if hasakte}
                    <tr>
                        <th scope="row">Notiz</th>
                        <td>{note}</td>
                    </tr>
                    </tbody>
                </table>
                    {if wanted1}
                    <h2>Dieses Auto wird gesucht</h2>
                    {/if wanted1}
                    <p><a class="btn btn-success" href="index.php?site=vehicle-edit&id={id}">Daten ??ndern</a></p>
                <a class="btn btn-danger" href="index.php?site=vehicle">Zur??ck</a>
            </div>
        </div>
{/if not hasperson}

</div>
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
</body>
</html>