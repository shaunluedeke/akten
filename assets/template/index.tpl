<!DOCTYPE html>
<html lang="de">
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/login.css">
</head>
<body>
<main>

    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>Login</h3>
                </div>
                <div class="card-body">
                    <br />
                    <form action="index.php" method="post">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" name="usernam" required placeholder="username">
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend hover" onclick="togglepw()">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" id="pw" class="form-control" name="Passord" required placeholder="password">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Login" name="logi" class="btn float-right login_btn">
                        </div>
                        <a href="https://discord.gg/ErVrEfSuvz" target="_blank" class="btn btn_success">Discord Server</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>