<STYLE type=text/css>
@import url( ../css/main.css );
@import url( ../css/frame.css );
@import url( ../css/framelogin.css );
@import url( ../css/style.css );
</STYLE>

<?
	session_start();
	include "../include/funcget.php";
	include "../include/funcoption.php";
	include "../include/funcsql.php";
	include "../include/funcstyle.php";
	if(fsafetylogin())
	{
		$bDatos = FALSE;
		$vCont = 1;
		
		if(!empty($_POST['rClave']))
		{
			$vSem_anu = substr($_POST['rClave'], 0, 2);
			$vSec_gru = substr($_POST['rClave'], 2, 2);
			$vCod_esp = substr($_POST['rClave'], 4, 2);
			
			$tHora = "hora".$_SESSION['sUsercod_car'].$_SESSION['sFrameano_aca'];
			
			$sCodhora = "";
			$sColor = "";
			$sCurcolor = "";
			
			$vQuery = "Select cod_hor, hrs_ini, hrs_fin from codhora where cod_hor != ''";
			$cResult = fQuery($vQuery);
			while($aResult = mysql_fetch_array($cResult))
				$sCodhora[$aResult['cod_hor']] = $aResult['hrs_ini']." - ".$aResult['hrs_fin'];
			
			$bDatos = TRUE;
			
			$sColor[1] = "#FFBFBF"; //rojo
			$sColor[2] = "#D2D2FF"; //azul
			$sColor[3] = "#FFFFCE"; //anarillo
			$sColor[4] = "#D5FFD5"; //verde
			$sColor[5] = "#DFDFDF"; //plomo
			$sColor[6] = "#FFDFBF"; //anaranjado
			$sColor[7] = "#CCFFFF"; //celeste
			$sColor[8] = "#DDBBFF"; //morado
			$sColor[9] = "#9ECFCF"; //cian
			$sColor[10] = "#E1C4C4"; //cafe		
			$sColor[10] = "#D1D1A5"; //ultimo
			
			//-------------------------------------------------------
			$vQuery = "select distinct cu.cod_cur from curso cu ";
			$vQuery .= "left join $tHora ho on cu.cod_car = ho.cod_car and cu.pln_est = ho.pln_est and ";
			$vQuery .= "cu.cod_cur = ho.cod_cur ";
			$vQuery .= "where cu.cod_car = '{$_SESSION['sUsercod_car']}' and cu.pln_est = '{$_SESSION['sEstupln_est']}' and ";
			$vQuery .= "cu.sem_anu = '$vSem_anu' and (cu.cod_esp = '$vCod_esp' or cu.cod_esp = '00') and ";
			$vQuery .= "ho.sec_gru = '$vSec_gru' and ho.per_aca = '{$_SESSION['sFrameper_aca']}' order by cod_cur";
			$cResult = fQuery($vQuery);
			while($aResult = mysql_fetch_array($cResult))		  		
			{
				$sCurcolor[$aResult['cod_cur']] = $sColor[$vCont];
				$vCont++;
			}
			
			//-------------------------------------------------------	
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
	<table border="0" cellpadding="0" cellspacing="0" class="tventana" bgcolor="#D1D1A5">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Horario de clases </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center"><table border="0" cellspacing="0" cellpadding="0" class="tlistsearch">
          <tr>
            <th width="60">Hora</th>
            <th width="50">Lunes</th>
            <th width="50">Martes</th>
            <th width="50">Mierc.</th>
            <th width="50">Jueves</th>
            <th width="50">Viernes</th>
            <th width="50">S&aacute;bado</th>
            <th width="50">Dom.</th>
          </tr>
          	<?
				$vCont = 1;
				$sHorario = "";
				$vQuery = "Select cu.cod_cur, ho.cod_dia, ho.cod_hor ";
				$vQuery .= "from $tHora ho left join curso cu on ho.cod_car = cu.cod_car and ho.pln_est = cu.pln_est and ";
				$vQuery .= "ho.cod_cur = cu.cod_cur ";
				$vQuery .= "where ho.per_aca ='{$_SESSION['sFrameper_aca']}' and ho.sec_gru = '$vSec_gru' and ";
				$vQuery .= "ho.pln_est = '{$_SESSION['sEstupln_est']}' and cu.sem_anu = '$vSem_anu' and ";
				$vQuery .= "(cu.cod_esp = '$vCod_esp' or cu.cod_esp = '00') order by cod_hor";
				$cResult = fQuery($vQuery);
				while($aResult = mysql_fetch_array($cResult))
		  			$sHorario[$aResult['cod_hor']][$aResult['cod_dia']] = $aResult['cod_cur'];
					
				if(!empty($sHorario)) foreach($sHorario as $vCod_hor => $aHorario)
				{
			?>
          <tr <?=ftrstyle($vCont)?> >
            <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$sCodhora[$vCod_hor]?></td>
            <td <?=ftdstyle($vNum_rows, $vCont)?> bgcolor="<?=$sCurcolor[$aHorario['1']]?>"><?=$aHorario['1']?></td>
            <td <?=ftdstyle($vNum_rows, $vCont)?> bgcolor="<?=$sCurcolor[$aHorario['2']]?>"><?=$aHorario['2']?></td>
            <td <?=ftdstyle($vNum_rows, $vCont)?> bgcolor="<?=$sCurcolor[$aHorario['3']]?>"><?=$aHorario['3']?></td>
            <td <?=ftdstyle($vNum_rows, $vCont)?> bgcolor="<?=$sCurcolor[$aHorario['4']]?>"><?=$aHorario['4']?></td>
            <td <?=ftdstyle($vNum_rows, $vCont)?> bgcolor="<?=$sCurcolor[$aHorario['5']]?>"><?=$aHorario['5']?></td>
            <td <?=ftdstyle($vNum_rows, $vCont)?> bgcolor="<?=$sCurcolor[$aHorario['6']]?>"><?=$aHorario['6']?></td>
            <td <?=ftdstyle($vNum_rows, $vCont)?> bgcolor="<?=$sCurcolor[$aHorario['7']]?>"><?=$aHorario['7']?></td>
          </tr>
          <?
					$vCont++;
				}
			?>
        </table>
		<table border="0" cellspacing="0" cellpadding="0" class="tlistdata">
          <tr>
            <th width="30">Cod.</th>
            <th width="330">Nombre de curso </th>
            <th width="200">Docente</th>
          </tr>
          	<?
				$vCont = 1;
				$vQuery = "select distinct cu.cod_cur, cu.nom_cur from curso cu ";
				$vQuery .= "left join $tHora ho on cu.cod_car = ho.cod_car and cu.pln_est = ho.pln_est and ";
				$vQuery .= "cu.cod_cur = ho.cod_cur ";
				$vQuery .= "where cu.cod_car = '{$_SESSION['sUsercod_car']}' and cu.pln_est = '{$_SESSION['sEstupln_est']}' and ";
				$vQuery .= "cu.sem_anu = '$vSem_anu' and (cu.cod_esp = '$vCod_esp' or cu.cod_esp = '00') and ";
				$vQuery .= "ho.sec_gru = '$vSec_gru' and ho.per_aca = '{$_SESSION['sFrameper_aca']}' order by cod_cur";
				$cResult = fQuery($vQuery);
				$vNum_rows = fCountq($cResult);
				while($aResult = mysql_fetch_array($cResult))		  		
				{
			?>
          <tr <?=ftrstyle($vCont)?>  onmouseover="mouseover(this)" onmouseout="mouseout(this)">
            <td <?=ftdstyle($vNum_rows, $vCont)?> bgcolor="<?=$sCurcolor[$aResult['cod_cur']]?>"><?=$aResult['cod_cur']?></td>
            <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['nom_cur']?></td>
            <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['nom_doc']?></td>
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