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
		$tIngnota = "ingnota".$_SESSION['sFrameano_aca'];
		if($_SESSION["sActacaiu"] == 'i')
		{
			$vQuery = "insert into $tIngnota (pln_est, cod_cur, sec_gru, mod_mat, cod_car, ano_aca, per_aca, can_cap, can_act,  ";
			$vQuery .= "cap1, cap2, cap3, cap4, cap5, cap6, act1, act2, act3, act4, fch_ing, ingresado ) values ";
			$vQuery .= "('{$_SESSION['sActapln_est']}', '{$_SESSION['sActacod_cur']}', '{$_SESSION['sActasec_gru']}', ";
			$vQuery .= "'{$_SESSION['sActamod_mat']}', '{$_SESSION['sActacod_car']}', '{$_SESSION['sFrameano_aca']}', ";
			$vQuery .= "'{$_SESSION['sFrameper_aca']}', '{$_SESSION['sActacan_cap2']}', '{$_SESSION['sActacan_act2']}', ";
			$vQuery .= "'{$_POST['rCap1']}', '{$_POST['rCap2']}', '{$_POST['rCap3']}', '{$_POST['rCap4']}', '{$_POST['rCap5']}', ";
			$vQuery .= "'{$_POST['rCap6']}', '{$_POST['rAct1']}', '{$_POST['rAct2']}', '{$_POST['rAct3']}', '{$_POST['rAct4']}', ";
			$vQuery .= "now(), 'F') ";

			$cResult = fInupde2($vQuery);
			$bDatos = TRUE;
		}
		elseif($_SESSION["sActacaiu"] == 'u')
		{
			$vQuery = "update $tIngnota set can_cap = '{$_SESSION['sActacan_cap2']}', can_act = '{$_SESSION['sActacan_act2']}', ";
			$vQuery .= "cap1 = '{$_POST['rCap1']}', cap2 = '{$_POST['rCap2']}', cap3 = '{$_POST['rCap3']}', ";
			$vQuery .= "cap4 = '{$_POST['rCap4']}', cap5 = '{$_POST['rCap5']}', cap6 = '{$_POST['rCap6']}', ";
			$vQuery .= "act1 = '{$_POST['rAct1']}', act2 = '{$_POST['rAct2']}', act3 = '{$_POST['rAct3']}', ";
			$vQuery .= "act4 = '{$_POST['rAct4']}' ";
			$vQuery .= "where pln_est = '{$_SESSION['sActapln_est']}' and cod_cur = '{$_SESSION['sActacod_cur']}' and ";
			$vQuery .= "sec_gru = '{$_SESSION['sActasec_gru']}' and mod_mat = '{$_SESSION['sActamod_mat']}' and ";
			$vQuery .= "cod_car = '{$_SESSION['sActacod_car']}' and ano_aca = '{$_SESSION['sFrameano_aca']}' and ";
			$vQuery .= "per_aca = '{$_SESSION['sFrameper_aca']}' ";
			
			$cResult = fInupde2($vQuery);
			$bDatos = TRUE;
		}
		else
		{
			header("Location:../index.php");
		}
	}
	else
	{
		header("Location:../index.php");
	}
	if($bDatos == TRUE)
	{
		$_SESSION["sActacan_cap"] = $_SESSION["sActacan_cap2"];
		$_SESSION["sActacan_act"] = $_SESSION["sActacan_act2"];
		//$_SESSION["sActaingresado"] = 'F';
		include "act_viewestunota.php";
	}
?>