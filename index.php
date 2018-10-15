<?php
	require('conexion.php');
	session_start();
	if(isset($_SESSION["id_usuario"])){
		header("Location: semestre.php");
	}
	if(!empty($_POST))
	{
		$usuario = mysqli_real_escape_string($mysqli,$_POST['usuario']);
		$password = mysqli_real_escape_string($mysqli,$_POST['clave']);
		$error = '';
		$sql = "SELECT IdUA,IDAlumno,Clave,Estado FROM Tbl_usuario_alumno WHERE IDAlumno = '$usuario' AND Clave = '$password' AND Estado='01'";
		//, id_tipo
		$result=$mysqli->query($sql);
		$rows = $result->num_rows;
		if($rows > 0) {
			$row = $result->fetch_assoc();
			$_SESSION['id_usuario'] = $row['IdUA'];
			header("location: semestre.php");
			} else {
			$error = "El nombre o contrase&ntilde;a son incorrectos";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link href="img/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link rel="stylesheet" href="css/login.css">
    <title>Upein</title>
    <link href="img/favicon.ico" rel="shortcut icon" type="image/x-icon">
</head>
<body>
<div style="height:100vh;background:url('img/upeinfondo.jpg');background-size:100% 100%;">
    <div id="login" class="container">
        <div class="row-fluid">
            <div class="span12">
                <div class="login well well-small">
                    <div class="center">
                        <img src="img/logo_upein.png" alt="logo"> 
                    </div>
                    <form action="<?php $_SERVER['PHP_SELF']; ?>" style="" class="login-form" id="UserLoginForm" method="post" accept-charset="utf-8" autocomplete="off">
                        <div class="control-group">
                            <div class="input-prepend">
                                <span class="add-on"><i class="icon-user"></i></span>
                                <input name="usuario" required="required" placeholder="Username" maxlength="255" type="text" id="UserUsername"> 
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="input-prepend">
                                <span class="add-on"><i class="icon-lock"></i></span>
                                <input name="clave" required="required" placeholder="Password" type="password" id="UserPassword"> 
                            </div>
                        </div>
                        <div class="control-group">
                            <input class="btn btn-primary btn-large btn-block" type="submit" value="Sign in"> 
                        </div>
                    </form>
                </div><!--/.login-->
            </div><!--/.span12-->
        </div><!--/.row-fluid-->
    </div>
</div>
</body>
</html>

