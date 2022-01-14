<html>
<head>

    <meta charset="utf-8">
    <title>AktenSystem</title>
    <link rel="shortcut icon" type="image/png" href="/img/logo.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login/style.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    <link rel="stylesheet" href="assets/css/bootstap/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <link href="assets/css/bootstap/bootstrap.min.css" rel="stylesheet">
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
    <style>
        .form {
            width: 75%;
            margin: auto;
            background: rgba(18, 17, 17, 0.48);
            padding: 10px 15px;
            border-radius: 10px;
            text-align: center;
        }
    </style>
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
    <div class="form">
        <h1>Daten {id} ändern</h1>
        <form action="index.php?site=vehicle-edit&id={id}" enctype="multipart/form-data" method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1">Kennzeichen</label>
                <input type="text" class="form-control" name="number" value="{number}" placeholder="Kennzeichen" required >
            </div><br>
            <div class="form-group">
                <label for="exampleInputEmail1">Halter</label>
                <input type="text" class="form-control" name="owner" value="{owner}" placeholder="Halter">
            </div><br>
            <div class="form-group">
                <label for="exampleInputEmail1">Telefonnummer</label>
                <input type="number" class="form-control" name="tel" value="{tel}" placeholder="Telefonnummer">
            </div><br>
            <div class="form-group">
                <label for="exampleInputEmail1">Type</label>
                <input type="text" class="form-control" name="type" value="{type}" placeholder="Type">
            </div><br>
            <div class="form-group">
                <label for="exampleInputEmail1">Farbe</label>
                <input type="text" class="form-control" name="color" value="{color}" placeholder="Farbe">
            </div><br>
            <div class="form-group">
                <label for="exampleInputEmail1">Kilometerstand</label>
                <input type="number" class="form-control" value="{km}" name="km">
            </div><br>
            <div class="form-group">
                <label for="exampleInputEmail1">Notizen</label>
                <input type="text" class="form-control" name="note" value="{note}" placeholder="Notizen">
            </div>
            <br>
            <div class="form-group">
                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                    <input type="checkbox" class="btn-check" name="wanted" id="wantedcheck" onclick="wantedtoggle()" {wanted}>
                    <label class="btn btn-outline-primary" for="wantedcheck">Wird gesucht</label>
                </div>
            </div>
            <br><br>
            <div class="form-group" id="wantedtext" style="display: {wantedtext}">
                <label for="exampleInputEmail1">Gesucht für</label>
                <input type="text" class="form-control" name="wantedfor" placeholder="Wanted" value="{wantedfor}">
            </div>
            <br>
            <p><a class="btn btn-danger" href="index.php?site=vehicle">Zurück</a>
                <button type="submit" name="editvehicle" class="btn btn-primary">Speichern</button></p>

        </form>
    </div>
</div>
<script>

    function wantedtoggle() {
        if (document.getElementById("wantedtext").style.display === "none") {
            document.getElementById("wantedtext").style.display = "block";
        } else {
            document.getElementById("wantedtext").style.display = "none";
        }
    }

</script>
</body>
</html>