<?php
include (realpath ( "./inc_class.php" ));
$page = "login";

include (PATHSICCLASS . "inmobiliarias_class.php");
$ObjInmobiliarias = new inmobiliarias_class ();
$redir = $_REQUEST ["redir"];
if ($_POST ["action"] == "loginInmobiliaria") {
	$usr = $_POST ["usr"];
	$pass = $_POST ["pass"];
	$ArrayInmobiliarias = $ObjInmobiliarias->isInmobiliaria ( $usr, md5 ( $pass ), $db );
	if (is_object ( $ArrayInmobiliarias )) {
		$_SESSION ["loggedSIC"] = "OK";
		$_SESSION ["idSIC"] = $ArrayInmobiliarias->id;
		$_SESSION ["nombreSIC"] = $ArrayInmobiliarias->nombre;
		$_SESSION ["logoSIC"] = $ArrayInmobiliarias->logo;
		$_SESSION ["usrSIC"] = $ArrayInmobiliarias->usr;
		
		if ($_REQUEST ["redir"]) {
			$page = $_REQUEST ["redir"];
		} else {
			$page = "account.php";
		}
		$goAdmin = "<script>location.href='$page'</script>";
		echo $goAdmin;
	} else {
		$error = '<div class="error">Los datos son incorrectos.<br>Por favor intente nuevamente.</div>';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<title>SIC</title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">
<link rel="stylesheet" href="css/styles.css" type="text/css" media="all">
    <?php
				include ("inc_js.php");
				?>
    <script type="text/javascript">
$().ready(function() {
	$('#wrapper').fadeIn(1000);
});
</script>
</head>
<body id="support">
<!--[if IE 5]><div id="ie5" class="ie"><![endif]-->
<!--[if IE 6]><div id="ie6" class="ie"><![endif]-->
<!--[if IE 7]><div id="ie7" class="ie"><![endif]-->
<div id="wrapper" style="display: none;">
	<?php
	include ("inc_menu.php");
	?>
	<div id="content-wrapper">
<div id="content">
<div class="content-top"></div>
<div class="content">﻿
<div id="top-static">
<div id="top-static-header">
<h1>Login</h1>
<p class="intro">Utilice el siguiente formulario para ingresar al
sistema.</p>

<div class="sidenote">
<h4>Nota</h4>
<p>Deberá proporcionar su usuario y password para ingresar al sistema
SIC. Si usted no esta registrado como inmobiliaria puede registrarse aquí</p>
</div>
</div>

<div id="top-static-main">
<div class="formulario">
<form id="loginSIC" name="loginSIC" action="login.php" method="post"><label>Usuario:</label>
<input name="usr" type="text" id="usr" value="<?php
echo $usr;
?>"
	autocomplete="off" />
<div class="clearfix"></div>
<label>Contraseña:</label><input name="pass" type="password" id="pass"
	autocomplete="off" />
<div class="clearfix"></div>
<input type="hidden" id="action" name="action" value="loginInmobiliaria">
<input type="hidden" id="redir" name="redir"
	value="<?php
	echo $redir;
	?>">
<div style="margin-left: 107px;">
<button id="download_zip" type="submit" class="">Entrar</button>
</div>
<div class="clearfix"></div>
		<?php
		echo $error;
		?>
	</form>
</div>
</div>
<!-- /main -->
					<?php
					include ("inc_sidebar.php");
					?>
				</div>
<!-- top-static --></div>
<!-- class-content--></div>
<!-- id-content --></div>
<!-- content-wrapper -->
	<?php
	include ("inc_footer.php");
	?>
</div>
<!-- wrapper -->
</body>
</html>