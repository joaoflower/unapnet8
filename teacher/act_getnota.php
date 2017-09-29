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
		
		if(!empty($_POST['rTip_ord']))
		{
			$_SESSION["sActatip_not"] = $vTip_not = substr($_POST['rTip_ord'], 0, 1);
			$_SESSION["sActaord_not"] = $vOrd_not = substr($_POST['rTip_ord'], 1, 1);
			$vIns_upd = substr($_POST['rTip_ord'], 2, 1);
			
			
			$bDatos = TRUE;
		}		
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{
?>
			<table border="0" cellpadding="0" cellspacing="0" class="tlistdata">
			  <tr>
			    <th width="20">N&deg;</th>
			    <th width="30">C&oacute;digo </th>
				<th width="220">Apellidos y Nombres </th>
		        <th width="60">Modalidad</th>
	            <th width="60"><?=($vTip_not=='C'?"Capac.:":"Acti.:")?> <?=$vOrd_not?></th>
			  </tr>
			  <?
				$tCurmat = "curmat".$_SESSION["sActacod_car"].$_SESSION['sFrameano_aca'];
				$tApla = "apla".$_SESSION['sFrameano_aca'];
				$tNota = "notaca".$_SESSION["sActacod_car"].$_SESSION['sFrameano_aca'];
			  
			  	//-------------------------------------------------
				$sIngnota = "";
				$vNum_matback = "";
				
				if($_SESSION['sActamod_mat'] != '02' and $_SESSION['sActamod_mat'] != '08' )
				{
					$vQuery = "select cm.num_mat ";
					$vQuery .= "from $tCurmat cm ";
					$vQuery .= "left join estudiante es on cm.num_mat = es.num_mat and cm.cod_car = es.cod_car ";
					$vQuery .= "left join modmat mm on cm.mod_mat = mm.mod_mat ";
					$vQuery .= "where cm.cod_car = '{$_SESSION['sActacod_car']}' and cm.ano_aca = '{$_SESSION['sFrameano_aca']}' and ";
					$vQuery .= "cm.per_aca = '{$_SESSION['sFrameper_aca']}' and cm.pln_est = '{$_SESSION['sActapln_est']}' and ";
					$vQuery .= "cm.cod_cur = '{$_SESSION['sActacod_cur']}' and cm.sec_gru = '{$_SESSION['sActasec_gru']}' and ";
					$vQuery .= "mm.mod_act = '{$_SESSION['sActamod_mat']}' ";
					$vQuery .= "order by concat(es.paterno, ' ', es.materno, ', ',es.nombres) ";
					$cResult = fQuery2($vQuery);
				}
				else
				{
					$vQuery = "select ap.num_mat ";
					$vQuery .= "from $tApla ap ";
					$vQuery .= "left join estudiante es on ap.num_mat = es.num_mat and ap.cod_car = es.cod_car ";
					$vQuery .= "left join modnot mn on ap.mod_mat = mn.mod_not ";
					$vQuery .= "where ap.cod_car = '{$_SESSION['sActacod_car']}' and ap.ano_aca = '{$_SESSION['sFrameano_aca']}' and ";
					$vQuery .= "ap.per_aca = '{$_SESSION['sFrameper_aca']}' and  ap.pln_est = '{$_SESSION['sActapln_est']}' and ";
					$vQuery .= "ap.cod_cur = '{$_SESSION['sActacod_cur']}' and ap.sec_gru = '{$_SESSION['sActasec_gru']}' and ";
					$vQuery .= "ap.mod_mat = '{$_SESSION['sActamod_mat']}' ";
					$vQuery .= "order by concat(es.paterno, ' ', es.materno, ', ',es.nombres) ";
					$cResult = fQuery($vQuery);
				}
				
//				$cResult = fQuery2($vQuery);
				while($aResult = mysql_fetch_array($cResult))
				{
					if(!empty($vNum_matback))
					{
						$sIngnota[$vNum_matback] = $aResult['num_mat'];
					}
					$vNum_matback = $aResult['num_mat'];
				}
				$sIngnota[$vNum_matback] = "end";
				//----------------------------------------------------
			  
			  	if($vIns_upd == 'i')
				{
					if($_SESSION['sActamod_mat'] != '02' and $_SESSION['sActamod_mat'] != '08' )
					{
						$vQuery = "select cm.num_mat, concat(es.paterno, ' ', es.materno, ', ',es.nombres) as nom_est, mm.mod_des, ";
						$vQuery .= "mm.mod_not, cm.cod_car, cm.ano_aca, cm.per_aca, cm.pln_est, cm.cod_cur ";
						$vQuery .= "from $tCurmat cm ";
						$vQuery .= "left join estudiante es on cm.num_mat = es.num_mat and cm.cod_car = es.cod_car ";
						$vQuery .= "left join modmat mm on cm.mod_mat = mm.mod_mat ";
						$vQuery .= "where cm.cod_car = '{$_SESSION['sActacod_car']}' and cm.ano_aca = '{$_SESSION['sFrameano_aca']}' and ";
						$vQuery .= "cm.per_aca = '{$_SESSION['sFrameper_aca']}' and cm.pln_est = '{$_SESSION['sActapln_est']}' and ";
						$vQuery .= "cm.cod_cur = '{$_SESSION['sActacod_cur']}' and cm.sec_gru = '{$_SESSION['sActasec_gru']}' and ";
						$vQuery .= "mm.mod_act = '{$_SESSION['sActamod_mat']}'";
						$vQuery .= "order by nom_est ";
						$cResult = fQuery2($vQuery);
						$vNum_rows = fCountq2($cResult);
					}
					else
					{
						$vQuery = "select ap.num_mat, concat(es.paterno, ' ', es.materno, ', ',es.nombres) as nom_est, mn.not_des as mod_des, ";
						$vQuery .= "mn.mod_not ";
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

				}
				elseif($vIns_upd == 'u')
				{
					if($_SESSION['sActamod_mat'] != '02' and $_SESSION['sActamod_mat'] != '08' )
					{
						$vQuery = "select cmt.*, no.not_cur ";
						$vQuery .= "from ( ";
						$vQuery .= "select cm.num_mat, concat(es.paterno, ' ', es.materno, ', ',es.nombres) as nom_est, mm.mod_des, ";
						$vQuery .= "mm.mod_not, cm.cod_car, cm.per_aca, cm.pln_est, cm.cod_cur ";
						$vQuery .= "from $tCurmat cm ";
						$vQuery .= "left join estudiante es on cm.num_mat = es.num_mat and cm.cod_car = es.cod_car ";
						$vQuery .= "left join modmat mm on cm.mod_mat = mm.mod_mat ";
						$vQuery .= "where cm.cod_car = '{$_SESSION['sActacod_car']}' and cm.ano_aca = '{$_SESSION['sFrameano_aca']}' and ";
						$vQuery .= "cm.per_aca = '{$_SESSION['sFrameper_aca']}' and cm.pln_est = '{$_SESSION['sActapln_est']}' and ";
						$vQuery .= "cm.cod_cur = '{$_SESSION['sActacod_cur']}' and cm.sec_gru = '{$_SESSION['sActasec_gru']}' and ";
						$vQuery .= "mm.mod_act = '{$_SESSION['sActamod_mat']}'";
						$vQuery .= "order by nom_est ";
						$vQuery .= ") cmt ";
						$vQuery .= "left join $tNota no on cmt.cod_car = no.cod_car and ";
						$vQuery .= "cmt.per_aca = no.per_aca and cmt.pln_est = no.pln_est and cmt.cod_cur = no.cod_cur and ";
						$vQuery .= "cmt.mod_not = no.mod_not and cmt.num_mat = no.num_mat ";
						$vQuery .= "where no.tip_not = '$vTip_not' and ord_not = '$vOrd_not' ";
						$cResult = fQuery2($vQuery);
						$vNum_rows = fCountq2($cResult);
					}
					else
					{
						$vQuery = "select cmt.*, no.not_cur ";
						$vQuery .= "from ( ";
						$vQuery .= "select ap.num_mat, concat(es.paterno, ' ', es.materno, ', ',es.nombres) as nom_est, mn.not_des as mod_des, ";
						$vQuery .= "mn.mod_not, ap.cod_car, ap.per_aca, ap.pln_est, ap.cod_cur  ";
						$vQuery .= "from $tApla ap ";
						$vQuery .= "left join estudiante es on ap.num_mat = es.num_mat and ap.cod_car = es.cod_car ";
						$vQuery .= "left join modnot mn on ap.mod_mat = mn.mod_not ";
						$vQuery .= "where ap.cod_car = '{$_SESSION['sActacod_car']}' and ap.ano_aca = '{$_SESSION['sFrameano_aca']}' and ";
						$vQuery .= "ap.per_aca = '{$_SESSION['sFrameper_aca']}' and  ap.pln_est = '{$_SESSION['sActapln_est']}' and ";
						$vQuery .= "ap.cod_cur = '{$_SESSION['sActacod_cur']}' and ap.sec_gru = '{$_SESSION['sActasec_gru']}' and ";
						$vQuery .= "ap.mod_mat = '{$_SESSION['sActamod_mat']}' order by nom_est ";
						$vQuery .= ") cmt ";
						$vQuery .= "left join $tNota no on cmt.cod_car = no.cod_car and ";
						$vQuery .= "cmt.per_aca = no.per_aca and cmt.pln_est = no.pln_est and cmt.cod_cur = no.cod_cur and ";
						$vQuery .= "cmt.mod_not = no.mod_not and cmt.num_mat = no.num_mat ";
						$vQuery .= "where no.tip_not = '$vTip_not' and ord_not = '$vOrd_not' ";
						$cResult = fQuery($vQuery);
						$vNum_rows = fCountq($cResult);
					}
				}
				
//				$cResult = fQuery2($vQuery);
	//			$vNum_rows = fCountq2($cResult);
				while($aResult = mysql_fetch_array($cResult))
				{
			
			  ?>
			  <tr <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)" id="rTr<?=$aResult['cod_cur']?>">
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$vCont?></td>
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['num_mat']?></td>
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['nom_est']))?></td>
		        <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['mod_des']))?></td>
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><input name="p<?=$aResult['num_mat']?>" type="text" class="<?=(fVerinotaapr($aResult['not_cur'],$vTip_not)?"notapro":"notades")?>" id="p<?=$aResult['num_mat']?>" value="<?=$aResult['not_cur']?>" size="<?=($vTip_not=='C'?'2':'1')?>" maxlength="<?=($vTip_not=='C'?'2':'1')?>" onkeyup="fverinota(this, '<?=$vTip_not?>'); fchecknota('p<?=$sIngnota[$aResult['num_mat']]?>');">
			    <input name="rMod_not<?=$aResult['num_mat']?>" type="hidden" id="rMod_not<?=$aResult['num_mat']?>" value="<?=$aResult['mod_not'].(fIsnota($aResult['not_cur'])?"u":"i")?>" /></td>
			  </tr>
			  <?
					$vCont++;
			  	}
			  ?>
			</table>
			
			<table border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td>
			<div class="dboton"><a href="" onClick = "act_savenota<?=$vTip_not?>(document.fData); return false;" class="isave" title="Guardar ">Guardar</a></div>
			<div class="dboton"><a href="" onClick="act_cancelnota(); return false;" class="icancel" title="Cancelar">Cancelar</a></div>	
		</td>
	  </tr>
	</table>
<?
	}
?>