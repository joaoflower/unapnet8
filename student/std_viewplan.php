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

		$bDatos = TRUE;

	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{
?>
<center>
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Plan de estudios </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center"><table border="0" cellspacing="0" cellpadding="0" class="tlistdata">
			<tr>
			  <th width="25">C&oacute;d</th>
			  <th width="250">Nombre</th>
			  <th width="20">Sm</th>
			  <th width="15">HT</th>
			  <th width="15">HP</th>
			  <th width="15">TH</th>
			  <th width="30">Cred</th>
			  <th width="60">Pre-req.</th>
		    </tr>
			<?
				$_SESSION['sPlanPln_est'] = $_POST['rPln_est'];
				
				$sRequ = "";
				$vSem_anu = "";
				$vTip_cur = "01";
				$vCod_esp = "00";
				
				$vQuery = "select re.cod_cur, re.cur_pre ";
				$vQuery .= "from requ re ";
				$vQuery .= "where re.cod_car = '{$_SESSION['sUsercod_car']}' and re.pln_est = '{$_SESSION['sEstupln_est']}' ";
				$vQuery .= "order by re.cod_cur, re.cur_pre ";
				$cResult = fQuery($vQuery);
				while($aResult = mysql_fetch_array($cResult))
				{
					if(empty($sRequ[$aResult['cod_cur']]))
						$sRequ[$aResult['cod_cur']] = $aResult['cur_pre'];
					else
						$sRequ[$aResult['cod_cur']] .= ", ".$aResult['cur_pre'];
				}
				
				$vQuery = "Select cu.cod_cur, cu.nom_cur, cu.sem_anu, se.sem_des, cu.cod_esp, es.esp_nom, cu.hrs_teo, cu.hrs_pra, cu.hrs_tot, cu.crd_cur, ";
				$vQuery .= "cu.tip_cur, tc.cur_des, tc.ord_tip, cu.tip_pre, cu.crd_prq ";
				$vQuery .= "from curso cu left join semestre se on cu.sem_anu = se.sem_anu ";
				$vQuery .= "left join especial es on cu.cod_car = es.cod_car and cu.pln_est = es.pln_est and ";
				$vQuery .= "  cu.cod_esp = es.cod_esp ";
				$vQuery .= "left join tipcur tc on cu.tip_cur = tc.tip_cur ";				
				$vQuery .= "where cu.cod_car = '{$_SESSION['sUsercod_car']}' and cu.pln_est = '{$_SESSION['sEstupln_est']}' and ";
				$vQuery .= "con_cur = '1' ";
				$vQuery .= "order by cu.sem_anu, tc.ord_tip, cu.cod_esp, cu.cod_cur ";
				$cCurso = fQuery($vQuery);
				$vNum_rows = fCountq($cCurso);
				while($aCurso = mysql_fetch_array($cCurso))
				{
					if($vSem_anu != $aCurso['sem_anu'])
					{
						$vSem_anu = $aCurso['sem_anu'];
						$vCod_esp = "00";
						$vTip_cur = "01";
			?>		
			<tr>
			  <th>&nbsp;</th>
			  <th colspan="7">SEMESTRE: <?=$aCurso['sem_des']?></th>
		    </tr>
			<?
					}
					if($vTip_cur != $aCurso['tip_cur'])
					{
						$vTip_cur = $aCurso['tip_cur'];
						$vCod_esp = "00";
			?>
			<tr>
			  <td>&nbsp;</td>
			  <th colspan="7">TIPO DE CURSO: <?=$aCurso['cur_des']?></th>
		  </tr>
			<?
					}
					if($vCod_esp != $aCurso['cod_esp'])
					{
						$vCod_esp = $aCurso['cod_esp'];
			?>
			<tr>
			  <td>&nbsp;</td>
			  <th colspan="7">MENCI&Oacute;N: <?=$aCurso['esp_nom']?></th>
		  </tr>	
			<?
					}
			?>
			<tr <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)">
			  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aCurso['cod_cur']?></td>
			  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aCurso['nom_cur']?></td>
			  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aCurso['sem_anu']?></td>
			  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aCurso['hrs_teo']?></td>
			  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aCurso['hrs_pra']?></td>
		      <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aCurso['hrs_tot']?></td>
		      <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aCurso['crd_cur']?></td>
		      <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$sRequ[$aCurso['cod_cur']]?></td>
	        </tr>	
			<?
					$vCont++;
				}
			?>
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

</center>
<?		
	}
?>