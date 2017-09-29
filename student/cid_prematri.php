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
		$bMatri = FALSE;
		$bFinal = FALSE;
		
		if ($_SESSION['sCidopen'] == TRUE)
		{
			$vTiempo = 0;
			$vQuery = "select cod_gpo from matriculas where codigo = '{$_SESSION['sCidnum_mat']}' and ";
			$vQuery .= "anio = '{$_SESSION['sCidano']}' and cod_mes = '{$_SESSION['sCidmes']}' ";
			$cResult = fQueryi($vQuery);
			if($aResult = mysql_fetch_array($cResult))
			{
				$bMatri = TRUE;
			}
			
			$_SESSION["sCidhra_ini"] = "";
			$_SESSION["sCidhra_fin"] = "";
			$_SESSION["sCidcod_sec"] = "";
			$_SESSION["sCidcod_cur"] = "";
			$_SESSION["sCidcod_con"] = "";
			$_SESSION["sCidtip_pag"] = "";	
			
			$vQuery = "select mat.*, esp.des_esp, esp.nom_esp, concat(doc.nombres, ' ', doc.paterno, ' ', doc.materno) as nom_doc, ";
			$vQuery .= "cur.des_cur, cur.nivel, sec.des_sec, hr1.des_hra as dhra_ini, hr2.des_hra as dhra_fin ";
			$vQuery .= "from (Select ma.*, gp.cod_esp, gp.cod_aul, gp.cod_doc, gp.cod_cur, gp.cod_sec, gp. hra_ini, gp.hra_fin, ";
			$vQuery .= "me.des_mes, co.des_con, pg.des_pag ";
			$vQuery .= "from (select ma.num_mat, ma.anio, ma.cod_mes, ma.num_rec, ma.fch_mat, ma.cod_usu, ma.cod_con, ";
			$vQuery .= "ma.imp_pag, ma.cod_gpo, ma.tip_pag, ma.escrito, ma.oral, round((ma.escrito + ma.oral)/2) as final, ";
			$vQuery .= "ma.flg_mat, ma.fch_hra, ma.codigo ";
			$vQuery .= "from matriculas ma where ma.codigo = '{$_SESSION['sCidnum_mat']}' order by  ma.anio desc, ma.cod_mes desc ";
			$vQuery .= "limit 1) ma ";
			$vQuery .= "left join gruposhab gp on ma.cod_gpo = gp.cod_gpo  left join meses me on ma.cod_mes = me.cod_mes ";
			$vQuery .= "left join condicionest co on ma.cod_con = co.cod_con  left join tipopago pg on ma.tip_pag = pg.tip_pag) mat ";
			$vQuery .= "left join especialidades esp on mat.cod_esp = esp.cod_esp  left join docentes doc on mat.cod_doc = doc.cod_doc ";
			$vQuery .= "left join cursos cur on mat.cod_cur = cur.cod_cur  left join seccion sec on mat.cod_sec = sec.cod_sec ";
			$vQuery .= "left join horas hr1 on mat.hra_ini = hr1.cod_hra  left join horas hr2 on mat.hra_fin = hr2.cod_hra ";
			
			$cResult = fQueryi($vQuery);
			if($aResult = mysql_fetch_array($cResult))
			{
				if($bMatri == FALSE)
				{
					$_SESSION["sCidhra_ini"] = $aResult['hra_ini'];
					$_SESSION["sCidhra_fin"] = $aResult['hra_fin'];
					$_SESSION["sCidcod_sec"] = $aResult['cod_sec'];
					
					/*if($aResult['nivel'] >= $_SESSION["sCiddur_esp"])
					{
						$_SESSION["sCidcod_cur"] = fNextcur($aResult['cod_esp'], 1);
						$bFinal = TRUE;
					}
					else
					{
						if($aResult['cod_con'] == '1' && $aResult['final'] >= 75)
							$_SESSION["sCidcod_cur"] = fNextcur($aResult['cod_esp'], $aResult['nivel'] + 1);
						else
							$_SESSION["sCidcod_cur"] = $aResult['cod_cur'].$aResult['des_cur'];
					}
					
					$_SESSION["sCiddes_cur"] = substr($_SESSION["sCidcod_cur"], 3, strlen($_SESSION["sCidcod_cur"]) - 3);
					$_SESSION["sCidcod_cur"] = substr($_SESSION["sCidcod_cur"], 0, 3);
					
					$_SESSION["sCidcod_con"] = $aResult['cod_con'];
					$_SESSION["sCidtip_pag"] = $aResult['tip_pag'];*/
					
					$vTiempo = 0;
					if($aResult['anio'] == $_SESSION['sCidano'])
					{
						$vTiempo = $_SESSION['sCidmes'] - $aResult['cod_mes'] - 1;				
					}
					elseif($aResult['anio'] < $_SESSION['sCidano'])
					{
						$vTiempo = (($_SESSION['sCidano'] - $aResult['anio'] - 1) * 12) + (12 - $aResult['cod_mes']) + $_SESSION['sCidmes'];
					}
					
					$_SESSION["sCidcod_cur"] = $aResult['cod_cur'];
					if($vTiempo <= 3)
					{
						if($aResult['nivel'] >= $_SESSION["sCiddur_esp"] and $aResult['final'] >= 75)
						{
							$_SESSION["sCidcod_cur"] = fNextcur($aResult['cod_esp'], 1);
							$bFinal = TRUE;
						}
						else
						{
							if($aResult['cod_con'] == '1' && $aResult['final'] >= 75)
								$_SESSION["sCidcod_cur"] = fNextcur($aResult['cod_esp'], $aResult['nivel'] + 1);
							else
								$_SESSION["sCidcod_cur"] = fNextcur($aResult['cod_esp'], $aResult['nivel']);//$aResult['cod_cur'];
						}
						$_SESSION["sCidcod_con"] = '1';
					}
					elseif($vTiempo > 3 and $vTiempo <= 12)
					{
						if($aResult['cod_con'] == '1' && $aResult['final'] >= 75)
						{
							$_SESSION["sCidcod_cur"] = $aResult['cod_cur'];
						}
						elseif($aResult['cod_con'] == '1' && $aResult['final'] < 75)
						{
							$_SESSION["sCidcod_cur"] = fNextcur($aResult['cod_esp'], $aResult['nivel'] - 1);
						}
						elseif($aResult['cod_con'] == '2')
						{
							$_SESSION["sCidcod_cur"] = $aResult['cod_cur'];
						}
						else
						{
							$_SESSION["sCidcod_cur"] = fNextcur($aResult['cod_esp'], $aResult['nivel'] - 1);
						}
						$_SESSION["sCidcod_con"] = '2';				
					}
					elseif($vTiempo > 12)
					{
						if($aResult['cod_con'] == '1' && $aResult['final'] >= 75)
						{
							$_SESSION["sCidcod_cur"] = $aResult['cod_cur'];
						}
						elseif($aResult['cod_con'] == '1' && $aResult['final'] < 75)
						{
							$_SESSION["sCidcod_cur"] = fNextcur($aResult['cod_esp'], $aResult['nivel'] - 1);
						}
						elseif($aResult['cod_con'] == '2')
						{
							$_SESSION["sCidcod_cur"] = $aResult['cod_cur'];
						}
						$_SESSION["sCidcod_con"] = '4';
					}
					$_SESSION["sCiddes_cur"] = substr($_SESSION["sCidcod_cur"], 3, strlen($_SESSION["sCidcod_cur"]) - 3);
					$_SESSION["sCidcod_cur"] = substr($_SESSION["sCidcod_cur"], 0, 3);
					$_SESSION["sCidtip_pag"] = $aResult['tip_pag'];
				}
				$bDatos = TRUE;
			}
		}
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
		<th background="../images/ven_topcenter.jpg">Matricula <?=($bMatri == FALSE?"Anterior":"Realizada")?> </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
			  <tr>
				<td width="75">C&oacute;digo :</td>
				<th width="150"><?=$aResult['codigo']?></th>
				<td width="75">Condici&oacute;n : </td>
				<th width="150"><?=$aResult['des_tip']?></th>
			  </tr>
			  <tr>
				<td>Nombres :</td>
				<th colspan="3"><?=$_SESSION['sUserpaterno']?> <?=$_SESSION['sUsermaterno']?>, <?=$_SESSION['sUsernombres']?></th>
			  </tr>
			  
			  <tr>
			    <td>A&ntilde;o - Mes  :</td>
			    <th><?=$aResult['anio']?> - <?=$aResult['des_mes']?></th>
			    <td>Especialidad : </td>
			    <th><?=$aResult['des_esp']?></th>
		      </tr>
			  <tr>
			    <td>Curso : </td>
			    <th><?=$aResult['des_cur']?></th>
			    <td>Hora - Grupo  :</td>
			    <th><?=$aResult['dhra_ini']?> - <?=$aResult['dhra_fin']?> - [ <?=$aResult['des_sec']?> ]</th>
		      </tr>
			  <tr>
			    <td>Condici&oacute;n :</td>
			    <th><?=$aResult['des_con']?></th>
		        <td>Tipo pago :</td>
		        <th><?=$aResult['des_pag']?></th>
			  </tr>
			  <tr>
			    <td>Recibo - Monto :</td>
			    <th><?=$aResult['num_rec']?> - [ S/. <?=$aResult['imp_pag']?> ]</th>
			    <td>Nota : </td>
			    <th <?=ftdstylenota(1, 2, $aResult['final'])?>><?=$aResult['final']?></th>
		      </tr>
			  <tr>
			    <td>Docente</td>
			    <th colspan="3"><?=$aResult['nom_doc']?></th>
		      </tr>
			  <tr>
			    <td>Condici&oacute;n</td>
			    <th colspan="3">El Estudiante se ha matriculado hace: <?=$vTiempo?> meses</th>
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
<?
		if($bMatri == FALSE and $bFinal == FALSE and $vTiempo <= 12 and $aResult['final'] > 0)
		{
	?>			
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td>
				<div class="dboton"><a href="" onClick = "cid_getdatamatri();  return false;" class="icontinue" title="Modificar Datos">Continuar</a></div>			
			</td>
		  </tr>
		</table>
	<?
		}
		else
		{
	?>
		<center>
		<span class="wordi"> USTED NO PUEDE REALIZAR SU MATR&Iacute;CULA V&Iacute;A INTERNET POR QUE NO CUMPLE LAS CONDICIONES </span>
		</center>
	<?
		}
?>
</center>
<?
	}
	else
	{
?>
		<center>
		<span class="wordi"> EL PROCESO DE MATR&Iacute;CULAS NO SE ENCUENTRA HABILITADO </span>
		</center>
<?
		
	}
?>
