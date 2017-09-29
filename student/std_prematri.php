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
		if(!empty($_POST['rOk']) and !empty($_SESSION['sEstusql_bol']))
		{
			$cResult = fInupde($_SESSION['sEstusql_bol']);
			$_SESSION['sEstusql_bol'] = "";
		}
	
		$bDatos = FALSE;
		//$_SESSION['sEstuult_mat']
		$vDet_deu = "";
		
		$_SESSION['sEstusem_anu'] = "";
		$_SESSION['sEstusem_des'] = "";
		$_SESSION['sEstumod_mat'] = "";
		$_SESSION['sEstumod_des'] = "";
		
		$_SESSION['sEstumax_crd'] = 0.00;	// Maximos de creditos
		$_SESSION['sEstumat_ok'] = FALSE; 	// Si tiene habilitada la opcion de matricula via Internet
		$_SESSION['sEstumat_okse'] = FALSE;	// Matricula seleccion de cursos
		
		$_SESSION['sEstumat_ya'] = FALSE;	// ya esta matriculado
		$_SESSION['sEstumat_deu'] = FALSE; 	// Tiene deuda
		$_SESSION['sEstumat_pag'] = FALSE;	// Pago de matricula
		
		$_SESSION['sEstutot_crd'] = 0.00;	// Total a creditos a matricularse
		$_SESSION['sEstucan_bol'] = 1;		// Cantidad de Boletas
		$_SESSION['sEstusql_bol'] = "";		// SQL de las boletas
		$_SESSION['sEstuall_crd'] = 0.00;	// Total de creditos aprobados
		
		
		
		//--------------- Verificar si ya se matriculo -----------
		$tEstumat = "estumat".$_SESSION['sUsercod_car'].$_SESSION['sFrameano_aca'];
		$vQuery = "select mod_mat ";
		$vQuery .= "from $tEstumat ";
		$vQuery .= "where num_mat = '{$_SESSION['sUsercod_usu']}' and per_aca = '{$_SESSION['sFrameper_aca']}' ";
		$cResult = fQuery($vQuery);
		if($aResult = mysql_fetch_array($cResult))
			$_SESSION['sEstumat_ya'] = TRUE;
		//-----------------------------------------------------------
		
		if($_SESSION['sUsercod_car'] == '37' and $_SESSION['sUsercon_est'] == '1')
		{
			$_SESSION['sEstumat_ok'] = TRUE;			
		}
		
		//--------- Escuelas que no tiene matriculas via Internet -------
		if($_SESSION['sUsercod_car'] == '04' or $_SESSION['sUsercod_car'] == '02' or $_SESSION['sUsercod_car'] == '27')
		{
			$_SESSION['sEstumat_ok'] = FALSE;
		}
		
		//------------------ Verifica si tiene deuda -----------------------------------------
		if($_SESSION['sEstumat_ok'] == TRUE and $_SESSION['sEstumat_ya'] == FALSE)	// Si todavia no registro matricula
		{
			$vQuery = "select det_deu from deudor where codigo = '{$_SESSION['sUsercod_usu']}' and est_deu = '0' ";
			$cResult = fQuerydeudor($vQuery);
			while($aResult = mysql_fetch_array($cResult))
			{
				$vDet_deu .= $aResult['det_deu']. " y ";
				$_SESSION['sEstumat_deu'] = TRUE;
			}

		}
		//-----------------------------------------------------------
		
		//-------------------- Verifica si pago en caja -------------------------------
		if($_SESSION['sEstumat_ok'] == TRUE and $_SESSION['sEstumat_ya'] == FALSE  and $_SESSION['sEstumat_deu'] == FALSE)	// Si no tiene deuda
		{
			$sTarifapago = "";
			$sVecesdes = "";
			
			//------------------------------------------------
			$vQuery = "Select cod_pag, mon_pag, vec_dsp from tarifapago ";
			$vQuery .= "where ano_aca = '{$_SESSION['sFrameano_aca']}' and per_aca = '{$_SESSION['sFrameper_aca']}' ";
			$cResult = fQuery($vQuery);
			while($aResult = mysql_fetch_array($cResult))
			{
				$sTarifapago[$aResult['cod_pag']] = $aResult['mon_pag'];
				$sVecesdes[$aResult['vec_dsp']] = $aResult['mon_pag'];
			}
			
			//-------------------------------------------------
			$sVeces = "";
			$vTot_pag = 8;	// Monto inicial, carne universitario
			$vTot_caj = 0;
			
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
				$vQuery .= "    num_mat = '{$_SESSION['sUsercod_usu']}' and per_aca = '{$_SESSION['sEstuper_aca']}' ) ";
				//$vQuery .= "    num_mat = '{$_SESSION['sUsercod_usu']}' and (per_aca = '{$_SESSION['sEstuper_aca']}' or per_aca = '03') ) ";
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
					$vTot_pag += $vCrd_cur*$sVecesdes[$vVec_dsp];
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
					$vTot_pag += $sTarifapago['26'];					
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
					$vTot_pag += ($sTarifapago['24'] * $vCan_pag);
				}
			}
			
			
			
			if($vTot_pag == 0)
				$_SESSION['sEstumat_pag'] = TRUE;	// Tiene pago
			else
			{	// Pago en Caja
				$vTot_caj = 0;
				$tPago = "pago".$_SESSION['sFrameano_aca'];	//Pago en Caja
				
				$vQuery = "Select mon_pag from $tPago ";
				$vQuery .= "where num_mat = '{$_SESSION['sUsercod_usu']}' and cod_car = '{$_SESSION['sUsercod_car']}' and ";
				$vQuery .= "per_aca = '{$_SESSION['sFrameper_aca']}' and  con_reb = '1' ";
				$cResult = fQuery($vQuery);
				while($aResult = mysql_fetch_array($cResult))
					$vTot_caj += $aResult['mon_pag'];
				
				if($vTot_pag <= $vTot_caj)
					$_SESSION['sEstumat_pag'] = TRUE;	// Tiene pago
				else
				{	// Pago en el Banco
					//$vTot_caj = 0;
					$tBanco = "banco".$_SESSION['sFrameano_aca'];	//Pago en Banco
				
					$vQuery = "Select imp_pag from $tBanco ";
					$vQuery .= "where num_mat = '{$_SESSION['sUsercod_usu']}' and ";
					$vQuery .= "per_aca = '{$_SESSION['sFrameper_aca']}' and concepto in('00000001','00000002','00000003', ";
					$vQuery .= "'00000004','00000005','00000006','00000008','00000009', '00000011','00000012','00000013', ";
					$vQuery .= "'00000014','00000015','00000016','00000017','00000018','00000019','00000020') ";
					$cResult = fQuery($vQuery);
					while($aResult = mysql_fetch_array($cResult))
						$vTot_caj += $aResult['imp_pag'];
						
					if(($vTot_pag + 0.60) <= $vTot_caj)
						$_SESSION['sEstumat_pag'] = TRUE;	// Tiene pago
					else
					{	// Registro de Boleta
						//$vTot_caj = 0;
						$tBoleta = "boleta".$_SESSION['sFrameano_aca'];	//Pago en Caja
					
						$vQuery = "Select imp_pag from $tBoleta ";
						$vQuery .= "where num_mat = '{$_SESSION['sUsercod_usu']}' and cod_car = '{$_SESSION['sUsercod_car']}' and ";
						$vQuery .= "per_aca = '{$_SESSION['sFrameper_aca']}' and est_bol = '1'  ";
						$cResult = fQuery($vQuery);
						while($aResult = mysql_fetch_array($cResult))
							$vTot_caj += $aResult['imp_pag'];
							
						if(($vTot_pag + 0.60) <= $vTot_caj)
							$_SESSION['sEstumat_pag'] = TRUE;	// Tiene pago
					}
				}
			}
			
		}
		
		//---------------------------------------------------
		
		
		if($_SESSION['sEstumat_ok'] == TRUE and $_SESSION['sEstuult_mat'] == TRUE and $_SESSION['sEstumat_ya'] == FALSE and $_SESSION['sEstumat_deu'] == FALSE and $_SESSION['sEstumat_pag'] == TRUE)
		{
			$tCurmat = "curmat".$_SESSION['sUsercod_car'].$_SESSION['sEstuano_aca'];
			$tNota = "nota".$_SESSION['sUsercod_car'];

			$vCrdapro = 0;
			$vCrddes = 0;
			$vCredito = 0;
			$vPuntaje = 0;			
			$vPromedio = 0;	
			$vCrdall = 0;
			
			$vCreditop = 0;
			$vPuntajep = 0;
			$vPromediop = 0;
			
			$vVeces = 0;
		
			//--------------- Total crd aprobados -----------
			$vQuery = "select sum(cu.crd_cur) as all_crd ";
			$vQuery .= "from $tNota no left join curso cu on ";
			$vQuery .= "no.cod_car = cu.cod_car and no.pln_est = cu.pln_est and no.cod_cur = cu.cod_cur ";
			$vQuery .= "where no.num_mat = '{$_SESSION['sUsercod_usu']}' and no.pln_est = '{$_SESSION['sEstupln_est']}' and ";
			$vQuery .= "no.cod_car = '{$_SESSION['sUsercod_car']}' and no.not_cur > 10";
			$cResult = fQuery($vQuery);
			if($aResult = mysql_fetch_array($cResult))
			{
				$_SESSION['sEstuall_crd'] = $vCrdall = $aResult['all_crd'];			
			}
			//-----------------------------------------------
			
			//------------- Créditos aprobados, promedio semestre actual--------------
			$vQuery = "Select no.cod_cur, cu.crd_cur, no.not_cur, no.mod_not ";
			$vQuery .= "from $tNota no left join curso cu on no.pln_est = cu.pln_est and no.cod_cur = cu.cod_cur ";
			$vQuery .= "and no.cod_car = cu.cod_car ";
			$vQuery .= "where no.num_mat = '{$_SESSION['sUsercod_usu']}' and ";
			$vQuery .= "no.ano_aca = '{$_SESSION['sEstuano_aca']}' and no.per_aca = '{$_SESSION['sEstuper_aca']}' ";
						
			$cResult = fQuery($vQuery);
			while($aResult = mysql_fetch_array($cResult))
			{
				if($aResult['mod_not'] == '01' or $aResult['mod_not'] == '10' or $aResult['mod_not'] == '11'
					or $aResult['mod_not'] == '07' or $aResult['mod_not'] == '14' or $aResult['mod_not'] == '15'
					or $aResult['mod_not'] == '16' or $aResult['mod_not'] == '17' or $aResult['mod_not'] == '18' or $aResult['mod_not'] == '19' 
 						or $aResult['mod_not'] == '20' or $aResult['mod_not'] == '21' or $aResult['mod_not'] == '22'
						or $aResult['mod_not'] == '23' or $aResult['mod_not'] == '24' or $aResult['mod_not'] == '25'
						or $aResult['mod_not'] == '26' or $aResult['mod_not'] == '27' or $aResult['mod_not'] == '28'
						or $aResult['mod_not'] == '29' or $aResult['mod_not'] == '30' or $aResult['mod_not'] == '31' )
				{
					if($aResult['not_cur'] >= 11)
						$vCrdapro += $aResult['crd_cur'];
					
					$vCredito += $aResult['crd_cur'];
					$vPuntaje += $aResult['crd_cur'] * $aResult['not_cur'];
				}
			}			
			if ($vCredito)
				$vPromedio = $vPuntaje / $vCredito;	
			//-------------------------------------------------------
			
			//----------------------Créditos desaprobados--------------
			$vQuery = "Select sum(cu.crd_cur) as crd_des ";
			$vQuery .= "from $tNota no left join curso cu on no.pln_est = cu.pln_est and ";
			$vQuery .= "no.cod_cur = cu.cod_cur and no.cod_car = cu.cod_car ";
			$vQuery .= "where no.num_mat = '{$_SESSION['sUsercod_usu']}' and no.ano_aca = '{$_SESSION['sEstuano_aca']}' and ";
			$vQuery .= "no.per_aca = '{$_SESSION['sEstuper_aca']}' and no.not_cur < 11 and no.pln_est = '{$_SESSION['sEstupln_est']}' and ";
			$vQuery .= "no.mod_not != '13' and no.mod_not != '08' and ";
			$vQuery .= "no.cod_cur not in (Select cod_cur from $tNota where pln_est = '{$_SESSION['sEstupln_est']}' and ";
			$vQuery .= "num_mat = '{$_SESSION['sUsercod_usu']}' and  not_cur > 10)";
			$cResult = fQuery($vQuery);
			if($aResult = mysql_fetch_array($cResult))
				$vCrddes = $aResult['crd_des'];
			if(empty($vCrddes))
				$vCrddes = 0.00;
				
			//-------------------------------------------------------
			
			//------- Créditos aprobados, promedio semestre anterior--------------
			if($_SESSION['sEstupen_mat'] == TRUE)
			{
				$vQuery = "Select no.cod_cur, cu.crd_cur, no.not_cur, no.mod_not ";
				$vQuery .= "from $tNota no left join curso cu on no.pln_est = cu.pln_est and no.cod_cur = cu.cod_cur ";
				$vQuery .= "and no.cod_car = cu.cod_car ";
				$vQuery .= "where no.num_mat = '{$_SESSION['sUsercod_usu']}' and ";
				$vQuery .= "no.ano_aca = '{$_SESSION['sEstuano_acap']}' and no.per_aca = '{$_SESSION['sEstuper_acap']}' ";
				$cResult = fQuery($vQuery);
				while($aResult = mysql_fetch_array($cResult))
				{
					if($aResult['mod_not'] == '01' or $aResult['mod_not'] == '10' or $aResult['mod_not'] == '11'
						or $aResult['mod_not'] == '07' or $aResult['mod_not'] == '14' or $aResult['mod_not'] == '15'
						or $aResult['mod_not'] == '16' or $aResult['mod_not'] == '17' or $aResult['mod_not'] == '18' or $aResult['mod_not'] == '19' 
 						or $aResult['mod_not'] == '20' or $aResult['mod_not'] == '21' or $aResult['mod_not'] == '22'
						or $aResult['mod_not'] == '23' or $aResult['mod_not'] == '24' or $aResult['mod_not'] == '25'
						or $aResult['mod_not'] == '26' or $aResult['mod_not'] == '27' or $aResult['mod_not'] == '28'
						or $aResult['mod_not'] == '29' or $aResult['mod_not'] == '30' or $aResult['mod_not'] == '31'  )
					{
						$vCreditop += $aResult['crd_cur'];
						$vPuntajep += $aResult['crd_cur'] * $aResult['not_cur'];
					}
				}
				if ($vCreditop)
					$vPromediop = $vPuntajep / $vCreditop;	
			}
			//-------------------------------------------------------
			
			//-----------------Veces que desaprobo los cursos---------
			$vQuery = "Select no.cod_cur, count(*) as veces ";
			$vQuery .= "from $tNota no left join curso cu on ";
			$vQuery .= "no.cod_car = cu.cod_car and no.pln_est = cu.pln_est and no.cod_cur = cu.cod_cur ";
			$vQuery .= "where no.pln_est = '{$_SESSION['sEstupln_est']}' and ";
			$vQuery .= "no.num_mat = '{$_SESSION['sUsercod_usu']}' and no.not_cur < 11 and ";
			$vQuery .= "(no.mod_not != '13' and no.mod_not != '08') and ";
			$vQuery .= "(cu.tip_cur = '01' or cu.tip_cur = '03') and ";
			$vQuery .= "(cu.cod_esp = '00' or cu.cod_esp = '{$_SESSION['sEstucod_esp']}') and ";
			$vQuery .= "cu.con_cur = '1' and no.cod_cur not in ";
			$vQuery .= "(Select cod_cur from $tNota where pln_est = '{$_SESSION['sEstupln_est']}' and ";
			$vQuery .= "num_mat = '{$_SESSION['sUsercod_usu']}' and not_cur > 10) group by cod_cur order by veces desc";
		
			$cResult = fQuery($vQuery);
			if($aResult = mysql_fetch_array($cResult))
				$vVeces = $aResult['veces'];		
			//--------------------------------------------------------
			
			//------------Obteniendo el Semestre, Modalidad y creditos---------			
			fModestumat($vVeces, $vPromedio, $vPromediop, $vCrdapro, $vCrddes, $vCrdall);
			//--------------------------------------------------------
			
			$bDatos = TRUE;
		}						
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($_SESSION['sEstumat_ok'] == TRUE and $_SESSION['sEstumat_ya'] == FALSE and $_SESSION['sEstumat_deu'] == FALSE and $_SESSION['sEstumat_pag'] == TRUE)
	{
?>
<center>
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Datos del estudiante</th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
			  <tr>
				<td width="100">Estudiante : </td>
				<th width="300"><?=$_SESSION['sUsercod_usu']?> - <?=$_SESSION['sUserpaterno']?> <?=$_SESSION['sUsermaterno']?>, <?=$_SESSION['sUsernombres']?></th>
			  </tr>
			  
			  <tr>
			    <td>Escuela Prof.  : </td>
			    <th><?=$_SESSION['sUsercar_des']?></th>
		      </tr>
			  <tr>
			    <td>Menci&oacute;n : </td>
			    <th><?=$_SESSION['sEstuesp_nom']?></th>
		      </tr>
			  <tr>
			    <td>Total Cr&eacute;ditos : </td>
			    <th><?=$vCrdall?> Cr&eacute;ditos aprobados </th>
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
        <th background="../images/ven_topcenter.jpg">Matricula Anterior [<?=$_SESSION['sEstuano_aca']?> - <?=$_SESSION['sEstuper_aca']?>] </th>
        <td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
      </tr>
      <tr>
        <td background="../images/ven_mediumleft.jpg"></td>
        <td align="center"><table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
            <tr>
              <td width="100">Modalidad : </td>
              <th width="300"><?=$_SESSION['sEstumod_desp']?></th>
            </tr>
            <tr>
              <td>Cr&eacute;ditos matric. </td>
              <th><?=$_SESSION['sEstutot_crdp']?> cr&eacute;ditos </th>
            </tr>
            <tr>
              <td>Situaci&oacute;n cr&eacute;ditos : </td>
              <th><?=$vCrdapro?> crd. aprobados y <?=$vCrddes?> crd. desaprobados</th>
            </tr>
            <tr>
              <td>Prom. Pond. Semes. </td>
              <th><?=round($vPromedio, 2)?></th>
            </tr>
            <tr>
              <td>P.P.S. [<?=$_SESSION['sEstuano_acap']?> - <?=$_SESSION['sEstuper_acap']?>] </td>
              <th><?=round($vPromediop, 2)?></th>
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
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
      <tr>
        <td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
        <th background="../images/ven_topcenter.jpg">Matricula Actual [<?=$_SESSION['sFrameano_aca']?> - <?=$_SESSION['sFrameper_aca']?>] </th>
        <td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
      </tr>
      <tr>
        <td background="../images/ven_mediumleft.jpg"></td>
        <td align="center"><table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
            <tr>
              <td width="100">Semestre : </td>
              <th width="300"><?=$_SESSION['sEstusem_des']?></th>
            </tr>
            <tr>
              <td>Modalidad : </td>
              <th><?=$_SESSION['sEstumod_des']?></th>
            </tr>
            <tr>
              <td>M&aacute;ximo cr&eacute;ditos </td>
              <th><?=$_SESSION['sEstumax_crd']?> cr&eacute;ditos </th>
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
	
	<table border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td>
		<?
			//$_SESSION['sEstupln_est']	$_SESSION['sFrameano_aca']	$_SESSION['sFrameper_aca']	$_SESSION['sUsercod_car']	$_SESSION['sEstusem_anu']
			$vPln_estok = $_SESSION['sEstupln_est'];
			$vQuery = "select pln_est from habiplansem ";
			$vQuery .= "where ano_aca = '{$_SESSION['sFrameano_aca']}' and per_aca = '{$_SESSION['sFrameper_aca']}' and ";
			$vQuery .= "cod_car = '{$_SESSION['sUsercod_car']}' and sem_anu = '{$_SESSION['sEstusem_anu']}' ";
			
			$cResult = fQuery($vQuery);
			if($aResult = mysql_fetch_array($cResult))
			{
				$vPln_estok = $aResult['pln_est'];
			}
			
			if($vPln_estok != $_SESSION['sEstupln_est'])
			{
				$_SESSION['sEstumat_ok'] = FALSE;
		?>
				<center><span class="wordi"><strong>
				  USTED EST&Aacute; AFECTADO POR UN NUEVO PLAN DE ESTUDIOS, <br />
				  APERSONESE A COORDINACI&Oacute;N ACAD&Eacute;MICA PARA REALIZAR SU MATR&Iacute;CULA.</strong></span></center>
		<?
			}
			else
			{
		?>
			<div class="dboton"><a href="" onclick = "std_selectcurso(); return false;" class="icontinue" title="Continuar">Continuar</a></div>			
		<?
			}
		?>
		</td>
	  </tr>
	</table>
</center>
<?
	}
	elseif($_SESSION['sEstumat_ya'] == TRUE)
	{
		$_SESSION['sEstumat_ok'] = FALSE;
		$_SESSION['sEstumat_okse'] = FALSE;
		include "std_viewmatri.php";
	}
	elseif($_SESSION['sEstumat_ok'] == FALSE)
	{
		$_SESSION['sEstumat_ok'] = FALSE;
		$_SESSION['sEstumat_okse'] = FALSE;
?>
<center>
	<span class="wordi"><strong>
  LAS MATR&Iacute;CULAS V&Iacute;A INTERNET AUN NO SE ENCUENTRAN HABILITADAS
  . </strong></span>
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
								  </strong>SER&Aacute;N<strong> VIA INTERNET, </strong>YA NO EN COORDINACI&Oacute;N ACAD&Eacute;MICA<strong>. </strong></span>
								  
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
	elseif($_SESSION['sEstumat_deu'] == TRUE)
	{
		$_SESSION['sEstumat_ok'] = FALSE;
		$_SESSION['sEstumat_okse'] = FALSE;
?>
<center>
	<span class="wordi"><strong>USTED ES DEUDOR A LA UNIVERSIDAD. <br />
  CANCELE SU DEUDA PARA PODER REALIZAR LA MATR&Iacute;CULA. </strong></span>
  
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
	elseif($_SESSION['sEstumat_pag'] == FALSE)
	{
		$_SESSION['sEstumat_ok'] = FALSE;
		$_SESSION['sEstumat_okse'] = FALSE;
?>
<center>
	<span class="wordi"><strong>USTED NO PAGO SU MATR&Iacute;CULA EN CAJA O EN EL BANCO 
  APERSONECE AL BANCO A REALIZAR SU PAGO. </strong></span>  
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
      <tr>
        <td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
        <th background="../images/ven_topcenter.jpg">Pago de matr&iacute;culas [<?=$_SESSION['sFrameano_aca']?> - <?=$_SESSION['sFrameper_aca']?>] </th>
        <td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
      </tr>
      <tr>
        <td background="../images/ven_mediumleft.jpg"></td>
        <td align="center"><table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
            <tr>
              <td width="100">Debe pagar  :</td>
              <th width="150"><?=($vTot_pag + 0.60)?> nuevos soles </th>
			  <td width="100">Pago caja-banco : </td>
              <th width="150"><?=$vTot_caj?> nuevos soles </th>
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

	<form action="#" method="post" enctype="multipart/form-data" name="fData" id="fData">
	<div id="dboleta0">
	<span class="wordi"><strong>EN EL CASO DE HABER PAGADO EN EL BANCO EL D&Iacute;A DE HOY,  
	REGISTRE SU(S) BOLETA(S) AQUI. </strong></span><br />
	<img src="../images/boletabn.JPG" alt="Ejemplo" longdesc="Ejemplo del Comprobante de pago" />
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Boleta(s) de pago del Banco de la Naci&oacute;n </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center"><div id="dsilabo">
		  <table border="0" cellpadding="0" cellspacing="0" bordercolor="#FF0000" class="tlistdata">
			  <tr>
				<th  width="300"  colspan="2">Cantidad : 
				  <select name="rCan_bol" id="rCan_bol" onchange="std_prematribol(this.value); return false;" >
					<option value="1" <?=($_SESSION['sEstucan_bol']=='1'?'Selected':'')?>>1</option>
					<option value="2" <?=($_SESSION['sEstucan_bol']=='2'?'Selected':'')?>>2</option>
					<option value="3" <?=($_SESSION['sEstucan_bol']=='3'?'Selected':'')?>>3</option>
					<option value="4" <?=($_SESSION['sEstucan_bol']=='4'?'Selected':'')?>>4</option>
					<option value="5" <?=($_SESSION['sEstucan_bol']=='5'?'Selected':'')?>>5</option>
					<option value="6" <?=($_SESSION['sEstucan_bol']=='6'?'Selected':'')?>>6</option>
				  </select> 
				  <span class="wordi">(Seleccione la cantidad) </span></th>
			  </tr>             
			</table>
			<div id="dboleta">
				<? include "std_prematribol.php"; ?>
			</div>
			</div></td>
		<td background="../images/ven_mediumright.jpg"></td>
	  </tr>
	  <tr>
		<td><img src="../images/ven_bottomleft.jpg" width="16" height="16" border="0" alt="" /></td>
		<td background="../images/ven_bottomcenter.jpg"></td>
		<td><img src="../images/ven_bottomright.jpg" width="16" height="16" border="0" alt="" /></td>
	  </tr>
	</table>
		
	<table border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td>
			<div class="dboton"><a href="" onclick = "std_viewboleta(document.fData); return false;" class="icontinue" title="Continuar">Continuar</a></div>			
		</td>
	  </tr>
	</table>
	</div>
	</form>
	
</center>
<?
	}
?>