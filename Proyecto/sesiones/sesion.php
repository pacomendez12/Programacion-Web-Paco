<?php
	//controlador
	//cargar o crear una sesion
	session_start();

	//variable global
	//$_SESSION['blabla'];
	//valido si ya está logueado
	if(isset($_SESSION['usuario'])){
		echo 'ya tienes sesion<br>';
		var_dump($_SESSION);
		echo '<br> <a href="logout.php">cerrar cesion</>';
	}else{
		echo 'necesitas ingresar al sistema';
		echo '<a href="login.php?u=juanito">clic login</a>';
	}
?>