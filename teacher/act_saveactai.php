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
		$tIngnota = "ingnota".$_SESSION['sFrameano_aca'];
			
		$vQuery = "update $tIngnota set ingresado = 'T' ";
		$vQuery .= "where pln_est = '{$_SESSION['sActacod_esp']}' and cod_cur = '{$_SESSION['sActacod_cur']}' and ";
		$vQuery .= "sec_gru = '{$_SESSION['sActacod_sec']}' and mod_mat = '{$_SESSION['sActamod_mat']}' and ";
		$vQuery .= "cod_car = '{$_SESSION['sActacod_car']}' and ano_aca = '{$_SESSION['sFrameano_acai']}' and ";
		$vQuery .= "per_aca = '{$_SESSION['sFramecod_mesi']}' ";
		
		$cResult = fInupde($vQuery);
		if($cResult)
		{
			$_SESSION["sActaingresado"] = 'T';
		}
			
		include "act_viewestunotai.php";
	}
	else
	{
		header("Location:../index.php");
	}
?>