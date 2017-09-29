<?php
	session_start();
	include "../include/funcget.php";
	include "../include/funcsql.php";
	include "../include/funcstyle.php";
	include "../include/funcoption.php";
	
	if(fsafetylogin())
	{
//		$id_menu = 2;
		$_SESSION['sEstuano_aca'] = "";
		$_SESSION['sEstuper_aca'] = "";
		$_SESSION['sEstupln_est'] = "";
		
		$_SESSION['sEstucod_esp'] = "";
		$_SESSION['sEstuesp_nom'] = "";
		
		$_SESSION['sEstumod_matp'] = "";
		$_SESSION['sEstumod_desp'] = "";
		$_SESSION['sEstutot_crdp'] = "";
		
		$_SESSION['sEstuano_acap'] = "";
		$_SESSION['sEstuper_acap'] = "";
		$_SESSION['sEstupln_estp'] = "";
		
		$_SESSION['sEstuult_mat'] = FALSE;
		$_SESSION['sEstupen_mat'] = FALSE;
		
		$_SESSION['sEstumat_ok'] = FALSE;
		$_SESSION['sEstumat_okse'] = FALSE;
		
		$_SESSION['sEstumat_ya'] = FALSE;
		$_SESSION['sEstumat_deu'] = FALSE;
		$_SESSION['sEstumat_pag'] = FALSE;
		
		$_SESSION['sEstucan_bol'] = 0;
		$_SESSION['sEstusql_bol'] = "";
		
		//-------------------------------------------
		$vAno_ini = substr($_SESSION['sUsercod_usu'], 0, 2);
		if($vAno_ini < '50') 
			$vAno_ini = "20$vAno_ini";
		else
			$vAno_ini = "1999";
			
		for($vAno_aca = $_SESSION['sFrameano_aca']; $vAno_aca >= $vAno_ini; $vAno_aca--)
		{
			$tEstumat = "estumat".$_SESSION['sUsercod_car'].$vAno_aca;
			
			$vQuery = "Select em.pln_est, em.per_aca, em.cod_esp, es.esp_nom, em.mod_mat, mm.mod_des, em.tot_crd ";
			$vQuery .= "from $tEstumat em left join especial es on em.cod_car = es.cod_car and ";
			$vQuery .= "em.pln_est = es.pln_est and em.cod_esp = es.cod_esp ";
			$vQuery .= "left join modmat mm on em.mod_mat = mm.mod_mat ";
			$vQuery .= "where em.num_mat = '{$_SESSION['sUsercod_usu']}' ";
			$vQuery .= "and (em.per_aca = '00' or em.per_aca = '01' or em.per_aca = '02') order by em.per_aca desc";
			
			$cResult = fQuery($vQuery);
			while($aResult = mysql_fetch_array($cResult))
			{
				if($_SESSION['sEstuult_mat'] == FALSE)
				{
					$_SESSION['sEstuano_aca'] = $vAno_aca;
					$_SESSION['sEstuper_aca'] = $aResult['per_aca'];
					$_SESSION['sEstupln_est'] = $aResult['pln_est'];
					
					$_SESSION['sEstucod_esp'] = $aResult['cod_esp'];
					$_SESSION['sEstuesp_nom'] = $aResult['esp_nom'];
					
					$_SESSION['sEstumod_matp'] = $aResult['mod_mat'];
					$_SESSION['sEstumod_desp'] = $aResult['mod_des'];
					$_SESSION['sEstutot_crdp'] = $aResult['tot_crd'];
					
					$_SESSION['sEstuult_mat'] = TRUE;
				}
				else
				{
					$_SESSION['sEstuano_acap'] = $vAno_aca;
					$_SESSION['sEstuper_acap'] = $aResult['per_aca'];
					$_SESSION['sEstupln_estp'] = $aResult['pln_est'];
					
					$_SESSION['sEstupen_mat'] = TRUE;
					break;					
				}
			}
			if($_SESSION['sEstupen_mat'] == TRUE)
				break;
		}
		//-----------------------------------------
	}
	else
	{
		$_SESSION['sIni'] = "";
		header("Location:../index.php");
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/main.css">
<link rel="stylesheet" href="../css/frame.css">
<link rel="stylesheet" href="../css/framelogin.css">
<link rel="stylesheet" href="../css/style.css">
<title>Un@p.Net&reg; - Sistema Acad&eacute;mico via Web - UNA - Puno</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../js/ggw3.js"></script>
<script language="JavaScript" src="../js/function.js"></script>
<script language="JavaScript" src="../js/student.js"></script>
<script language="JavaScript">
	function enfocar()
	{
		maximizar();
	}
	function aumentar(cont, vCanti, vMax)
	{ 
		if(cont.checked)
		{
			if((parseFloat(document.fData.rCrd_cur.value) + parseFloat(vCanti)) > parseFloat(vMax))
			{
				var vMsg = "A exedido los " + vMax + " CRÉDITOS permitidos, se QUITARA el curso escogido";
				alert(vMsg);
				cont.checked = false;
			}
			else
			{
				document.fData.rCrd_cur.value = parseFloat(document.fData.rCrd_cur.value) + parseFloat(vCanti);
				sombrear(cont);
			}
		}
		else
		{
			document.fData.rCrd_cur.value = parseFloat(document.fData.rCrd_cur.value) - parseFloat(vCanti);
			desombrear(cont);
		}
	}

</script>
</head>

<body onLoad="enfocar();">
	<center>
	<table border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td>
			<? include "../include/header1.php"; ?>
			<? include "../include/menu2.php"; ?>
			
			<div id="dcontent">
				<table width="770" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tcontent">
				  <tr id="trcontent">
					
					<td valign="top" id="tdsubcontent">
						<div id="dsubcontent">
							<center>
							  Un@p.Net&reg; - Sistema Acad&eacute;mico via Web - UNA - Puno
							  <br>
							  <?
							  
							  	if($_SESSION['sUsercod_car'] != '61')
								{
							  	//-------------------------------------------------------------------------
							  
							  	$_SESSION['sEstumat_deu'] = FALSE; 	// Tiene deuda
							  	$vQuery = "select det_deu from deudor where codigo = '{$_SESSION['sUsercod_usu']}' and est_deu = '0' ";
								$cResult = fQuerydeudor($vQuery);
								while($aResult = mysql_fetch_array($cResult))
								{
									$vDet_deu .= $aResult['det_deu']. " y <br>";
									$_SESSION['sEstumat_deu'] = TRUE;
								}
								if($_SESSION['sEstumat_deu'] == TRUE)
								{
							?>
							<center>
								<span class="wordi">USTED ES<strong> DEUDOR </strong>A LA UNIVERSIDAD. <br />
							  CANCELE SU DEUDA PARA PODER REALIZAR TRANSACCIONES<strong>. </strong></span>
							  
								<table border="0" cellpadding="0" cellspacing="0" class="tventana">
								  <tr>
									<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
									<th background="../images/ven_topcenter.jpg">Deudas </th>
									<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
								  </tr>
								  <tr>
									<td background="../images/ven_mediumleft.jpg"></td>
									<td align="center"><table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
										<tr>
										  <td width="80">Detalle :</td>
										  <th width="300"><?=$vDet_deu?></th>
										</tr>
									</table></td>
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
							  
							  <!--<table border="0" cellpadding="0" cellspacing="0" class="tventana">
                                <tr>
                                  <td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
                                  <th background="../images/ven_topcenter.jpg">COMUNICADO (De acuerdo a la Ley Universitaria N&deg; 23733, Art&iacute;culo 58&deg;) </th>
                                  <td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
                                </tr>
                                <tr>
                                  <td background="../images/ven_mediumleft.jpg"></td>
                                  <td><span class="wordi">Los siguientes estudiantes <strong>PERDER&Aacute;N LA GRATUIDAD DE LA ENSE&Ntilde;ANZA</strong> <br>
                                  (Deben de pagar <strong>S/. 3.00 por cada cr&eacute;dito</strong> que se matriculen) 
                                      <ol>
                                    <li>Los  que se <strong>matriculen en 2 &oacute; m&aacute;s Escuelas Profesionales simultaneamente .</strong> </li>
									<li>Los que <strong>desaprueben cursos</strong>.</li>
									<li>Los que<strong> han finalizado una Escuela Profesional y est&eacute;n matriculados en otra</strong>. </li>
									<li>Los que <strong>no conlcuyan sus estudios dentro del plazo establecido</strong>. </li>
                                  </ol></span></td>
                                  <td background="../images/ven_mediumright.jpg"></td>
                                </tr>
                                <tr>
                                  <td><img src="../images/ven_bottomleft.jpg" width="16" height="16" border="0" alt="" /></td>
                                  <td background="../images/ven_bottomcenter.jpg"></td>
                                  <td><img src="../images/ven_bottomright.jpg" width="16" height="16" border="0" alt="" /></td>
                                </tr>
                              </table> -->
							  <?
							  	if($_SESSION['sEstuano_aca'].$_SESSION['sEstuper_aca'] != '200901')
								{
							  ?>
							  <table border="0" cellpadding="0" cellspacing="0" class="tventana">
                                <tr>
                                  <td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
                                  <th background="../images/ven_topcenter.jpg">Cronograma de matr&iacute;culas [
                                      <?=$_SESSION['sFrameano_aca']?>
                                    -
                                    <?=$_SESSION['sFrameper_aca']?>
                                    ] </th>
                                  <td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
                                </tr>
                                <tr>
                                  <td background="../images/ven_mediumleft.jpg"></td>
                                  <td align="center">
								  <span class="wordi">A PARTIR DE ESTE SEMESTRE LAS MATR&Iacute;CULAS<strong><br>
								  </strong>SER&Aacute;N<strong> VIA INTERNET.</strong></span>
								  
								  <table border="0" cellpadding="0" cellspacing="0" class="tlistdata">
                                        <tr>
                                          <th width="220">Descripci&oacute;n</th>
                                          <th width="170">Fecha</th>
                                        </tr>
                                        
                                        <tr  <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)" >
                                          <td >Matricula (Ingresantes y Regulares) </td>
                                          <td ><strong>24 al 28 de agosto </strong></td>
                                        </tr>

                                        <tr <?=ftrstyle($vCont+1)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)" >
                                          <td>Rezagados</td>
                                          <td><strong>31 de agosto y 01 Setiembre </strong></td>
                                        </tr>
                                        
                                        <tr <?=ftrstyle($vCont+1)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)" >
                                          <td class="tdultimo">Inicio de Clases </td>
                                          <td class="tdultimo"><strong>31 de agosto </strong></td>
                                        </tr>
                                    </table>                                  </td>
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
							<th background="../images/ven_topcenter.jpg">Pago de matr&iacute;culas [<?=$_SESSION['sFrameano_aca']?> - <?=$_SESSION['sFrameper_aca']?>] </th>
							<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
						  </tr>
						  <tr>
							<td background="../images/ven_mediumleft.jpg"></td>
							<td align="center"> 
							<span class="wordi">El pago de cr&eacute;ditos desaprobados será en  cualquier Agencia 
							del<strong> BANCO DE <br />
							LA NACI&Oacute;N a Nivel Nacional.  
							</strong>Al momento de realizar el pago indique:<strong><br />
					&quot;Pago de Tasa educativa a la 
							Universidad Nacional del 
							Altiplano (TELEPROCESO), <br />
							</strong>en el concepto: <strong>MATR&Iacute;CULA REGULAR</strong> (Haga solo un pago)<strong>, <br />
							</strong>e indique el<strong> &quot;MONTO TOTAL  A PAGAR EN EL BANCO&quot; </strong>que aparece a continuaci&oacute;n<strong>&quot; </strong></span>
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
										//$vQuery .= "    num_mat = '{$_SESSION['sUsercod_usu']}' and (per_aca = '{$_SESSION['sEstuper_aca']}' or per_aca = '03')) ";
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
										
										// Rezagados
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
							<span class="wordi">Despu&eacute;s de realizar el pago de cr&eacute;ditos desaprobados realice su matr&iacute;cula<strong> <br>
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
						<br><br>
						<span class="wordi">Imagen actual para el <strong>Carn&eacute; Universitario 2009</strong></span>
						<br>
						<?
							if(!empty($_POST['rConfirmado']))
							{
								$vQuery = "update unap.picture2 set confirmado = '1' ";
								$vQuery .= "where num_mat = '{$_SESSION['sUsercod_usu']}' and cod_car = '{$_SESSION['sUsercod_car']}' ";
								$cr_Picture = fInupde($vQuery);
							}
							
							$vPicture = "";
							$vQuery = "select num_mat, confirmado from unap.picture2 ";
							$vQuery .= "where num_mat = '{$_SESSION['sUsercod_usu']}' and cod_car = '{$_SESSION['sUsercod_car']}' ";
							$cr_Picture = fQuery($vQuery);
							if ($ar_Picture = mysql_fetch_array($cr_Picture) )
							{
						?>
							<img src="std_viewimage.php" border="0" alt="" />
							<br><br>
						<?
								if($ar_Picture['confirmado'] == '0')
								{
						?>
								<form action="index.php" method="post" enctype="multipart/form-data" name="fData" id="fData">
								  <input name="rConfirmado" type="hidden" value="1">
								  <input name="button" type="submit" value="Confirmar imagen para el Carné Unviersitario 2009">
							  </form>
						<?
								}
								else
								{
						?>
								<span class="wordi">Imagen Confirmada para el <strong>Carn&eacute; Universitario 2009</strong>:</span>
						<?	
								}
							}
							else
							{
						?>
							<img src="sinimagen.jpg" border="0" alt="" />
						<?
							}
							
						?>
							</center>
						<?
							}
						?>
							
					  	</div>					</td>
				  </tr>
				</table>    
			</div>
			<? include "../include/foot1.php"; ?>	
		</td>
	  </tr>
	</table>
	</center>
</body>
</html>