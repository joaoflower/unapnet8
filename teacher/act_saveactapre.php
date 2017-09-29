<STYLE type=text/css>
@import url( ../css/main.css );
@import url( ../css/frame.css );
@import url( ../css/framelogin.css );
@import url( ../css/style.css );
</STYLE>

<?
	session_start();
	include "../include/funcget.php";
	include "../include/funcsql.php";
	include "../include/funcstyle.php";
	if(fsafetylogin())
	{
		$bDatos = FALSE;
		$bDatos = TRUE;
	}
	else
	{
		header("Location:../index.php");
	}
	if($bDatos == TRUE)
	{
?>
	<span class="wordi">DESPUES DE GUARDAR EL ACTA NO PODRAS AGREGAR, <br />
			ELIMINAR O MODIFICAR NOTAS.<br />
			LOS ESTUDIANTES PODRAN VER LAS NOTAS QUE INGRESASTE. <br />
			¿ ESTAS SEGURO QUE DESEAS GUARDAR LAS NOTAS DEL ACTA ?</span>
	<table border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td>
					<div class="dboton"><a href="" onClick = "act_saveacta(); return false;" class="iok" title="Aceptar">Aceptar</a></div>
					<div class="dboton"><a href="" onClick = "act_cancelnota();  return false;" class="icancel" title="Cancelar">Cancelar</a></div>
				</td>
			  </tr>
	</table>
<?
	}
?>