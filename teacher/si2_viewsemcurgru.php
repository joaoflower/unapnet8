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
	include "../include/funcoption.php";
	if(fsafetylogin())
	{
		$bDatos = FALSE;
		if(!empty($_POST['rCod_car']))
		{
			$_SESSION["sSilacod_car"] = $_POST['rCod_car'];
			$vQuery = "select pln_est from plan where cod_car = '{$_POST['rCod_car']}' and con_pln = '1' ";
			$cResult = fQuery2($vQuery);
			if($aResult = mysql_fetch_array($cResult))
			{
				$_SESSION["sSilapln_est"] = $aResult['pln_est'];
				$_SESSION["sSilacod_cur"] = "999";
				$_SESSION["sSilasec_gru"] = "01";
				$_SESSION["sSilamod_mat"] = "01";
				$_SESSION["sSilasem_anu"] = "01";
				$bDatos = TRUE;
			}
		}
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{
		include "si2_viewsemcurgrudata.php";
	}
?>