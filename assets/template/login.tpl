<html>
<head>

    <meta charset="utf-8">
    <title>AktenSystem</title>
    <link rel="shortcut icon" type="image/png" href="/img/logo.png">
    <link rel="stylesheet" href="assets/css/login/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js"></script>
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
        <a href="#">Home</a>
        <a href="index.php?site=fine">Bußgelder</a>
        <a href="index.php?site=pw-edit">Password Ändern</a>
        {if teamsite}
        <a href="index.php?site=team">Team</a>
        {/if teamsite}
        <a href="index.php?site=logout">Logout</a>


    </div>
    <div class="inter">
        <center>
            <h1>Webinterface von AktenSystem</h1>
            <br><br>
            <br>

            <div class="hover-table-layout"
                 style="width: 100%;position: absolute;top: 30%;left: 60%;transform: translate(-50%, 0%);">
                <div class="listing-item">
                    <figure class="image">
                        <img src="assets/img/akten.jpg" alt="Akten ansehen" height="220px"/>
                        <figcaption>
                            <div class="caption">
                                <h1>Person ankucken</h1>
                            </div>
                        </figcaption>
                    </figure>
                    <div class="listing">
                        <h3>Sehe alle Leute an</h3>
                        <a href="index.php?site=person" class="logbtn">Alle ansehen</a>
                    </div>
                </div>
                <div class="listing-item">
                    <figure class="image">
                        <img src="assets/img/akten.jpg" alt="Akten ansehen" height="220px"/>
                        <figcaption>
                            <div class="caption">
                                <h1>Bußgelder ankucken</h1>
                            </div>
                        </figcaption>
                    </figure>
                    <div class="listing">
                        <h3>Sehe alle aktuellen Preise</h3>
                        <a href="index.php?site=fine" class="logbtn">Alle ansehen</a>
                    </div>
                </div>

                <div class="listing-item">
                    <figure class="image">
                        <img src="assets/img/akten.jpg" alt="Akten ansehen" height="220px"/>
                        <figcaption>
                            <div class="caption">
                                <h1>Akten ansehen</h1>
                            </div>
                        </figcaption>
                    </figure>
                    <div class="listing">
                        <h3>Soviele wurden schon erstellt!</h3>
                        <h3 class="num">{allakten}</h3>
                        <a href="index.php?site=akten-all" class="logbtn">Alle ansehen</a>
                    </div>
                </div>

                <div class="listing-item">
                    <figure class="image">
                        <img src="assets/img/akten.jpg" alt="Akten ansehen" height="220px"/>
                        <figcaption>
                            <div class="caption">
                                <h1>Akten erstellen</h1>
                            </div>
                        </figcaption>
                    </figure>
                    <div class="listing">
                        <h3>Erstelle eine Neue Akte!</h3>
                        <h3>Was hat der schuft gemacht</h3>
                        <a href="index.php?site=akten-create" class="logbtn">Akte Erstellen</a>
                    </div>
                </div>
                <br>

                <div class="listing-item">
                    <figure class="image">
                        <img src="assets/img/akten.jpg" alt="Akten ansehen" height="220px"/>
                        <figcaption>
                            <div class="caption">
                                <h1>Fahrzeuge ankucken</h1>
                            </div>
                        </figcaption>
                    </figure>
                    <div class="listing">
                        <h3>Sehe alle Fahrzeuge an</h3>
                        <a href="index.php?site=vehicle" class="logbtn">Alle ansehen</a>
                    </div>
                </div>

            </div>
        </center>
    </div>

</body>
</html>