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
		
		$vQuery = "select gp.cod_gpo, gp.cod_esp, es.nom_esp, gp.cod_cur, cu.des_cur, gp.cod_sec, sc.des_sec, ";
		$vQuery .= "  gp.hra_ini, substring(hr1.des_hra, 1, 5) as dhra_ini, gp.hra_fin, ";
		$vQuery .= "  substring(hr2.des_hra, 1, 5) as dhra_fin ";
		$vQuery .= "from gruposhab gp ";
		$vQuery .= "left join especialidades es on gp.cod_esp = es.cod_esp ";
		$vQuery .= "left join cursos cu on gp.cod_cur = cu.cod_cur ";
		$vQuery .= "left join seccion sc on gp.cod_sec = sc.cod_sec ";
		$vQuery .= "left join horas hr1 on gp.hra_ini = hr1.cod_hra ";
		$vQuery .= "left join horas hr2 on gp.hra_fin = hr2.cod_hra ";
		$vQuery .= "left join docentes dc on gp.cod_doc = dc.cod_doc ";
		$vQuery .= "where gp.cod_gpo = '{$_POST['rCod_gpo']}'";
		
		$_SESSION['sPrnSql1'] = $vQuery;
		
		$cResult = fQueryi($vQuery);
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
		$_SESSION["sActacod_car"] = '61';
		$_SESSION["sActamod_mat"] = $aResult['hra_ini'];
		$_SESSION["sActacod_gpo"] = $_POST['rCod_gpo'];
		$_SESSION["sActacod_esp"] = $aResult['cod_esp'];
		$_SESSION["sActacod_cur"] = $aResult['cod_cur'];
		$_SESSION["sActacod_sec"] = $aResult['cod_sec'];
		$_SESSION["sActahra_ini"] = $aResult['hra_ini'];
		$_SESSION["sActahra_fin"] = $aResult['hra_fin'];
		$_SESSION["sActacan_cap"] = "";
		$_SESSION["sActacan_act"] = "";
		$_SESSION["sActaingresado"] = "";
		$_SESSION["sActacaiu"] = "";
?>
<center>
	<form action="#" method="post" enctype="multipart/form-data" name="fData" id="fData">
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Curso: <?=$aResult['des_cur']?></th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
			  
			  
			  <tr>
			    <td width="75">Idiomas : </td>
			    <th width="150"><?=$aResult['nom_esp']?></th>
		        <td width="75">Grupo : </td>
		        <th width="150"><?=$aResult['des_sec']?></th>
			  </tr>
			  <tr>
			    <td width="75">Horario : </td>
			    <th width="150"><?=$aResult['dhra_ini']?> - <?=$aResult['dhra_fin']?></th>
			    <td width="75">&nbsp;</td>
			    <th width="150">&nbsp;</th>
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
				$vQuery .= "where pln_est = '{$_SESSION['sActacod_esp']}' and cod_cur = '{$_SESSION['sActacod_cur']}' and ";
				$vQuery .= "sec_gru = '{$_SESSION['sActacod_sec']}' and mod_mat = '{$_SESSION['sActamod_mat']}' and ";
				$vQuery .= "cod_car = '{$_SESSION['sActacod_car']}' and ano_aca = '{$_SESSION['sFrameano_acai']}' and ";
				$vQuery .= "per_aca = '{$_SESSION['sFramecod_mesi']}' ";
				
				$cResult = fQuery2($vQuery);
				if($aResult = mysql_fetch_array($cResult))
				{
					$_SESSION["sActacan_cap"] = $aResult['can_cap'];
					$_SESSION["sActacan_act"] = $aResult['can_act'];
					$_SESSION["sActaingresado"] = $aResult['ingresado'];
					include "act_viewestunotai.php";
				}
				else
				{
					$vQuery = "insert into $tIngnota (pln_est, cod_cur, sec_gru, mod_mat, cod_car, ano_aca, per_aca, can_cap, can_act,  ";
					$vQuery .= "cap1, cap2, cap3, cap4, cap5, cap6, act1, act2, act3, act4, fch_ing, ingresado ) values ";
					$vQuery .= "('{$_SESSION['sActacod_esp']}', '{$_SESSION['sActacod_cur']}', '{$_SESSION['sActacod_sec']}', ";
					$vQuery .= "'{$_SESSION['sActamod_mat']}', '{$_SESSION['sActacod_car']}', '{$_SESSION['sFrameano_acai']}', ";
					$vQuery .= "'{$_SESSION['sFramecod_mesi']}', '2', '0', ";
					$vQuery .= "'', '', '', '', '', '', '', '', '', '', now(), 'F') ";
					
					$cResult = fInupde2($vQuery);
					
					$_SESSION["sActacan_cap"] = 2;
					$_SESSION["sActacan_act"] = 0;
					$_SESSION["sActaingresado"] = 'F';
					include "act_viewestunotai.php";
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
