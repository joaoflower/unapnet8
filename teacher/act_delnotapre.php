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
		if(!empty($_POST['rTip_ord']))
		{
			$vTip_not = substr($_POST['rTip_ord'], 0, 1);
			$vOrd_not = substr($_POST['rTip_ord'], 1, 1);
			$bDatos = TRUE;
		}		
	}
	else
	{
		header("Location:../index.php");
	}
		if($bDatos == TRUE)
	{
?>
	<span class="wordi">¿ ESTAS SEGURO QUE DESEAS ELIMINAR LA <strong><?=($vTip_not=='C'?'CAPACIDAD':'ACTITUD')?> - <?=$vOrd_not?></strong> ?</span>
	<table border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td>
					<div class="dboton"><a href="" onClick = "act_delnota('<?=$_POST['rTip_ord']?>'); return false;" class="iok" title="Aceptar">Aceptar</a></div>
					<div class="dboton"><a href="" onClick="act_cancelnota();  return false;" class="icancel" title="Cancelar">Cancelar</a></div>
				</td>
			  </tr>
			</table>
<?
	}
?>