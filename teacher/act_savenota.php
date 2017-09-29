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
		
		$vCont = 1;
		$vCan_not = 0;
		
		$vNum_mat = "";
		$vMod_not = "";
		$vMod_mat = "";
		$vIns_Upd = "";
		$vNot_cur = "";
		
		$tNota = "notaca".$_SESSION["sActacod_car"].$_SESSION['sFrameano_aca'];
		
		if(!empty($_POST['rNum_mat']) and !empty($_POST['rMod_not']) and strlen($_POST['rNot_cur']) > 0)
		{
			$vCan_not = strlen($_POST['rNum_mat']) / 6;
			if($vCan_not > 0)
			{
				for($ii = 0; $ii < $vCan_not; $ii++)
				{
					$vNum_mat = substr($_POST['rNum_mat'], 6 * $ii, 6);
					$vMod_not = substr($_POST['rMod_not'], 3 * $ii, 2);
					$vIns_Upd = substr($_POST['rMod_not'], (3 * $ii) + 2, 1);
					if($_SESSION["sActatip_not"] == 'C')
						$vNot_cur = substr($_POST['rNot_cur'], 2 * $ii, 2);
					elseif($_SESSION["sActatip_not"] == 'A')
						$vNot_cur = substr($_POST['rNot_cur'], $ii, 1);
					
					if($vIns_Upd == "i")
					{
						$vQuery = "insert into $tNota (num_mat, pln_est, cod_cur, per_aca, ano_aca, mod_not, cod_car, tip_not, ";
						$vQuery .= "ord_not, not_cur) values ";
						$vQuery .= "('$vNum_mat', '{$_SESSION['sActapln_est']}', '{$_SESSION['sActacod_cur']}', '{$_SESSION['sFrameper_aca']}', ";
						$vQuery .= "'{$_SESSION['sFrameano_aca']}', '$vMod_not', '{$_SESSION['sActacod_car']}', '{$_SESSION['sActatip_not']}', ";
						$vQuery .= "'{$_SESSION['sActaord_not']}', '$vNot_cur') ";
			
						$cResult = fInupde2($vQuery);
					}
					elseif($vIns_Upd == "u")
					{
						$vQuery = "update $tNota set not_cur = '$vNot_cur' ";
						$vQuery .= "where num_mat = '$vNum_mat' and pln_est = '{$_SESSION['sActapln_est']}' and ";
						$vQuery .= "cod_cur = '{$_SESSION['sActacod_cur']}' and per_aca = '{$_SESSION['sFrameper_aca']}' and ";
						$vQuery .= "ano_aca = '{$_SESSION['sFrameano_aca']}' and mod_not = '$vMod_not' and ";
						$vQuery .= "cod_car = '{$_SESSION['sActacod_car']}' and tip_not = '{$_SESSION['sActatip_not']}' and ";
						$vQuery .= "ord_not = '{$_SESSION['sActaord_not']}' ";
						
						$cResult = fInupde2($vQuery);
					}
				}
			}
			$bDatos = TRUE;
		}
		
		
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{	
		$_SESSION["sActatip_not"] = "";
		$_SESSION["sActaord_not"] = "";
		include "act_viewestunota.php";
	}
?>