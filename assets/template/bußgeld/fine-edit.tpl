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
    <h1>{title}</h1>
    <form action="index.php?site=fine-edit" method="POST">
      <div class="form-group">
        <label for="exampleInputEmail1">ID</label>
        <input type="text" class="form-control" name="id" value="{id}" readonly required>
      </div>
      <br>
      <div class="form-group">
        <label for="exampleInputEmail1">Paragraf</label>
        <input type="text" class="form-control" name="paragraf" value="{paragraf}" placeholder="Paragraf" required>
      </div>
      <br>
      <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input type="text" class="form-control" name="name" value="{name}" placeholder="Name" required>
      </div>
      <br>
      <div class="form-group">
        <label for="exampleInputEmail1">{money}</label>
        <input type="text" class="form-control" name="geld" value="{geld}" placeholder="Strafe" required>
      </div>
      <br>
      <div class="form-group">
        <label for="exampleInputEmail1">Katerogie</label>
        <input type="text" class="form-control" name="cat" placeholder="Katerogie">
      </div>
      <br>
      <br>
      <button type="submit" name="editfine" class="btn btn-primary">Speichern</button>
    </form>
  </div>
</div>
<script type="application/javascript">
  function openSlideMenu() {
    document.getElementById('menu').style.width = '250px';
    document.getElementById('content').style.marginLeft = '250px';
  }

  function closeSlideMenu() {
    document.getElementById('menu').style.width = '0';
    document.getElementById('content').style.marginLeft = '0';
  }
</script>
</body>
</html>