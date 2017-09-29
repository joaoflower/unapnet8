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
		$tNotaca = "notaca".$_SESSION['sActacod_car'].$_SESSION['sFrameano_aca'];			
		$tNota = "nota".$_SESSION['sActacod_car'];
		$tCurmat = "curmat".$_SESSION["sActacod_car"].$_SESSION['sFrameano_aca'];
			
		$vQuery = "update $tIngnota set ingresado = 'T' ";
		$vQuery .= "where pln_est = '{$_SESSION['sActapln_est']}' and ";
		$vQuery .= "cod_cur = '{$_SESSION['sActacod_cur']}' and sec_gru = '{$_SESSION['sActasec_gru']}' and ";
		$vQuery .= "mod_mat = '{$_SESSION['sActamod_mat']}' and cod_car = '{$_SESSION['sActacod_car']}' and ";
		$vQuery .= "ano_aca = '{$_SESSION['sFrameano_aca']}' and per_aca = '{$_SESSION['sFrameper_aca']}' ";
		
		$cResult = fInupde2($vQuery);
		if($cResult)
		{
			$_SESSION["sActaingresado"] = 'T';
			$bNotacap = FALSE;
			$bNotaact = FALSE;
			
			$sNotacap = "";
			$sNotaact = "";
			
			$vPC = 0;
			$vPA = 0;
			$vPF = 0;
			
			$vQuery = "Select no.num_mat, no.mod_not, sum(no.not_cur) as suma, count(*) as canti ";
			$vQuery .= "from $tNotaca no ";
			$vQuery .= "left join modnot mn on no.mod_not = mn.mod_not ";
			$vQuery .= "where no.ano_aca = '{$_SESSION['sFrameano_aca']}' and no.per_aca = '{$_SESSION['sFrameper_aca']}' and ";
			$vQuery .= "no.cod_car = '{$_SESSION['sActacod_car']}' and no.pln_est = '{$_SESSION['sActapln_est']}' and ";
			$vQuery .= "no.cod_cur = '{$_SESSION['sActacod_cur']}' and no.tip_not = 'C' and ";
			$vQuery .= "mn.mod_act = '{$_SESSION['sActamod_mat']}' and num_mat in ";
			$vQuery .= "(Select num_mat from $tCurmat where per_aca = '{$_SESSION['sFrameper_aca']}' and ";
			$vQuery .= "pln_est = '{$_SESSION['sActapln_est']}' and cod_cur = '{$_SESSION['sActacod_cur']}' and ";
			$vQuery .= "sec_gru = '{$_SESSION['sActasec_gru']}') ";
			$vQuery .= "group by no.num_mat, no.mod_not ";
			$cResult = fQuery2($vQuery);
			while($aResult = mysql_fetch_array($cResult))
			{
				$bNotacap = TRUE;
				$sNotacap[$aResult['num_mat'].$aResult['mod_not']] = round($aResult['suma']/$aResult['canti']);
			}
			
			
			$vQuery = "Select no.num_mat, no.mod_not, sum(no.not_cur) as suma, count(*) as canti ";
			$vQuery .= "from $tNotaca no ";
			$vQuery .= "left join modnot mn on no.mod_not = mn.mod_not ";
			$vQuery .= "where no.ano_aca = '{$_SESSION['sFrameano_aca']}' and no.per_aca = '{$_SESSION['sFrameper_aca']}' and ";
			$vQuery .= "no.cod_car = '{$_SESSION['sActacod_car']}' and no.pln_est = '{$_SESSION['sActapln_est']}' and ";
			$vQuery .= "no.cod_cur = '{$_SESSION['sActacod_cur']}' and no.tip_not = 'A' and ";
			$vQuery .= "mn.mod_act = '{$_SESSION['sActamod_mat']}' and num_mat in ";
			$vQuery .= "(Select num_mat from $tCurmat where per_aca = '{$_SESSION['sFrameper_aca']}' and ";
			$vQuery .= "pln_est = '{$_SESSION['sActapln_est']}' and cod_cur = '{$_SESSION['sActacod_cur']}' and ";
			$vQuery .= "sec_gru = '{$_SESSION['sActasec_gru']}') ";
			$vQuery .= "group by no.num_mat, no.mod_not ";
			$cResult = fQuery2($vQuery);
			while($aResult = mysql_fetch_array($cResult))
			{
				$bNotaact = TRUE;
				$sNotaact[$aResult['num_mat'].$aResult['mod_not']] = round($aResult['suma']/$aResult['canti']);
			}
			
			if($bNotacap == TRUE)
			{
				$vQuery = "Select distinct no.num_mat, no.mod_not from $tNotaca no ";
				$vQuery .= "left join modnot mn on no.mod_not = mn.mod_not ";
				$vQuery .= "where no.ano_aca = '{$_SESSION['sFrameano_aca']}' and no.per_aca = '{$_SESSION['sFrameper_aca']}' and ";
				$vQuery .= "no.cod_car = '{$_SESSION['sActacod_car']}' and no.pln_est = '{$_SESSION['sActapln_est']}' and ";
				$vQuery .= "no.cod_cur = '{$_SESSION['sActacod_cur']}' and no.tip_not = 'C' and ";
				$vQuery .= "mn.mod_act = '{$_SESSION['sActamod_mat']}' and num_mat in ";
				$vQuery .= "(Select num_mat from $tCurmat where per_aca = '{$_SESSION['sFrameper_aca']}' and ";
				$vQuery .= "pln_est = '{$_SESSION['sActapln_est']}' and cod_cur = '{$_SESSION['sActacod_cur']}' and ";
				$vQuery .= "sec_gru = '{$_SESSION['sActasec_gru']}') ";
				$cResult = fQuery2($vQuery);
				while($aResult = mysql_fetch_array($cResult))
				{
					$vPC = 0;
					$vPA = 0;
					$vPF = 0;
					
					$vPC = $sNotacap[$aResult['num_mat'].$aResult['mod_not']];
					if($bNotaact == TRUE)
					{
						$vPA = $sNotaact[$aResult['num_mat'].$aResult['mod_not']];
						$vPF = round(($vPC * 0.9) + $vPA);
						
						$vQuery = "Insert into $tNota (num_mat, cod_car, pln_est, cod_cur, mod_not, ano_aca, ";
						$vQuery .= "per_aca, not_cap, not_act, not_cur, cod_act, fch_not, mod_ing) values ";
						$vQuery .= "('{$aResult['num_mat']}', '{$_SESSION['sActacod_car']}', '{$_SESSION['sActapln_est']}', ";
						$vQuery .= "'{$_SESSION['sActacod_cur']}', '{$aResult['mod_not']}', '{$_SESSION['sFrameano_aca']}', ";
						$vQuery .= "'{$_SESSION['sFrameper_aca']}', '$vPC', '$vPA', '$vPF', '', now(), '02')";	
					}
					else
					{
						$vPF = round($vPC);
						
						$vQuery = "Insert into $tNota (num_mat, cod_car, pln_est, cod_cur, mod_not, ano_aca, ";
						$vQuery .= "per_aca, not_cap, not_act, not_cur, cod_act, fch_not, mod_ing) values ";
						$vQuery .= "('{$aResult['num_mat']}', '{$_SESSION['sActacod_car']}', '{$_SESSION['sActapln_est']}', ";
						$vQuery .= "'{$_SESSION['sActacod_cur']}', '{$aResult['mod_not']}', '{$_SESSION['sFrameano_aca']}', ";
						$vQuery .= "'{$_SESSION['sFrameper_aca']}', '$vPC', '', '$vPF', '', now(), '02')";	
					}
					$cR = fInupde($vQuery);
				}
			}
		}
			
		include "act_viewestunota.php";
	}
	else
	{
		header("Location:../index.php");
	}
?>