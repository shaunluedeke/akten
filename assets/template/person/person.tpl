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
        .dead{
            animation-name: deadani;
            animation-duration: 1500ms;
            animation-iteration-count: infinite;
            box-shadow: 0 0 50px 4px #ff2f2f;
        }
        @keyframes deadani {
            0%{
                box-shadow: 0 0 50px 4px #8a8a8a,0 0 20px 2px #8a8a8a;
            }
            50%{
                box-shadow: 0 0 50px 4px #555555,0 0 20px 2px #555555;
            }
            100%{
                box-shadow: 0 0 50px 4px #8a8a8a,0 0 20px 2px #8a8a8a;
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
        <a href="index.php?site=pw-edit">Password Ändern</a>
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
                    <th scope="col" data-sortable="true" data-field="name">Name</th>
                    <th scope="col" data-sortable="true" data-field="date">Einreise Datum</th>
                    <th scope="col" data-sortable="true" data-field="creater">GESUCHT</th>
                    <th scope="col" data-field="open1">Erstellen</th>
                    <th scope="col" data-field="open">&Ouml;ffnen</th>
                </tr>
                </thead>
                <tbody>
                {loop person_loop}
                <tr>
                    <th scope="row">{person_loop_id}</th>
                    <td>{person_loop_name}</td>
                    <td>{person_loop_date}</td>
                    <td>{person_loop_wanted}</td>
                    <td><a class="btn btn-success" href="index.php?site=akten-create&person={person_loop_id}">Akte Erstellen</a>
                    <td><a class="btn btn-primary" href="index.php?site=person&id={person_loop_id}">Daten &Ouml;ffnen</a>
                    </td>
                </tr>
                {/loop}
                <tr aria-sort="none"><td colspan="6" style="text-align: center"><a class="btn btn-success" href="index.php?site=person-add">Hinzufügen</a></td></tr>
                </tbody>
            </table>
        </div>
    </center>
</div>
{/if}
{if not hasperson}
        <div id="content">
                <div class="login-form {pstate}" style="text-align: center;height: 90%; width: 60%; background: #3e3c3c; ">
                <h2>Name: {name}</h2><br>
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
                        <th scope="row">Einreise Datum</th>
                        <td>{birthday}</td>
                    </tr>
                    <tr>
                        <th scope="row">Telefon Nummer</th>
                        <td>{tel}</td>
                    </tr>

                    <tr>
                        <th scope="row">Adresse</th>
                        <td>{adress}</td>
                    </tr>
                    <tr>
                        <th scope="row">Fraction</th>
                        <td>{frac}</td>
                    </tr>
                    {if wanted}
                    <tr>
                        <th scope="row">Wird gesucht für</th>
                        <td>{wantedfor}</td>
                    </tr>
                    {/if}
                    <tr>
                        <th scope="row">Documente</th>
                        <td>{files}</td>
                    </tr>
                    {if hasakte}
                    <tr>
                        <th scope="row">Akten</th>
                        <td>{akte}</td>
                    </tr>
                    {/if}
                    </tbody>
                </table>
                    {if dead}
                        <h2>Diese Person ist verstorben</h2>
                    {/if}
                    {if wanted1}
                    <h2>Diese Person wird gesucht</h2>
                    {/if}
                    <p><a class="btn btn-success" href="index.php?site=person-edit&id={id}">Daten ändern</a></p>
                <a class="btn btn-danger" href="index.php?site=person">Zurück</a>
            </div>
        </div>
{/if not}

</div>
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
</body>
</html>