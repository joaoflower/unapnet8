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
		if($_SESSION["sActacod_car"] == '61')
			$_SESSION['sActaend_ing'] = 'F';
		else
			$_SESSION['sActaend_ing'] = 'F';			
		
		//------------------------------------------------------
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
		
		//----------------------------------------------------
		
		$vCont = 1;
		$vPro_fin = 0;
	
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
			    <th width="50">C&oacute;digo </th>
				<th width="220">Apellidos y Nombres </th>
		        <th width="60">Modalidad</th>
		        <th width="40" colspan="2">Notas</th>
		        <th width="18">PF</th>
			  </tr>
			  <?
			  	if($_SESSION["sActaingresado"] == 'F' and $_SESSION['sActaend_ing'] == 'F')
				{
			  ?>			  
			  <tr class="trpar" id="p" >
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td width="17"><a href="" onclick="act_editnotai('eu'); return false;" class="enlaceb"><img src="../images/edit.png" alt="Modificar Examen Escrito" width="16" height="16" /></a></td>
			    <td width="17"><a href="" onclick="act_editnotai('ou'); return false;" class="enlaceb"><img src="../images/edit.png" alt="Modificar Examen Oral" width="16" height="16" /></a></td>
			    <td>&nbsp;</td>
		      </tr>
			  <?
			  	}
			  				
				$vQuery = "select ma.codigo, concat(es.paterno, ' ', es.materno, ', ',es.nombres) as nom_est, ";
				$vQuery .= "  ma.cod_con, ce.des_con, ma.escrito, ma.oral,  round((ma.escrito + ma.oral)/2) as final ";
				$vQuery .= "from matriculas ma left join estudiantes es on ma.codigo = es.codigo ";
				$vQuery .= "left join condicionest ce on ma.cod_con = ce.cod_con ";
				$vQuery .= "where ma.cod_gpo = '{$_SESSION['sActacod_gpo']}' and ma.anio = '{$_SESSION['sFrameano_acai']}' and ";
				$vQuery .= "ma.cod_mes = '{$_SESSION['sFramecod_mesi']}' and ma.cod_con != '6' ";
				$vQuery .= "order by nom_est ";
				$cResult = fQueryi($vQuery);
				$vNum_rows = fCountqi($cResult);
				
				$_SESSION['sPrnSql6'] = $vQuery;
				
				
				while($aResult = mysql_fetch_array($cResult))
				{
										
			  ?>
			  <tr <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)" id="rTr<?=$aResult['cod_cur']?>">
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$vCont?></td>
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['codigo']?></td>
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['nom_est']))?></td>
		        <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['des_con']))?></td>
	            <td width="17"  <?=ftdstylenotaactai($aResult['escrito'])?>><?=$aResult['escrito']?></td>
	            <td width="17"  <?=ftdstylenotaactai($aResult['oral'])?>><?=$aResult['oral']?></td>
	            <td bgcolor="#B3FFB3" <?=ftdstylenotai($vNum_rows, $vCont, $aResult['final'])?>><?=$aResult['final']?></td>
			  </tr>
			  <?
					$vCont++;
			  	}
			  ?>
			</table>
			
	<table border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td> 
			<? 	if($_SESSION["sActaingresado"] == 'F' )	{	?>
			<div class="dboton"><a href="" onClick = "act_saveactaprei(); return false;" class="isave" title="Guardar y Publicar Notas">&lt; Publicar &gt;</a></div>
			<?	}	?>		
			<? 	if($_SESSION["sActaingresado"] == 'T' )	{	?>	
			<div class="dboton"><a href="xls_estunotai.php" class="ireport" title="Imprimir" >Export XLS</a></div>
			<?	}	?>	
			<div class="dboton"><a href="" onClick="clickacta(); return false;" class="icurso" title="Listar Cursos">Ver Cursos</a></div>
		</td>
	  </tr>
	</table>
<?
	}
?>
