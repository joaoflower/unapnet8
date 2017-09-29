<?
	session_start();
	include "../include/funcget.php";
	include "../include/funcsql.php";
	include "../include/funcstyle.php";
	include "../include/funcoption.php";
	if(fsafetylogin())
	{
		$bDatos = FALSE;
		if(!empty($_POST['rSem_anu']))
		{
			$_SESSION["sSilasem_anu"] = $_POST['rSem_anu'];
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
				<select name="rCod_cur" id="rCod_cur" onchange="sil_viewmencion(this.value); return false;">
					<?=fviewsicurso($_SESSION["sSilacod_car"], $_SESSION["sSilapln_est"], $_SESSION["sSilasem_anu"], $_SESSION["sSilacod_cur"])?>
			      </select>
<?	
	}
?>