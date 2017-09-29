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

                //$vQuery = "select ano_aca, per_aca, num_mat, cod_car, pln_est from estumat2009all where num_mat = '082337'";

                $vQuery = "select ano_aca, per_aca, num_mat, cod_car, pln_est ";
                $vQuery .= "from estumat2009all ";

                //$vQuery .= "where num_mat in (select num_mat from estudiante where num_mat like '08%' and num_mat > '082335')";

                $cResulte = fQuery($vQuery);
                while($aResulte = mysql_fetch_array($cResulte))
                {
                    $_SESSION['sEstuult_mat'] = '';
                    $_SESSION['sEstuult_per'] = '';
                    $vQuery = "select ult_mat, ult_per from estudiante where num_mat = '{$aResulte['num_mat']}'";
                    $cResulta = fQuery($vQuery);
                    if($aResulta = mysql_fetch_array($cResulta))
                    {
                        $_SESSION['sEstuult_mat'] = $aResulta['ult_mat'];
                        $_SESSION['sEstuult_per'] = $aResulta['ult_per'];
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
			if(!empty($_SESSION['sEstuult_mat']))
			{
				$tCurmat = "curmat".$aResulte['cod_car'].$_SESSION['sEstuult_mat'];
                                $tNota = "nota".$aResulte['cod_car'];
				
				$vQuery = "Select no.cod_cur, cu.crd_cur, count(*) as veces ";
				$vQuery .= "from $tNota no left join curso cu on ";
				$vQuery .= "   no.cod_car = cu.cod_car and no.pln_est = cu.pln_est and no.cod_cur = cu.cod_cur ";
				$vQuery .= "where no.pln_est = '{$aResulte['pln_est']}' and no.num_mat = '{$aResulte['num_mat']}' and ";
				$vQuery .= "no.not_cur < 11 and (no.mod_not != '13' and no.mod_not != '08') and ";
				$vQuery .= "no.cod_car = '{$aResulte['cod_car']}' and no.cod_cur not in ";
				$vQuery .= "   (Select cod_cur from $tNota where pln_est = '{$aResulte['pln_est']}' and ";
				$vQuery .= "    num_mat = '{$aResulte['num_mat']}' and not_cur > 10) ";
				$vQuery .= "and no.cod_cur in ";
				$vQuery .= "   (Select cod_cur from $tCurmat where pln_est = '{$aResulte['pln_est']}' and ";
				$vQuery .= "    num_mat = '{$aResulte['num_mat']}' and per_aca = '{$_SESSION['sEstuult_per']}' ) ";
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
			
			//--------------------------------------------------------			
			//-----------------Anmistia-------------------------------
			$vCan_pag = 0;
			if($_SESSION['sEstuult_mat'] != '2009')
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
			
                    $vQuery = "insert into devolucion values ('{$aResulte['num_mat']}', '{$aResulte['cod_car']}', '$vTot_pag') ";
                    $cResult = fInupde($vQuery);
                    $aResult = mysql_fetch_array($cResult);
			
		}
		
		//---------------------------------------------------
		
			
			$bDatos = TRUE;
		
	}
	else
	{
		header("Location:../index.php");
	}
	
	
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
              <th width="150"><?=($vTot_pag )?> nuevos soles </th>
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
