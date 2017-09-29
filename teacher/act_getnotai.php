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
			$vIns_upd = substr($_POST['rTip_ord'], 1, 1);

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
			    <th width="50">C&oacute;digo </th>
				<th width="220">Apellidos y Nombres </th>
		        <th width="60">Modalidad</th>
	            <th width="60"><?=($vTip_not=='e'?"Escrito":"Oral")?></th>
			  </tr>
			  <?		
			  
			  	//-------------------------------------------------
				$sIngnota = "";
				$vNum_matback = "";
				
				$vQuery = "select ma.num_mat ";
				$vQuery .= "from matriculas ma left join estudiantes es on ma.codigo = es.codigo ";
				$vQuery .= "left join condicionest ce on ma.cod_con = ce.cod_con ";
				$vQuery .= "where ma.cod_gpo = '{$_SESSION['sActacod_gpo']}' and ma.anio = '{$_SESSION['sFrameano_acai']}' and ";
				$vQuery .= "ma.cod_mes = '{$_SESSION['sFramecod_mesi']}' and ma.cod_con != '6' ";
				$vQuery .= "order by concat(es.paterno, ' ', es.materno, ', ',es.nombres) ";
				$cResult = fQueryi($vQuery);
				
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
			  
			  	if($_SESSION["sActatip_not"] == 'e')
				{
					$vQuery = "select ma.num_mat, ma.codigo, concat(es.paterno, ' ', es.materno, ', ',es.nombres) as nom_est, ";
					$vQuery .= "  ma.cod_con, ce.des_con, ma.escrito as not_cur ";
					$vQuery .= "from matriculas ma left join estudiantes es on ma.codigo = es.codigo ";
					$vQuery .= "left join condicionest ce on ma.cod_con = ce.cod_con ";
					$vQuery .= "where ma.cod_gpo = '{$_SESSION['sActacod_gpo']}' and ma.anio = '{$_SESSION['sFrameano_acai']}' and ";
					$vQuery .= "ma.cod_mes = '{$_SESSION['sFramecod_mesi']}' and ma.cod_con != '6' ";
					$vQuery .= "order by nom_est ";
					$cResult = fQueryi($vQuery);
					$vNum_rows = fCountqi($cResult);
				}
				elseif($_SESSION["sActatip_not"] == 'o')
				{
					$vQuery = "select ma.num_mat, ma.codigo, concat(es.paterno, ' ', es.materno, ', ',es.nombres) as nom_est, ";
					$vQuery .= "  ma.cod_con, ce.des_con, ma.oral as not_cur ";
					$vQuery .= "from matriculas ma left join estudiantes es on ma.codigo = es.codigo ";
					$vQuery .= "left join condicionest ce on ma.cod_con = ce.cod_con ";
					$vQuery .= "where ma.cod_gpo = '{$_SESSION['sActacod_gpo']}' and ma.anio = '{$_SESSION['sFrameano_acai']}' and ";
					$vQuery .= "ma.cod_mes = '{$_SESSION['sFramecod_mesi']}' and ma.cod_con != '6'  ";
					$vQuery .= "order by nom_est ";
					$cResult = fQueryi($vQuery);
					$vNum_rows = fCountqi($cResult);
				}
				
				while($aResult = mysql_fetch_array($cResult))
				{
			
			  ?>
			  <tr <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)" id="rTr<?=$aResult['cod_cur']?>">
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$vCont?></td>
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['codigo']?></td>
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['nom_est']))?></td>
		        <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['des_con']))?></td>
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><input name="p<?=$aResult['num_mat']?>" type="text" class="<?=(fVerinotaapr($aResult['not_cur'],$vTip_not)?"notapro":"notades")?>" id="p<?=$aResult['num_mat']?>" value="<?=$aResult['not_cur']?>" size="3" maxlength="3" onkeyup="fverinota(this, '<?=$vTip_not?>'); fchecknota('p<?=$sIngnota[$aResult['num_mat']]?>');"></td>
			  </tr>
			  <?
					$vCont++;
			  	}
			  ?>
			</table>
			
			<table border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td>
			<div class="dboton"><a href="" onClick = "act_savenotai(document.fData); return false;" class="isave" title="Guardar ">Guardar</a></div>
			<div class="dboton"><a href="" onClick="act_cancelnotai(); return false;" class="icancel" title="Cancelar">Cancelar</a></div>	
		</td>
	  </tr>
	</table>
<?
	}
?>