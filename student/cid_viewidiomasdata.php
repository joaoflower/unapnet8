<STYLE type=text/css>
@import url( ../css/main.css );
@import url( ../css/frame.css );
@import url( ../css/framelogin.css );
@import url( ../css/style.css );
</STYLE>

<?
	if(fsafetylogin())
	{
		$bDatos = TRUE;
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{
?>
<center>

	<span class="wordi"> SI NO APARECE EL O LOS IDIOMAS QUE ESTA ESTUDIANDO EN<br />
		EL CENTRO DE IDIOMAS, HAGA CLICK EN "Refrescar"</span>
  <table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Idiomas estudiados en el Centro de Idiomas </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
		<table border="0" cellpadding="0" cellspacing="0" class="tlistdata">
			  <tr>
			    <th width="5">&nbsp;</th>
			    <th width="50">C&oacute;digo </th>
				<th width="100">Paterno</th>
		        <th width="100">Materno</th>
		        <th width="130">Nombres</th>
		        <th width="100">idioma</th>
		        <th width="16">&nbsp;</th>
		      </tr>
			  <?
			  	$vCont = 1;
			  
			  	$vQuery = "select es.codigo, es.paterno, es.materno, es.nombres, es.cod_esp, esp.des_esp ";
				$vQuery .= "from estudiantes es left join especialidades esp on es.cod_esp = esp.cod_esp ";
				$vQuery .= "where cod_unap = '{$_SESSION['sUsercod_usu']}' ";
				
				$cResult = fQueryi($vQuery);
				$vNum_rows = fCountqi($cResult);
				while($aResult = mysql_fetch_array($cResult))
				{

			  ?>
			  <tr <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)" id="rTr<?=$aResult['cod_cur']?>">
			    <td <?=ftdstyle($vNum_rows, $vCont)?>>&nbsp;</td>
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['codigo']?></td>
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['paterno']?></td>
		        <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['materno']?></td>
		        <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['nombres']?></td>
		        <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['des_esp']?></td>
		        <td <?=ftdstyle($vNum_rows, $vCont)?>><a href="" onclick="cid_viewidioma('<?=$aResult['codigo']?>'); return false;" class="enlaceb"><img src="../images/browse.png" alt="Ver informaci&oacute;n" width="16" height="16" /></a></td>
		      </tr>
			  <?
					$vCont++;
			  	}
			  ?>
			</table>		</td>
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
			<div class="dboton"><a href="" onclick = "cid_newidioma(); return false;" class="inew" title="Nuevo idioma">Refrescar</a></div>			
		</td>
	  </tr>
	</table>
	
	</center>

<?		
	}
?>