<?php
	session_start();
	include "../include/funcget.php";
	include "../include/funcsql.php";

	if(fsafetylogin())
	{
		$vQuery = "select * from unap.picture2 where num_mat = '{$_SESSION['sUsercod_usu']}' and cod_car = '{$_SESSION['sUsercod_car']}' ";
		//$vConsulta = "SELECT tipo, contenido, archivo FROM unap.picture WHERE num_mat = '" .$ar_UnapNet['Num_Foto']. "'";

		$cr_imagen = fQuery($vQuery);
		$tipo      = mysql_result($cr_imagen, 0, "tipo");
		$contenido = mysql_result($cr_imagen, 0, "contenido");
		$nombre    = mysql_result($cr_imagen, 0, "archivo");

		header("Content-type: $tipo");
		header("Content-Disposition: ; filename=\"$nombre\"");
		echo $contenido;
	}
?>
