<html>
<head>
    <title>Install Page 2</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="../assets/css/install/style.css">
</head>
<body>
<section>
</section>
<form class="login-box" action="index.php?page=3" enctype="multipart/form-data" method="post">



    <h1>Install Page: 2</h1>
    <h2>Settings</h2>
    <div class="text-box">
        <i class="fas fa-id-card"></i>
        <input type="text" placeholder="Username" name="user" value="">
    </div>
    <div class="text-box">
        <i class="fas fa-lock" aria-hidden="true" onclick="showhide();" id="toggle"></i>
        <input type="password" placeholder="Password" name="pw" value="" id="password">
    </div>

    <input class="button" type="submit" name="contains" value="Finish" >
</form>
<script type="text/javascript">
    const password = document.getElementById('password');
    const toggle = document.getElementById('toggle');


    function showhide(){
        if(password.type === 'password'){
            password.setAttribute('type','text');
            toggle.setAttribute('class','fas fa-lock-open');

        }else{
            password.setAttribute('type','password');
            toggle.setAttribute('class','fas fa-lock');

        }
    }
</script>
</body>
</html>