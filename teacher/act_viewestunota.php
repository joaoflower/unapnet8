<STYLE type=text/css>
@import url( ../css/main.css );
@import url( ../css/frame.css );
@import url( ../css/framelogin.css );
@import url( ../css/style.css );
</STYLE>
<?
	if(fsafetylogin())
	{
		$bDatos = FALSE;
		
		//----------------------------------------------------
		if($_SESSION["sActamod_mat"] != '02' and $_SESSION["sActamod_mat"] != '08'  )
		{
			/*if($_SESSION["sActacod_car"] == '23' or $_SESSION["sActacod_car"] == '14' or $_SESSION["sActacod_car"] == '11' or $_SESSION["sActacod_car"] == '29' or $_SESSION["sActacod_car"] == '02' or $_SESSION["sActacod_car"] == '27' or $_SESSION["sActacod_car"] == '04' or $_SESSION["sActacod_car"] == '33' or $_SESSION["sActacod_car"] == '24'  or $_SESSION["sActacod_car"] == '12'  or $_SESSION["sActacod_car"] == '56'  or $_SESSION["sActacod_car"] == '30' or $_SESSION["sActacod_car"] == '31' or $_SESSION["sActacod_car"] == '20'  or $_SESSION["sActacod_car"] == '35' or $_SESSION["sActacod_car"] == '09'  or $_SESSION["sActacod_car"] == '03' or $_SESSION["sActacod_car"] == '26' or $_SESSION["sActacod_car"] == '32' or $_SESSION["sActacod_car"] == '33' or $_SESSION["sActacod_car"] == '34')*/
			/*if($_SESSION["sActacod_car"] != '37')
			{
				$_SESSION['sActaend_ing'] = 'F';
			}
			else
			{
				$_SESSION['sActaend_ing'] = 'T';			
			}*/
			$vQuery = "select con_ape from apeacta where  ";
			$vQuery .= "ano_aca = '{$_SESSION['sFrameano_aca']}' and per_aca = '{$_SESSION['sFrameper_aca']}' and ";
			$vQuery .= "cod_car = '{$_SESSION['sActacod_car']}' ";
			$cResult = fQuery($vQuery);
			if($aResult = mysql_fetch_array($cResult))
			{
				if($aResult['con_ape'] == 'True')
				{
					$_SESSION['sActaend_ing'] = 'F';
				}
				else
				{
					$_SESSION['sActaend_ing'] = 'T';
				}
			}
		}
		else
		{
			if($_SESSION["sActacod_car"] != '37')
				$_SESSION['sActaend_ing'] = 'T';
			else
				$_SESSION['sActaend_ing'] = 'T';
		}
		
		//------------------------------------------------------
		/*if($_SESSION['sUsercod_usu'] == '1030622' or $_SESSION['sUsercod_usu'] == '200512' or $_SESSION['sUsercod_usu'] == '86127' or $_SESSION['sUsercod_usu'] == '2011263' or $_SESSION['sUsercod_usu'] == '980580' or $_SESSION['sUsercod_usu'] == '2011263' or $_SESSION['sUsercod_usu'] == '960507' or $_SESSION['sUsercod_usu'] == '78083' or $_SESSION['sUsercod_usu'] == '980548' or $_SESSION['sUsercod_usu'] == '83101' or $_SESSION['sUsercod_usu'] == '2008403' or $_SESSION['sUsercod_usu'] == '910528' or $_SESSION['sUsercod_usu'] == '97519' or $_SESSION['sUsercod_usu'] == '200512' or $_SESSION['sUsercod_usu'] == '2005741' or $_SESSION['sUsercod_usu'] == '881213' or $_SESSION['sUsercod_usu'] == '940432' or $_SESSION['sUsercod_usu'] == '85127' or $_SESSION['sUsercod_usu'] == '960516' or $_SESSION['sUsercod_usu'] == '97105' or $_SESSION['sUsercod_usu'] == '940432' or $_SESSION['sUsercod_usu'] == '760711' or $_SESSION['sUsercod_usu'] == '2081222' or $_SESSION['sUsercod_usu'] == '960516' or $_SESSION['sUsercod_usu'] == '97105' or $_SESSION['sUsercod_usu'] == '85127' or $_SESSION['sUsercod_usu'] == '980585' or $_SESSION['sUsercod_usu'] == '29961' or $_SESSION['sUsercod_usu'] == '84114' or $_SESSION['sUsercod_usu'] == '950559' or $_SESSION['sUsercod_usu'] == '93059' or $_SESSION['sUsercod_usu'] == '2008114' or $_SESSION['sUsercod_usu'] == '299104' or $_SESSION['sUsercod_usu'] == '2005906' or $_SESSION['sUsercod_usu'] == '75121' or $_SESSION['sUsercod_usu'] == '960506' or $_SESSION['sUsercod_usu'] == '940427' or $_SESSION['sUsercod_usu'] == '79091' or $_SESSION['sUsercod_usu'] == '881216' or $_SESSION['sUsercod_usu'] == '91053' or $_SESSION['sUsercod_usu'] == '2100112')
				$_SESSION['sActaend_ing'] = 'F';*/
		
		if($_SESSION['sActaend_ing'] == 'T')
		{
			$vQuery = "select est_hab from habidoce where  ";
			$vQuery .= "ano_aca = '{$_SESSION['sFrameano_aca']}' and per_aca = '{$_SESSION['sFrameper_aca']}' and ";
			$vQuery .= "cod_car = '{$_SESSION['sUsercod_car']}' and cod_prf = '{$_SESSION['sUsercod_usu']}' and est_hab = '1' ";
			$cResult = fQuery($vQuery);
			if($aResult = mysql_fetch_array($cResult))
			{
				$_SESSION['sActaend_ing'] = 'F';
			}
		}
		
		//-----------------------------------------------------
		$tIngnota = "ingnota".$_SESSION['sFrameano_aca'];
		
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
		}
		
		//----------------------------------------------------
		
		$vCont = 1;
		$vCan_cap = 0;
		$vCan_act = 0;

		$vPro_cap = 0;
		$vPro_act = 0;
		$vPro_fin = 0;
		
		$tCurmat = "curmat".$_SESSION["sActacod_car"].$_SESSION['sFrameano_aca'];
		$tNotaca = "notaca".$_SESSION["sActacod_car"].$_SESSION['sFrameano_aca'];
		$tApla = "apla".$_SESSION['sFrameano_aca'];

		//----------------------------------------------------
		$vQuery = "select max(no.ord_not) as ord_not ";
		$vQuery .= "from $tNotaca no left join modnot mn on no.mod_not = mn.mod_not ";
		$vQuery .= "where no.cod_car = '{$_SESSION['sActacod_car']}' and no.pln_est = '{$_SESSION['sActapln_est']}' and ";
		$vQuery .= "no.cod_cur = '{$_SESSION['sActacod_cur']}' and no.ano_aca = '{$_SESSION['sFrameano_aca']}' and ";
		$vQuery .= "no.per_aca = '{$_SESSION['sFrameper_aca']}' and mn.mod_act = '{$_SESSION['sActamod_mat']}' and ";
		$vQuery .= "no.tip_not = 'C' and no.num_mat in ";
		$vQuery .= "(Select num_mat from $tCurmat where per_aca = '{$_SESSION['sFrameper_aca']}' and ";
		$vQuery .= "pln_est = '{$_SESSION['sActapln_est']}' and cod_cur = '{$_SESSION['sActacod_cur']}' and ";
		$vQuery .= "sec_gru = '{$_SESSION['sActasec_gru']}')";
		$_SESSION['sPrnSql2'] = $vQuery;
		$cCan_cap = fQuery2($vQuery);
		if($aCan_cap = mysql_fetch_array($cCan_cap))
			$vCan_cap = $aCan_cap['ord_not'];

		//----------------------------------------------------
		$vQuery = "select max(no.ord_not) as ord_not ";
		$vQuery .= "from $tNotaca no left join modnot mn on no.mod_not = mn.mod_not ";
		$vQuery .= "where no.cod_car = '{$_SESSION['sActacod_car']}' and no.pln_est = '{$_SESSION['sActapln_est']}' and ";
		$vQuery .= "no.cod_cur = '{$_SESSION['sActacod_cur']}' and no.ano_aca = '{$_SESSION['sFrameano_aca']}' and ";
		$vQuery .= "no.per_aca = '{$_SESSION['sFrameper_aca']}' and mn.mod_act = '{$_SESSION['sActamod_mat']}' and ";
		$vQuery .= "no.tip_not = 'A' and no.num_mat in ";
		$vQuery .= "(Select num_mat from $tCurmat where per_aca = '{$_SESSION['sFrameper_aca']}' and ";
		$vQuery .= "pln_est = '{$_SESSION['sActapln_est']}' and cod_cur = '{$_SESSION['sActacod_cur']}' and ";
		$vQuery .= "sec_gru = '{$_SESSION['sActasec_gru']}')";
		$_SESSION['sPrnSql3'] = $vQuery;
		$cCan_act = fQuery2($vQuery);
		if($aCan_act = mysql_fetch_array($cCan_act))
			$vCan_act = $aCan_act['ord_not'];
		
		(empty($vCan_cap)?$vCan_cap=0:$vCan_cap=$vCan_cap);
		(empty($vCan_act)?$vCan_act=0:$vCan_act=$vCan_act);
		//----------------------------------------------------
		if($vCan_cap > 0)
		{
			$vQuery = "select no.num_mat, no.ord_not, no.not_cur  ";
			$vQuery .= "from $tNotaca no left join modnot mn on no.mod_not = mn.mod_not ";
			$vQuery .= "where no.cod_car = '{$_SESSION['sActacod_car']}' and no.pln_est = '{$_SESSION['sActapln_est']}' and ";
			$vQuery .= "no.cod_cur = '{$_SESSION['sActacod_cur']}' and no.ano_aca = '{$_SESSION['sFrameano_aca']}' and ";
			$vQuery .= "no.per_aca = '{$_SESSION['sFrameper_aca']}' and mn.mod_act = '{$_SESSION['sActamod_mat']}' and ";
			$vQuery .= "no.tip_not = 'C' and no.num_mat in ";
			$vQuery .= "(Select num_mat from $tCurmat where per_aca = '{$_SESSION['sFrameper_aca']}' and ";
			$vQuery .= "pln_est = '{$_SESSION['sActapln_est']}' and cod_cur = '{$_SESSION['sActacod_cur']}' and ";
			$vQuery .= "sec_gru = '{$_SESSION['sActasec_gru']}')";	
			$_SESSION['sPrnSql4'] = $vQuery;		
			$cNotacap = fQuery2($vQuery);
			while($aNotacap = mysql_fetch_array($cNotacap))
				$sNotacap[$aNotacap['num_mat']][$aNotacap['ord_not']] = $aNotacap['not_cur'];
		}			
		if($vCan_act > 0)
		{
			$vQuery = "select no.num_mat, no.ord_not, no.not_cur  ";
			$vQuery .= "from $tNotaca no left join modnot mn on no.mod_not = mn.mod_not ";
			$vQuery .= "where no.cod_car = '{$_SESSION['sActacod_car']}' and no.pln_est = '{$_SESSION['sActapln_est']}' and ";
			$vQuery .= "no.cod_cur = '{$_SESSION['sActacod_cur']}' and no.ano_aca = '{$_SESSION['sFrameano_aca']}' and ";
			$vQuery .= "no.per_aca = '{$_SESSION['sFrameper_aca']}' and mn.mod_act = '{$_SESSION['sActamod_mat']}' and ";
			$vQuery .= "no.tip_not = 'A' and no.num_mat in ";
			$vQuery .= "(Select num_mat from $tCurmat where per_aca = '{$_SESSION['sFrameper_aca']}' and ";
			$vQuery .= "pln_est = '{$_SESSION['sActapln_est']}' and cod_cur = '{$_SESSION['sActacod_cur']}' and ";
			$vQuery .= "sec_gru = '{$_SESSION['sActasec_gru']}')";
			$_SESSION['sPrnSql5'] = $vQuery;
			$cNotaact = fQuery2($vQuery);
			while($aNotaact = mysql_fetch_array($cNotaact))
				$sNotaact[$aNotaact['num_mat']][$aNotaact['ord_not']] = $aNotaact['not_cur'];
		}	
		//----------------------------------------------------		
		
		$bDatos = TRUE;
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{
?>
			<? 	if($_SESSION["sActaingresado"] == 'F'  and $_SESSION['sActaend_ing'] == 'F') {	?>
			 <span class="wordi">TERMINADO EL PROCESO DE INGRESO DE NOTAS, HACER CLICK EN <strong>&lt; PUBLICAR &gt;</strong>,<br />
			 PARA QUE LAS NOTAS SEAN ENVIADAS AL SISTEMA. </span>
			 <?	}	?>
			 <table border="0" cellpadding="0" cellspacing="0" class="tlistdata">
			  <tr>
			    <th width="15">N&deg;</th>
			    <th width="30">C&oacute;digo </th>
				<th width="210">Apellidos y Nombres </th>
		        <th width="60">Modalidad</th>
		        <th width="40" colspan="2">Capacidades</th>
		        <th width="18">PC</th>
		        <th width="40" colspan="2">Actitudes</th>
		        <th width="17">PA</th>
		        <th width="18">PF</th>
			  </tr>
			  <?
			  	if($_SESSION["sActaingresado"] == 'F' and $_SESSION['sActaend_ing'] == 'F')
				{
			  ?>
			  
			  <tr class="trinpar" id="i" >
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td><? if($vCan_cap < $_SESSION['sActacan_cap'] )	{ ?><a href="" onclick="act_newnota('C<?=$vCan_cap+1?>i'); return false;" class="enlaceb"><img src="../images/new.png" alt="Nueva nota de capacidad" width="16" height="16" /></a><?	}	?></td>
			    <td><? if($vCan_cap > 0)	{ ?><a href="" onclick="act_delnotapre('C<?=$vCan_cap?>'); return false;" class="enlaceb"><img src="../images/drop.png" alt="Eliminar la &uacute;ltima nota de capacidad" width="16" height="16" /></a><?	}	?></td>
			    <td>&nbsp;</td>
			    <td><? if($vCan_act < $_SESSION['sActacan_act'] )	{ ?><a href="" onclick="act_newnota('A<?=$vCan_act+1?>i'); return false;" class="enlaceb"><img src="../images/new.png" alt="Nueva nota de actitud" width="16" height="16" /></a><?	}	?></td>
			    <td><? if($vCan_act > 0)	{ ?><a href="" onclick="act_delnotapre('A<?=$vCan_act?>'); return false;" class="enlaceb"><img src="../images/drop.png" alt="Eliminar la &uacute;ltima nota de actitud" width="16" height="16" /></a><?	}	?></td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
		      </tr>
			  <?	if($_SESSION['sActamod_mat'] != '02' and $_SESSION['sActamod_mat'] != '08' )	{	?>
			  <? if($vCan_cap > 0 or $vCan_act > 0)	{ ?>
			  <tr class="trpar" id="p" >
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="tlistdata">
                 <tr class="celdainpar">
					<?	for($i = 0; $i < $vCan_cap;$i++)	{  ?>
                   <td width="17" ><a href="" onclick="act_editnota('C<?=$i+1?>u'); return false;" class="enlaceb"><img src="../images/edit.png" alt="Modificar capacidad <?=$i+1?>" width="16" height="16" /></a></td>
					<?	}	?>
                 </tr>
               </table></td>
			    <td>&nbsp;</td>
			    <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="tlistdata">
                 <tr class="celdainpar">
					<?	for($i = 0; $i < $vCan_act;$i++)	{  ?>
                   <td width="17" align="center"><a href="" onclick="act_editnota('A<?=$i+1?>u'); return false;" class="enlaceb"><img src="../images/edit.png" alt="Modificar actitud <?=$i+1?>" width="16" height="16" /></a></td>
					<?	}	?>
                 </tr>
               </table></td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
		      </tr>
			  <? 	}	?>
			  <?	}	?>
			  <?
			  	}
			  ?>
			  <?
				if($_SESSION['sActamod_mat'] != '02' and $_SESSION['sActamod_mat'] != '08' )
				{
					$vQuery = "select cm.num_mat, concat(es.paterno, ' ', es.materno, ', ',es.nombres) as nom_est, mm.mod_des ";
					$vQuery .= "from $tCurmat cm ";
					$vQuery .= "left join estudiante es on cm.num_mat = es.num_mat and cm.cod_car = es.cod_car ";
					$vQuery .= "left join modmat mm on cm.mod_mat = mm.mod_mat ";
					$vQuery .= "where cm.cod_car = '{$_SESSION['sActacod_car']}' and cm.ano_aca = '{$_SESSION['sFrameano_aca']}' and ";
					$vQuery .= "cm.per_aca = '{$_SESSION['sFrameper_aca']}' and cm.pln_est = '{$_SESSION['sActapln_est']}' and ";
					$vQuery .= "cm.cod_cur = '{$_SESSION['sActacod_cur']}' and cm.sec_gru = '{$_SESSION['sActasec_gru']}' and ";
					$vQuery .= "mm.mod_act = '{$_SESSION['sActamod_mat']}' ";
					$vQuery .= "order by nom_est ";
					$cResult = fQuery($vQuery);
					$vNum_rows = fCountq($cResult);
				}
				else
				{
					$vQuery = "select ap.num_mat, concat(es.paterno, ' ', es.materno, ', ',es.nombres) as nom_est, mn.not_des as mod_des ";
					$vQuery .= "from $tApla ap ";
					$vQuery .= "left join estudiante es on ap.num_mat = es.num_mat and ap.cod_car = es.cod_car ";
					$vQuery .= "left join modnot mn on ap.mod_mat = mn.mod_not ";
					$vQuery .= "where ap.cod_car = '{$_SESSION['sActacod_car']}' and ap.ano_aca = '{$_SESSION['sFrameano_aca']}' and ";
					$vQuery .= "ap.per_aca = '{$_SESSION['sFrameper_aca']}' and  ap.pln_est = '{$_SESSION['sActapln_est']}' and ";
					$vQuery .= "ap.cod_cur = '{$_SESSION['sActacod_cur']}' and ap.sec_gru = '{$_SESSION['sActasec_gru']}' and ";
					$vQuery .= "ap.mod_mat = '{$_SESSION['sActamod_mat']}' order by nom_est ";
					$cResult = fQuery($vQuery);
					$vNum_rows = fCountq($cResult);
				}
				$_SESSION['sPrnSql6'] = $vQuery;
				
				
				while($aResult = mysql_fetch_array($cResult))
				{
					$vPro_cap = 0;
					$vPro_act = 0;
					
			  ?>
			  <tr <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)" id="rTr<?=$aResult['cod_cur']?>">
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$vCont?></td>
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['num_mat']?></td>
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['nom_est']))?></td>
		        <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['mod_des']))?></td>
	            <td colspan="2" <?=ftdstyle($vNum_rows, $vCont)?>><table border="0" cellpadding="0" cellspacing="0" class="tlistdata" >
                 <tr >
					<?	for($i = 0; $i < $vCan_cap;$i++)	{	$vPro_cap += $sNotacap[$aResult['num_mat']][$i+1];  ?>
                   <td width="17"  <?=ftdstylenotaacta($sNotacap[$aResult['num_mat']][$i+1])?>><?=$sNotacap[$aResult['num_mat']][$i+1]?></td>
					<?	}	
						if($vCan_cap > 0)	
							$vPro_cap = round($vPro_cap/$vCan_cap);						
					?>
                 </tr>
               </table></td>
	            <td bgcolor="#FFFFBF" <?=ftdstylenota($vNum_rows, $vCont, $vPro_cap)?>>
				<?	if($vCan_cap > 0)	{	echo $vPro_cap;	} ?>				</td>
	            <td colspan="2" <?=ftdstyle($vNum_rows, $vCont)?>><table border="0" cellpadding="0" cellspacing="0" class="tlistdata" >
                 <tr >
					<?	for($i = 0; $i < $vCan_act;$i++)	{	$vPro_act += $sNotaact[$aResult['num_mat']][$i+1];  ?>
                   <td width="17"  class="tdnotaapr"><?=$sNotaact[$aResult['num_mat']][$i+1]?></td>
					<?	}	
						if($vCan_act > 0)	
							$vPro_act = round($vPro_act/$vCan_act);						
					?>
                 </tr>
               </table></td>
	            <td bgcolor="#FFFFBF" <?=ftdstylenotaact($vNum_rows, $vCont)?>>
				<?	if($vCan_act > 0)	{	echo $vPro_act;	} ?>				</td>
				<?
					if($vCan_cap > 0 || $vCan_act > 0)	
					{	
						if($vCan_act > 0)	$vPro_fin = round(($vPro_cap * 0.9) + $vPro_act);	
						else $vPro_fin = $vPro_cap;
					}
				?>
				<td bgcolor="#B3FFB3" <?=ftdstylenota($vNum_rows, $vCont, $vPro_fin)?>>
				<?	if($vCan_cap > 0 || $vCan_act > 0)	{	echo $vPro_fin;	}	?>	            </td>
			  </tr>
			  <?
					$vCont++;
			  	}
			  ?>
			</table>
			
	<table border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td> 
			<? 	if($_SESSION["sActaingresado"] == 'F' and $vCan_cap == $_SESSION['sActacan_cap'] and $vCan_act == $_SESSION['sActacan_act'])	{	?>
			<div class="dboton"><a href="" onClick = "act_saveactapre(); return false;" class="isave" title="Guardar y Publicar Notas">&lt; Publicar &gt;</a></div>
			<?	}	?>
			<? 	if($_SESSION['sActamod_mat'] != '02' and $_SESSION['sActamod_mat'] != '08' )	{	?>
			<div class="dboton"><a href="" onClick="act_editca(); return false;" class="imodify" title="Modificar Capacidades y Actitudes" >Mod. C. y A.</a></div>
			<?	}	?>
			<div class="dboton"><a href="xls_estunota.php" class="ireport" title="Imprimir" >Export XLS</a></div>
			<div class="dboton"><a href="" onClick="clickacta(); return false;" class="icurso" title="Listar Cursos">Ver Cursos</a></div>
		</td>
	  </tr>
	</table>
<?
	}
?>
