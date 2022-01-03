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
        <form action="index.php?site=person-edit&id={id}" enctype="multipart/form-data" method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" name="name" placeholder="Name" required value="{name}">
            </div><br>
            <div class="form-group">
                <label for="exampleInputEmail1">Geburtsdatum</label>
                <input type="date" class="form-control" name="gb" placeholder="Geburtsdatum" value="{gb}">
            </div><br>
            <div class="form-group">
                <label for="exampleInputEmail1">Telefonnummer</label>
                <input type="text" class="form-control" name="tel" placeholder="Telefonnummer" value="{tel}">
            </div><br>
            <div class="form-group">
                <label for="exampleInputEmail1">Adresse</label>
                <input type="text" class="form-control" name="adress" placeholder="Adresse" value="{adress}">
            </div><br>
            <div class="form-group">
                <label for="exampleInputEmail1">Fraction</label>
                <input type="text" class="form-control" name="frac" placeholder="Fraction" value="{frac}">
            </div><br>
            <div class="form-group">
                <label for="exampleInputEmail1">Licensen</label>
                <input type="text" class="form-control" name="license" placeholder="Licensen" value="{license}">
            </div><br>
            <div class="form-group">
                <label for="exampleInputEmail1">New Files</label>
                <input type="file" class="form-control" name="files[]" multiple>
            </div>
            <br>
            <div class="form-group">
                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                    <input type="checkbox" class="btn-check" name="wanted" id="wantedcheck" onclick="wantedtoggle()" {wanted}>
                    <label class="btn btn-outline-primary" for="wantedcheck">Wird gesucht</label>

                    <input type="checkbox" class="btn-check" name="alive" id="btncheck2" {alive}>
                    <label class="btn btn-outline-secondary" for="btncheck2">Am Leben</label>
                </div>
            </div>
            <br><br>
            <div class="form-group" id="wantedtext" style="display: {wantedtext}">
                <label for="exampleInputEmail1">Gesucht für</label>
                <input type="text" class="form-control" name="wantedfor" placeholder="Wanted" value="{wantedfor}">
            </div>
            <br>
            <p><a class="btn btn-danger" href="index.php?site=person">Zurück</a>
                <button type="submit" name="editperson" class="btn btn-primary">Speichern</button></p>

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