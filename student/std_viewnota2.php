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
	
	  <?
		if($_SESSION['sEstuano_aca'].$_SESSION['sEstuper_aca'] != '200901')
		{
	  ?>

	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Pago de matr&iacute;culas [<?=$_SESSION['sFrameano_aca']?> - <?=$_SESSION['sFrameper_aca']?>] </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center"> 
		<span class="wordi">El pago de cr&eacute;ditos desaprobados será en  cualquier Agencia 
		del<strong> BANCO DE<br />
		LA NACI&Oacute;N 
		
		a Nivel Nacional.  
		</strong>Al momento de realizar el pago indique:<strong><br />
&quot;Pago de Tasa educativa a la 
		Universidad Nacional del 
		Altiplano (TELEPROCESO), <br />
		</strong>en el concepto: <strong>MATR&Iacute;CULA REGULAR</strong> (Haga solo un pago),<strong> <br />
		</strong>e indique el<strong> &quot;MONTO TOTAL  A PAGAR EN EL BANCO&quot;</strong> que aparece a continuaci&oacute;n<strong>&quot; </strong></span>
		  <table border="0" cellpadding="0" cellspacing="0" class="tlistdata">
			  <tr>
			    <th width="25">C&oacute;d </th>
				<th width="280">Descripci&oacute;n</th>
		        <th width="15">Can</th>
		        <th width="25">P/U</th>
		        <th width="25">Total</th>
	          </tr>
			  
			  <?
			  	$vCont = 1;
				
				$sTarifapago = "";
				$sVecesdes = "";
				
				//------------------------------------------------
				$vQuery = "Select cod_pag, des_pag, mon_pag, vec_dsp from tarifapago ";
				$vQuery .= "where ano_aca = '{$_SESSION['sFrameano_aca']}' and per_aca = '{$_SESSION['sFrameper_aca']}' ";
				$cResult = fQuery($vQuery);
				while($aResult = mysql_fetch_array($cResult))
				{
					$sTarifapago[$aResult['cod_pag']]['des_pag'] = $aResult['des_pag'];
					$sTarifapago[$aResult['cod_pag']]['mon_pag'] = $aResult['mon_pag'];
					$sVecesdes[$aResult['vec_dsp']] = $aResult['cod_pag'];
				}				
				//-------------------------------------------------
				$sVeces = "";
				$vTot_pag = 0;
				
				$sVeces[1] = 0;
				$sVeces[2] = 0;
				$sVeces[3] = 0;
				$sVeces[4] = 0;
				$sVeces[5] = 0;
				$sVeces[6] = 0;
				$sVeces[7] = 0;
				$sVeces[8] = 0;
				$sVeces[9] = 0;
				$sVeces[10] = 0;
				$sVeces[11] = 0;
				$sVeces[12] = 0;
				$sVeces[13] = 0;
				$sVeces[14] = 0;
				$sVeces[15] = 0;
				$sVeces[16] = 0;
				$sVeces[17] = 0;
				$sVeces[18] = 0;
				$sVeces[19] = 0;
				$sVeces[20] = 0;
				
				
			?>
			<tr <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)" >
			    <td>01</td>
			    <td><?=$sTarifapago['01']['des_pag']?></td>
			    <td>1</td>
			    <td><?=$sTarifapago['01']['mon_pag']?></td>
			    <td><?=$sTarifapago['01']['mon_pag']?></td>
	      	</tr> 
			<?
				
				
				$vCont++;
				$vTot_pag += $sTarifapago['01']['mon_pag'];
				
				
				if($_SESSION['sEstuult_mat'])
				{
					$tCurmat = "curmat".$_SESSION['sUsercod_car'].$_SESSION['sEstuano_aca'];
					$tNota = "nota".$_SESSION['sUsercod_car'];
					
					$vQuery = "Select no.cod_cur, cu.crd_cur, count(*) as veces ";
					$vQuery .= "from $tNota no left join curso cu on ";
					$vQuery .= "   no.cod_car = cu.cod_car and no.pln_est = cu.pln_est and no.cod_cur = cu.cod_cur ";
					$vQuery .= "where no.pln_est = '{$_SESSION['sEstupln_est']}' and no.num_mat = '{$_SESSION['sUsercod_usu']}' and ";
					$vQuery .= "no.not_cur < 11 and (no.mod_not != '13' and no.mod_not != '08') and ";
					$vQuery .= "no.cod_car = '{$_SESSION['sUsercod_car']}' and no.cod_cur not in ";
					$vQuery .= "   (Select cod_cur from $tNota where pln_est = '{$_SESSION['sEstupln_est']}' and ";
					$vQuery .= "    num_mat = '{$_SESSION['sUsercod_usu']}' and not_cur > 10) ";
					$vQuery .= "and no.cod_cur in ";
					$vQuery .= "   (Select cod_cur from $tCurmat where pln_est = '{$_SESSION['sEstupln_est']}' and ";
//					$vQuery .= "    num_mat = '{$_SESSION['sUsercod_usu']}' and (per_aca = '{$_SESSION['sEstuper_aca']}' or per_aca = '03')) ";
					$vQuery .= "    num_mat = '{$_SESSION['sUsercod_usu']}' and per_aca = '{$_SESSION['sEstuper_aca']}' ) ";
					$vQuery .= "group by cod_cur order by veces, cod_cur ";					
					
					$cResult = fQuery($vQuery);
					while($aResult = mysql_fetch_array($cResult))
					{
						$sVeces[$aResult['veces']] += $aResult['crd_cur'];
					}
				}
				
			
				foreach($sVeces as $vVec_dsp => $vCrd_cur)
				{
					if($vCrd_cur > 0)
					{
						$vTot_pag += $vCrd_cur*$sTarifapago[$sVecesdes[$vVec_dsp]]['mon_pag'];
			  ?>
			  <tr  <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)" >
			    <td ><?=$sVecesdes[$vVec_dsp]?></td>
			    <td ><?=$sTarifapago[$sVecesdes[$vVec_dsp]]['des_pag']?></td>
		        <td ><?=$vCrd_cur?></td>
		        <td ><?=$sTarifapago[$sVecesdes[$vVec_dsp]]['mon_pag']?></td>
		        <td ><?=$vCrd_cur*$sTarifapago[$sVecesdes[$vVec_dsp]]['mon_pag']?></td>
	          </tr>
			  <?	
						$vCont++;	
					}
				}
				//--------------Rezagados --------------------------------
				
				$bExocar = 'False';
				$bExoestu = 'False';
				
				$vQuery = "Select con_exo from exocar ";
				$vQuery .= "where ano_aca = '{$_SESSION['sFrameano_aca']}' and per_aca = '{$_SESSION['sFrameper_aca']}' and ";
				$vQuery .= "cod_car ='{$_SESSION['sUsercod_car']}' ";
				$cResult = fQuery($vQuery);
				if($aResult = mysql_fetch_array($cResult))
					$bExocar = $aResult['con_exo'];
				
				if($bExocar === 'False')
				{
					$vQuery = "Select num_mat from exoestu ";
					$vQuery .= "where ano_aca = '{$_SESSION['sFrameano_aca']}' and per_aca = '{$_SESSION['sFrameper_aca']}' and ";
					$vQuery .= "num_mat = '{$_SESSION['sUsercod_usu']}' and cod_car = '{$_SESSION['sUsercod_car']}' ";
					$cResult = fQuery($vQuery);
					if($aResult = mysql_fetch_array($cResult))
						$bExoestu = 'True';
					
					if($bExoestu === 'False')
					{
				?>
			<tr <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)" >
			    <td>26</td>
			    <td><?=$sTarifapago['26']['des_pag']?></td>
			    <td>1</td>
			    <td><?=$sTarifapago['26']['mon_pag']?></td>
			    <td><?=$sTarifapago['26']['mon_pag']?></td>
	      	</tr> 
				<?	
						$vCont++;
						$vTot_pag += $sTarifapago['26']['mon_pag'];					
					}						
					
				}
				
				//--------------------------------------------------------			
				//-----------------Anmistia-------------------------------
				$vCan_pag = 0;
				if($_SESSION['sUserult_mat'] != '2009')
				{
					$vQuery = "Select can_pag from tarifanmis ";
					$vQuery .= "where ult_mat = '{$_SESSION['sUserult_mat']}' and ult_per = '{$_SESSION['sUserult_per']}' ";

					$cResult = fQuery($vQuery);
					if($aResult = mysql_fetch_array($cResult))
						$vCan_pag = $aResult['can_pag'];
						
					if($vCan_pag > 0)
					{
				?>
			<tr <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)" >
			    <td>24</td>
			    <td><?=$sTarifapago['24']['des_pag']?></td>
			    <td><?=$vCan_pag?></td>
			    <td><?=$sTarifapago['24']['mon_pag']?></td>
			    <td><?=($sTarifapago['24']['mon_pag']*$vCan_pag)?></td>
	      	</tr> 
				<?
						$vCont++;
						$vTot_pag += ($sTarifapago['24']['mon_pag'] * $vCan_pag);
					}
				}
				
				
				//--------------------------------------------------------			
				
				if($vTot_pag > 0)
				{				
				?>
			  <tr <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)" >
			    <td>38</td>
			    <td><?=$sTarifapago['38']['des_pag']?></td>
			    <td>1</td>
			    <td><?=$sTarifapago['38']['mon_pag']?></td>
			    <td><?=$sTarifapago['38']['mon_pag']?></td>
	      	  </tr>
			  	<?	
					$vCont++;
					$vTot_pag += $sTarifapago['38']['mon_pag'];
				}	
				
				?>
			  <tr >
			    <th colspan="4" align="right" >MONTO TOTAL A PAGAR EN EL BANCO:</th>
			    <th ><?=$vTot_pag?></th>
	      </tr>
		</table>		
		<span class="wordi">Despu&eacute;s de realizar el pago de cr&eacute;ditos desaprobados realice su matr&iacute;cula<strong> <br />
		V&Iacute;A INTERNET, 
		</strong>haciendo click en la opci&oacute;n<strong> MATRICULAS </strong>de este sistema<strong>. </strong></span>		</td>
		<td background="../images/ven_mediumright.jpg"></td>
	  </tr>
	  <tr>
		<td><img src="../images/ven_bottomleft.jpg" width="16" height="16" border="0" alt="" /></td>
		<td background="../images/ven_bottomcenter.jpg"></td>
		<td><img src="../images/ven_bottomright.jpg" width="16" height="16" border="0" alt="" /></td>
	  </tr>
	</table>
	
	<?
		}
	?>

	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Historial de Notas </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
		<table border="0" cellpadding="0" cellspacing="0" class="tlistdata">
			  <tr>
			    <th width="5">&nbsp;</th>
			    <th width="40">C&oacute;d </th>
				<th width="300">Nombre curso </th>
		        <th width="15">Niv</th>
		        <th width="15">Sem</th>
		        <th width="25">Crd</th>
		        <th width="60">Modalidad</th>
			    <th width="30">Nota</th>
		      </tr>
			  <?
			  	$vCont = 1;
			  	$vAno_per = "";
				$tNota = "nota".$_SESSION['sUsercod_car'];
			  
			  	$vQuery = "select no.ano_aca, no.per_aca, pe.per_des, no.pln_est, no.cod_cur, cu.nom_cur, cu.niv_est, ";
				$vQuery .= "cu.sem_anu, cu.crd_cur, no.mod_not, mn.not_des, no.not_cur ";
				$vQuery .= "from $tNota no left join curso cu on no.cod_car = cu.cod_car and no.pln_est = cu.pln_est and ";
				$vQuery .= "no.cod_cur = cu.cod_cur ";
				$vQuery .= "left join modnot mn on no.mod_not = mn.mod_not ";
				$vQuery .= "left join periodo pe on no.per_aca = pe.per_aca ";
				$vQuery .= "where no.num_mat = '{$_SESSION['sUsercod_usu']}' and no.cod_car = '{$_SESSION['sUsercod_car']}' ";
				$vQuery .= "order by no.ano_aca desc, no.per_aca desc, no.pln_est, no.cod_cur ";
				
				$cResult = fQuery($vQuery);
				$vNum_rows = fCountq($cResult);
				while($aResult = mysql_fetch_array($cResult))
				{
					if($vAno_per != ($aResult['ano_aca'].$aResult['per_aca']))
					{
						$vAno_per = ($aResult['ano_aca'].$aResult['per_aca']);
			  ?>
			  <tr>
			    <td>&nbsp;</td>
		        <th colspan="7">A&ntilde;o: <?=$aResult['ano_aca']?> - Periodo: <?=$aResult['per_des']?></th>
	          </tr>
			  <?
			  		}
			  ?>
			  <tr <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)" id="rTr<?=$aResult['cod_cur']?>">
			    <td <?=ftdstyle($vNum_rows, $vCont)?>>&nbsp;</td>
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['pln_est']?>-<?=$aResult['cod_cur']?></td>
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['nom_cur']))?></td>
		        <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['niv_est']?></td>
		        <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['sem_anu']?></td>
		        <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['crd_cur']?></td>
		        <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['not_des']))?></td>
		        <td <?=ftdstylenota($vNum_rows, $vCont, $aResult['not_cur'])?>><?=$aResult['not_cur']?></td>
		      </tr>
			  <?
					$vCont++;
			  	}
			  ?>
		  </table>		</td>
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