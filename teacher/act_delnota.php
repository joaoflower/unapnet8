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

		if(!empty($_POST['rTip_ord']))
		{
			$vTip_not = substr($_POST['rTip_ord'], 0, 1);
			$vOrd_not = substr($_POST['rTip_ord'], 1, 1);
			
			$tNota = "notaca".$_SESSION["sActacod_car"].$_SESSION['sFrameano_aca'];
			$tCurmat = "curmat".$_SESSION["sActacod_car"].$_SESSION['sFrameano_aca'];
			$tApla = "apla".$_SESSION['sFrameano_aca'];
			
			if($_SESSION['sActamod_mat'] != '02' and $_SESSION['sActamod_mat'] != '08' )
			{
				$vQuery = "delete from $tNota ";
				$vQuery .= "where pln_est = '{$_SESSION['sActapln_est']}' and ";
				$vQuery .= "cod_cur = '{$_SESSION['sActacod_cur']}' and per_aca = '{$_SESSION['sFrameper_aca']}' and ";
				$vQuery .= "ano_aca = '{$_SESSION['sFrameano_aca']}' and mod_not != '02' and mod_not != '08' and ";
				$vQuery .= "cod_car = '{$_SESSION['sActacod_car']}' and tip_not = '$vTip_not' and ";
				$vQuery .= "ord_not = '$vOrd_not' and num_mat in ";
				$vQuery .= "(Select num_mat from $tCurmat where per_aca = '{$_SESSION['sFrameper_aca']}' and ";
				$vQuery .= "pln_est = '{$_SESSION['sActapln_est']}' and cod_cur = '{$_SESSION['sActacod_cur']}' and ";
				$vQuery .= "sec_gru = '{$_SESSION['sActasec_gru']}')";
			}
			else
			{
				$vQuery = "delete from $tNota ";
				$vQuery .= "where pln_est = '{$_SESSION['sActapln_est']}' and ";
				$vQuery .= "cod_cur = '{$_SESSION['sActacod_cur']}' and per_aca = '{$_SESSION['sFrameper_aca']}' and ";
				$vQuery .= "ano_aca = '{$_SESSION['sFrameano_aca']}' and mod_not = '{$_SESSION['sActamod_mat']}' and ";
				$vQuery .= "cod_car = '{$_SESSION['sActacod_car']}' and tip_not = '$vTip_not' and ";
				$vQuery .= "ord_not = '$vOrd_not' and num_mat in ";
				$vQuery .= "(Select num_mat from $tCurmat where per_aca = '{$_SESSION['sFrameper_aca']}' and ";
				$vQuery .= "pln_est = '{$_SESSION['sActapln_est']}' and cod_cur = '{$_SESSION['sActacod_cur']}' and ";
				$vQuery .= "sec_gru = '{$_SESSION['sActasec_gru']}')";
			}
			
			$cResult = fInupde2($vQuery);
			
		}		
		include "act_viewestunota.php";
	}
	else
	{
		header("Location:../index.php");
	}
?>