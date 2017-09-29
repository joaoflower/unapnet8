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
		
		if($_SESSION['sEstumat_ok'] == TRUE and $_SESSION['sEstumat_ya'] == FALSE)
		{
			$bDatos = TRUE;
			$_SESSION['sEstumat_okse'] = TRUE;
		}
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{
?>
<form action="#" method="post" enctype="multipart/form-data" name="fData" id="fData">
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
				<th colspan="3"><?=$_SESSION['sUsercod_usu']?> - <?=$_SESSION['sUserpaterno']?> <?=$_SESSION['sUsermaterno']?>, <?=$_SESSION['sUsernombres']?></th>
			  </tr>
			  
			  <tr>
			    <td>Semestre : </td>
			    <th width="150"><?=$_SESSION['sEstusem_des']?></th>
		        <td width="100">Modalidad : </td>
		        <th width="150"><?=$_SESSION['sEstumod_des']?></th>
			  </tr>
			  <tr>
			    <td>Max. Cr&eacute;ditos : </td>
			    <th><?=$_SESSION['sEstumax_crd']?> cr&eacute;ditos </th>
			    <td>Crd. Mat. : </td>
			    <th><input name="rCrd_cur" type="text" class="" id="rCrd_cur" value="<?=$_SESSION['sEstutot_crd']?>" size="4" maxlength="4" disabled> 
		        cr&eacute;ditos </th>
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
		$vQuery = "Select con_ens from estudiante where num_mat = {$_SESSION['sUsercod_usu']} and cod_car = '{$_SESSION['sUsercod_car']}'  ";
		
		$cResult = fQuery($vQuery);
		if($aResult = mysql_fetch_array($cResult))
		{
			if($aResult['con_ens'] == '2')
			{
	?>
	
	<!--<table border="0" cellpadding="0" cellspacing="0" class="tventana">
      <tr>
        <td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
        <th background="../images/ven_topcenter.jpg">ERROR - (De acuerdo a la Ley Universitaria N&deg; 23733, Art&iacute;culo 58&deg;) </th>
        <td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
      </tr>
      <tr>
        <td background="../images/ven_mediumleft.jpg"></td>
        <td align="center"><span class="wordi">USTED ESTUDIA<strong> 2 ESCUELAS PROFESIONALES </strong>
            Y DEBE DE 
            PAGAR <br>
            <strong>S/. 3.00 POR CADA CR&Eacute;DITO</strong> QUE SE VA HA MATRICULAR.<br /> 
          REALICE EL PAGO RESPECTIVO. 
            SI NO PAGA SE LE BLOQUEAR&Aacute; COMO DEUDOR. <br>
            (Si existe reclamos apersonece a la OTI). </span></td>
        <td background="../images/ven_mediumright.jpg"></td>
      </tr>
      <tr>
        <td><img src="../images/ven_bottomleft.jpg" width="16" height="16" border="0" alt="" /></td>
        <td background="../images/ven_bottomcenter.jpg"></td>
        <td><img src="../images/ven_bottomright.jpg" width="16" height="16" border="0" alt="" /></td>
      </tr>
    </table> -->
	<?
			}
		}
	?>
			
	<span class="wordi">SELECCIONE LOS CURSOS CON CUIDADO, DESPUES DE REALIZADA LA MATR&Iacute;CULA<br />
	NO PODRA REALIZAR CAMBIOS, POR FAVOR VERIFIQUE SU HORARIO. </span>
	
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
      <tr>
        <td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
        <th background="../images/ven_topcenter.jpg">Seleccione los cursos a Matricular </th>
        <td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
      </tr>
      <tr>
        <td background="../images/ven_mediumleft.jpg"></td>
        <td align="center"><table border="0" cellpadding="0" cellspacing="0" class="tlistdata">
            <tr>
              <th width="15">&nbsp;</th>
              <th width="20">C&oacute;d </th>
              <th width="330">Nombre de curso </th>
              <th width="15">Sm</th>
              <th width="60">Modalidad</th>
              <th width="70">Grupo</th>
              <th width="25">Crd</th>
            </tr>            
            <?
				$tCurmat = "curmat".$_SESSION['sUsercod_car'].$_SESSION['sEstuano_aca'];
				$tNota = "nota".$_SESSION['sUsercod_car'];
				$tCurmath = "curmat".$_SESSION['sUsercod_car'].$_SESSION['sFrameano_aca'];
				$tHabicurso = "habicurso".$_SESSION['sFrameano_aca'];
				
				$vTip_cur = "";
				$sModcurso = "";
				$sModmat = "";
				
				$vCont = 1;
			
				//------------- Cursos Habiles ------------------------------------------------------
				$sHabicurso = "";
				$vQuery = "select ha.cod_cur, ha.sec_gru, if(isnull(cc.canti), ha.can_vac, ha.can_vac - cc.canti) as vaca ";
				$vQuery .= "from $tHabicurso ha left join ";
				$vQuery .= "(  select pln_est, cod_cur, sec_gru, count(*) as canti ";
				$vQuery .= "   from $tCurmath ";
				$vQuery .= "   where ano_aca = '{$_SESSION['sFrameano_aca']}' and per_aca = '{$_SESSION['sFrameper_aca']}' and ";
				$vQuery .= "         pln_est = '{$_SESSION['sEstupln_est']}' group by pln_est, cod_cur, sec_gru ) cc ";
				$vQuery .= "on ha.pln_est = cc.pln_est and ha.cod_cur = cc.cod_cur and ha.sec_gru = cc.sec_gru ";
				$vQuery .= "where ha.cod_car = '{$_SESSION['sUsercod_car']}' and ha.per_aca = '{$_SESSION['sFrameper_aca']}' and ";
				$vQuery .= "ha.pln_est = '{$_SESSION['sEstupln_est']}' and (ha.can_vac > cc.canti or isnull(cc.canti)) and ";
				$vQuery .= "ha.cod_cur not in ";
				$vQuery .= "(select cod_cur from $tNota ";
				$vQuery .= "where num_mat = '{$_SESSION['sUsercod_usu']}' and pln_est = '{$_SESSION['sEstupln_est']}' and not_cur > 10) ";
				$vQuery .= "order by ha.cod_cur, ha.sec_gru desc ";
				
				$cHabicurso = fQuery($vQuery);	
				while($aHabicurso = mysql_fetch_array($cHabicurso))
				{
					$sHabicurso[$aHabicurso['cod_cur']]['cod_cur'] = TRUE;
					$sHabicurso[$aHabicurso['cod_cur']]['sec_gru'] = $aHabicurso['sec_gru'];
					$sHabicurso[$aHabicurso['cod_cur']]['can_vac'] = $aHabicurso['vaca'];
				}
				//----------------------------------------------------------------------------------
				
				//---------------- Modalidad de matrícula -------------------
				$vQuery = "Select mod_mat, mod_des from modmat where mod_mat != '' ";
				$cResult = fQuery($vQuery);
				while($aResult = mysql_fetch_array($cResult))
					$sModmat[$aResult['mod_mat']] = ucwords(strtolower($aResult['mod_des']));
				
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
				while($aResult = mysql_fetch_array($cResult))
					$sModcurso[$aResult['cod_cur']] = $sModmat[fModcurso($aResult['veces'])];

				//------------------Cursos a matricularse-------------------
				// FALTA PARALELO
				$vQuery = "select fincu.*, tc.cur_des, tc.ord_tip ";
				$vQuery .= "from ( ";
				$vQuery .= "Select distinct cd.cod_cur, cu.nom_cur, cu.sem_anu, cu.tip_cur, cu.crd_cur, cu.crd_prq ";
				$vQuery .= "from ";
				$vQuery .= "( ";
				$vQuery .= "   (select sr.cod_cur from ";
				$vQuery .= "      (select cod_cur from curso ";
				$vQuery .= "       where cod_car = '{$_SESSION['sUsercod_car']}' and pln_est = '{$_SESSION['sEstupln_est']}' and con_cur = '1' and cod_cur not in ";
				$vQuery .= "          (select cod_cur from requ where cod_car = '{$_SESSION['sUsercod_car']}' and pln_est = '{$_SESSION['sEstupln_est']}') ";
				$vQuery .= "      ) sr ";
				$vQuery .= "    where sr.cod_cur not in ";
				$vQuery .= "      (Select cod_cur from $tNota where cod_car = '{$_SESSION['sUsercod_car']}' and pln_est = '{$_SESSION['sEstupln_est']}' and ";
				$vQuery .= "       num_mat = '{$_SESSION['sUsercod_usu']}' and not_cur > 10) ";
				$vQuery .= "   ) union ";
				$vQuery .= "   (Select tr.cod_cur from ";
				$vQuery .= "      (select re.cod_cur from $tNota no ";
				$vQuery .= "       left join requ re on no.cod_car = re.cod_car and no.pln_est = re.pln_est and ";
				$vQuery .= "          no.cod_cur = re.cur_pre ";
				$vQuery .= "       where no.cod_car = '{$_SESSION['sUsercod_car']}' and no.pln_est = '{$_SESSION['sEstupln_est']}' and ";
				$vQuery .= "          no.num_mat = '{$_SESSION['sUsercod_usu']}' and no.not_cur > 10 and not isnull(re.cod_cur) ";
				$vQuery .= "      ) tr ";
				$vQuery .= "    where tr.cod_cur not in ";
				$vQuery .= "    (select cod_cur from requ where cod_car = '{$_SESSION['sUsercod_car']}' and pln_est = '{$_SESSION['sEstupln_est']}' and ";
				$vQuery .= "        cur_pre not in ";
				$vQuery .= "        (select cod_cur from $tNota where cod_car = '{$_SESSION['sUsercod_car']}' and pln_est = '{$_SESSION['sEstupln_est']}' and ";
				$vQuery .= "         num_mat = '{$_SESSION['sUsercod_usu']}' and not_cur > 10) ";
				$vQuery .= "    ) and tr.cod_cur not in ";
				$vQuery .= "    (Select cod_cur from $tNota where cod_car = '{$_SESSION['sUsercod_car']}' and pln_est = '{$_SESSION['sEstupln_est']}' and ";
				$vQuery .= "     num_mat = '{$_SESSION['sUsercod_usu']}' and not_cur > 10) ";
				$vQuery .= "   ) ";
				$vQuery .= ") cd ";
				$vQuery .= "left join curso cu on cd.cod_cur = cu.cod_cur ";
				$vQuery .= "where cu.cod_car = '{$_SESSION['sUsercod_car']}' and cu.pln_est = '{$_SESSION['sEstupln_est']}' and cu.con_cur = '1' and ";
				$vQuery .= "      (cu.cod_esp = '00' or cu.cod_esp = '{$_SESSION['sEstucod_esp']}') and cu.crd_prq <= '{$_SESSION['sEstuall_crd']}' ";
				$vQuery .= ") fincu left join tipcur tc on fincu.tip_cur = tc.tip_cur ";
				$vQuery .= "order by ord_tip, sem_anu, cod_cur ";
				
				$cCurso = fQuery($vQuery);
				$vNum_rows = fCountq($cCurso);
				if(!empty($sHabicurso)) while($aCurso = mysql_fetch_array($cCurso))
				{
					if($sHabicurso[$aCurso['cod_cur']]['cod_cur'] == TRUE)
					{
						if($vTip_cur != $aCurso['tip_cur'])
						{
							$vTip_cur = $aCurso['tip_cur'];
			  ?>
            <tr>
              <td>&nbsp;</td>
              <th colspan="6">Tipo de cursos: <?=$aCurso['cur_des']?></th>
            </tr>
			  <?
				  		}
			  ?>
					
			<tr <?=ftrstyle($vCont)?>  onmouseover="mouseover(this)" onmouseout="mouseout(this)" id="rTr<?=$aCurso['cod_cur']?>">
              <td <?=ftdstyle($vNum_rows, $vCont)?>><input name="rCod_cur[]" type="checkbox" id="rCod_cur[]" value="<?=$aCurso['cod_cur']?>" class="check" onclick="aumentar(this, <?=$aCurso['crd_cur']?>, <?=$_SESSION['sEstumax_crd']?>)" /></td>
              <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aCurso['cod_cur']?></td>
              <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aCurso['nom_cur']?></td>
              <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aCurso['sem_anu']?></td>
              <td <?=ftdstyle($vNum_rows, $vCont)?>><?=(empty($sModcurso[$aCurso['cod_cur']])?'Regular':$sModcurso[$aCurso['cod_cur']])?></td>
              <td <?=ftdstyle($vNum_rows, $vCont)?>><select name="rSec_gru<?=$aCurso['cod_cur']?>" id="rSec_gru<?=$aCurso['cod_cur']?>">
                <? fviewgrupohabi($aCurso['cod_cur'], $sHabicurso[$aCurso['cod_cur']]['sec_gru']); ?>
              </select></td>
              <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aCurso['crd_cur']?>
                  <input name="rCrd_cur<?=$aCurso['cod_cur']?>" type="hidden" id="rCrd_cur<?=$aCurso['cod_cur']?>" value="<?=$aCurso['crd_cur']?>" /></td>
            </tr>
            <?
				  		$vCont++;
					}
				}
				
			  ?>
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
			<div class="dboton"><a href="" onclick = "std_matricular(document.fData); return false;" class="icontinue" title="Matricular">Matricular</a></div>			
		</td>
	  </tr>
	</table>
</center>
</form>
<?
	}
	else
	{
?>
	<center>
	<span class="wordi"><strong>LAS MATR&Iacute;CULAS VIA INTERNET ES SOLO PARA<br />
	ESTUDIANTES INVICTOS.  </strong></span>
	</center>
<?
	}
?>