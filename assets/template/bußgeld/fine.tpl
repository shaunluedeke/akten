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
  {if hasfine}
  <center>
    <h1>{title}</h1>
    <br><br><br><br><br>
    <div class="inter" style="width: 80%;position: absolute;top: 100px;left: 50%;transform: translate(-50%, 0%);">
      <table id="Table" class="table table-striped table-dark" style="width: 100%;" data-toggle="table" data-pagination="true"
             data-search="true">
        <thead>
        <tr>
          <th scope="col" data-sortable="true" data-field="Akte">Paragraf</th>
          <th scope="col" data-sortable="true" data-field="name">Name</th>
          <th scope="col" data-sortable="true" data-field="date">{money}</th>
          <th scope="col" data-sortable="true" data-field="frac">Fraction</th>
          {if leader}
          <th scope="col" data-sortable="false" data-field="creater">Ändern</th>
          {/if}
        </tr>
        </thead>
        <tbody>
        {loop fine_loop}
        <tr>
          <td>{fine_loop_para}</td>
          <td>{fine_loop_name}</td>
          <td>{fine_loop_fine}</td>
          <td>{fine_loop_frac}</td>
           {fine_loop_leader1}
        </tr>
        {/loop}
        {if leader3}
        <tr aria-sort="none"><td colspan="5" style="text-align: center"><a class="btn btn-success" href="index.php?site=fine-add">Hinzufügen</a></td></tr>
        {/if}
        </tbody>
      </table>
    </div>
  </center>
</div>
{/if}
{if not hasfine}
<div class="login-form" style="text-align: center;">
  <h3 style="color: black">Es gibt keine Bußgelder!</h3>
  <br><br><br><br><br><br>
  {if leader2}
  <a class="btn btn-success" href="index.php?site=fine-add">Hinzufügen</a>
  {/if}
  <a class="btn btn-danger" href="index.php">Zurück</a>
</div>
{/if not}

</div>
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
</body>
</html>