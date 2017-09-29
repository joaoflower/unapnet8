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
		
		/*if($_POST['rMod_mat'] != '02' and $_POST['rMod_mat'] != '08'  )
		{
			if($_POST['rCod_car'] == '86')
				$_SESSION['sActaend_ing'] = 'F';
			else
				$_SESSION['sActaend_ing'] = 'T';
		}
		else
		{
			if($_POST['rCod_car'] == '37')
				$_SESSION['sActaend_ing'] = 'T';
			else
				$_SESSION['sActaend_ing'] = 'T';
		}*/		
		
		$tCarga = "cargaint".$_SESSION['sFrameano_aca'];
		$tIngnota = "ingnota".$_SESSION['sFrameano_aca'];	
		$tSilabo = "silabo".$_SESSION['sFrameano_aca'];	
		$tSilaok = "silaok".$_SESSION['sFrameano_aca'];	
			
		
		$vQuery = "select car.*, esp.esp_nom, sem.sem_des ";
		$vQuery .= "from ( ";
		$vQuery .= "select ca.cod_car, ca.pln_est, cu.nom_cur, cu.sem_anu, cu.cod_esp, gr.sec_des, ";
		$vQuery .= "mm.mod_des, cr.car_des, cu.crd_cur ";
		$vQuery .= "from $tCarga ca left join curso cu on ca.cod_car = cu.cod_car and ";
		$vQuery .= "ca.pln_est = cu.pln_est and ca.cod_cur = cu.cod_cur ";
		$vQuery .= "left join grupo gr on ca.sec_gru = gr.sec_gru ";
		$vQuery .= "left join modmat mm on ca.mod_mat = mm.mod_mat ";
		$vQuery .= "left join carrera cr on ca.cod_car = cr.cod_car ";
		$vQuery .= "where ca.per_aca = '{$_SESSION['sFrameper_aca']}' and ca.cod_car = '{$_POST['rCod_car']}' and ";
		$vQuery .= "ca.pln_est = '{$_POST['rPln_est']}' and ca.cod_cur = '{$_POST['rCod_cur']}' and ca.sec_gru = '{$_POST['rSec_gru']}' ";
		$vQuery .= ") car ";
		$vQuery .= "left join especial esp on car.cod_car = esp.cod_car and car.pln_est = esp.pln_est and ";
		$vQuery .= "car.cod_esp = esp.cod_esp ";
		$vQuery .= "left join semestre sem on car.sem_anu = sem.sem_anu";
		
		$_SESSION['sPrnSql1'] = $vQuery;
		
		$cResult = fQuery($vQuery);
		$vNum_rows = fCountq($cResult);
		if($aResult = mysql_fetch_array($cResult))
		{
			$bDatos = TRUE;
		}
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{
		$_SESSION["sActacod_car"] = $_POST['rCod_car'];
		$_SESSION["sActapln_est"] = $_POST['rPln_est'];
		$_SESSION["sActacod_cur"] = $_POST['rCod_cur'];
		$_SESSION["sActasec_gru"] = $_POST['rSec_gru'];
		$_SESSION["sActamod_mat"] = $_POST['rMod_mat'];
		$_SESSION["sActacan_cap"] = "";
		$_SESSION["sActacan_act"] = "";
		$_SESSION["sActacan_cap2"] = "";
		$_SESSION["sActacan_act2"] = "";
		$_SESSION["sActaingresado"] = "";
		$_SESSION["sActacaiu"] = "";
?>
<center>
	<form action="#" method="post" enctype="multipart/form-data" name="fData" id="fData">
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Curso: 
	    <?=$aResult['nom_cur']?></th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
			  
			  
			  <tr>
			    <td>Menci&oacute;n : </td>
			    <th colspan="3"><?=$aResult['esp_nom']?></th>
		      </tr>
			  <tr>
			    <td width="75">Semestre :</td>
			    <th width="150"><?=$aResult['sem_des']?></th>
			    <td width="75">Grupo :</td>
			    <th width="150"><?=$aResult['sec_des']?></th>
		      </tr>
			</table>
		
		</td>
		<td background="../images/ven_mediumright.jpg"></td>
	  </tr>
	  <tr>
		<td><img src="../images/ven_bottomleft.jpg" width="16" height="16" border="0" alt="" /></td>
		<td background="../images/ven_bottomcenter.jpg"></td>
		<td><img src="../images/ven_bottomright.jpg" width="16" height="16" border="0" alt="" /></td>
	  </tr>
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Ingreso de Notas a actas </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
			<div id="dnotas">
			<?
				$vQuery = "select can_cap, can_act, ingresado ";
				$vQuery .= "from $tIngnota ";
				$vQuery .= "where pln_est = '{$_SESSION['sActapln_est']}' and cod_cur = '{$_SESSION['sActacod_cur']}' and ";
				$vQuery .= "sec_gru = '{$_SESSION['sActasec_gru']}' and mod_mat = '{$_SESSION['sActamod_mat']}' and ";
				$vQuery .= "cod_car = '{$_SESSION['sActacod_car']}' and ano_aca = '{$_SESSION['sFrameano_aca']}' and ";
				$vQuery .= "per_aca = '{$_SESSION['sFrameper_aca']}' ";
				
				$cResult = fQuery2($vQuery);
				if($aResult = mysql_fetch_array($cResult))
				{
					$_SESSION["sActacan_cap"] = $aResult['can_cap'];
					$_SESSION["sActacan_act"] = $aResult['can_act'];
					$_SESSION["sActaingresado"] = $aResult['ingresado'];
					include "act_viewestunota.php";
				}
				else
				{
					if($_SESSION['sActamod_mat'] == '02' or $_SESSION['sActamod_mat'] == '08')
					{
						$vQuery = "insert into $tIngnota (pln_est, cod_cur, sec_gru, mod_mat, cod_car, ano_aca, per_aca, can_cap, can_act,  ";
						$vQuery .= "cap1, cap2, cap3, cap4, cap5, cap6, act1, act2, act3, act4, fch_ing, ingresado ) values ";
						$vQuery .= "('{$_SESSION['sActapln_est']}', '{$_SESSION['sActacod_cur']}', '{$_SESSION['sActasec_gru']}', ";
						$vQuery .= "'{$_SESSION['sActamod_mat']}', '{$_SESSION['sActacod_car']}', '{$_SESSION['sFrameano_aca']}', ";
						$vQuery .= "'{$_SESSION['sFrameper_aca']}', '1', '0', ";
						$vQuery .= "'', '', '', '', '', '', '', '', '', '', now(), 'F') ";
						
						$cResult = fInupde2($vQuery);
						
						$_SESSION["sActacan_cap"] = 1;
						$_SESSION["sActacan_act"] = 0;
						$_SESSION["sActaingresado"] = 'F';
						include "act_viewestunota.php";
					}
					else
					{
					//---------------------------------------------
						/*$vQuery = "select can_cap, can_act ";
						$vQuery .= "from $tSilabo ";
						$vQuery .= "where pln_est = '{$_SESSION['sActapln_est']}' and cod_cur = '{$_SESSION['sActacod_cur']}' and ";
						$vQuery .= "sec_gru = '{$_SESSION['sActasec_gru']}' and mod_mat = '{$_SESSION['sActamod_mat']}' and ";
						$vQuery .= "cod_car = '{$_SESSION['sActacod_car']}' and ano_aca = '{$_SESSION['sFrameano_aca']}' and ";
						$vQuery .= "per_aca = '{$_SESSION['sFrameper_aca']}' ";
						
						$cResult = fQuery2($vQuery);
						if($aResult = mysql_fetch_array($cResult))
						{
							$_SESSION["sActacan_cap"] = $aResult['can_cap'];
							$_SESSION["sActacan_act"] = $aResult['can_act'];
							//$_SESSION["sActaingresado"] = $aResult['ingresado'];							
						}*/
						$vQuery = "select can_una, can_act ";
						$vQuery .= "from $tSilaok ";
						$vQuery .= "where pln_est = '{$_SESSION['sActapln_est']}' and cod_cur = '{$_SESSION['sActacod_cur']}' and ";
						$vQuery .= "sec_gru = '{$_SESSION['sActasec_gru']}' and mod_mat = '{$_SESSION['sActamod_mat']}' and ";
						$vQuery .= "cod_car = '{$_SESSION['sActacod_car']}' and ano_aca = '{$_SESSION['sFrameano_aca']}' and ";
						$vQuery .= "per_aca = '{$_SESSION['sFrameper_aca']}' and cod_prf = '{$_SESSION['sUsercod_usu']}' ";
						
						$cResult = fQuery2($vQuery);
						if($aResult = mysql_fetch_array($cResult))
						{
							$_SESSION["sActacan_cap"] = $aResult['can_una'];
							if($aResult['can_una'] <= 4)
								$_SESSION["sActacan_act"] = $aResult['can_una'];
							else
								$_SESSION["sActacan_act"] = 4;
							//$_SESSION["sActaingresado"] = $aResult['ingresado'];							
						}
					//---------------------------------------------
						include "act_getcanca.php";
					}
				}
					
			?>
			</div>
		</td>
		<td background="../images/ven_mediumright.jpg"></td>
	  </tr>
	  <tr>
		<td><img src="../images/ven_bottomleft.jpg" width="16" height="16" border="0" alt="" /></td>
		<td background="../images/ven_bottomcenter.jpg"></td>
		<td><img src="../images/ven_bottomright.jpg" width="16" height="16" border="0" alt="" /></td>
	  </tr>
	</table>
	</form>	
</center>
<?
	}
?>
