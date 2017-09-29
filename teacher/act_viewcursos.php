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
		if(!empty($_POST['rAno_aca']) and !empty($_POST['rPer_aca']))
		{
			$_SESSION['sFrameano_aca'] = $_POST['rAno_aca'];
			$_SESSION['sFrameper_aca'] = $_POST['rPer_aca'];
		}
		
		$vQuery = "Select dat_upd ";
		$vQuery .= "from docente ";
		$vQuery .= "where cod_prf = '{$_SESSION['sUsercod_usu']}' and cod_car = '{$_SESSION['sUsercod_car']}' ";
		
		$cResult = fQuery($vQuery);
		if($aResult = mysql_fetch_array($cResult))
		{
			if($aResult['dat_upd'] == '2')
				header("Location:tch_getmidata.php");
		}
	
	
	
		$_SESSION['sActaend_ing'] = 'F';
		$vCont = 1;
		$bDatos = TRUE;
		if(fFechad(fFecha()) == '19/02/2008')
		{
			$bDatos = TRUE;
			$_SESSION['sActaend_ing'] = 'T';
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
	<form action="#" method="post" enctype="multipart/form-data" name="fData" id="fData">
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">A&ntilde;o y Periodo Acad&eacute;mico </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="0" bordercolor="#FF0000" class="tviewdata">
				<tr>
				  <td width="50">A&ntilde;o:</td>
				  <td width="60"><select name="rAno_aca" id="rAno_aca">
				    <option value="2006" <?=($_SESSION['sFrameano_aca']=='2006'?'Selected':'')?>>2006</option>
				    <option value="2007" <?=($_SESSION['sFrameano_aca']=='2007'?'Selected':'')?>>2007</option>
				    <option value="2008" <?=($_SESSION['sFrameano_aca']=='2008'?'Selected':'')?>>2008</option>
				    <option value="2009" <?=($_SESSION['sFrameano_aca']=='2009'?'Selected':'')?>>2009</option>
                        </select></td>
				  <td width="50">Periodo:</td>
				  <td width="80"><select name="rPer_aca" id="rPer_aca">
				    <option value="01" <?=($_SESSION['sFrameper_aca']=='01'?'Selected':'')?>>SEMESTRE I</option>
				    <option value="02" <?=($_SESSION['sFrameper_aca']=='02'?'Selected':'')?>>SEMESTRE II</option>
				    <option value="03" <?=($_SESSION['sFrameper_aca']=='03'?'Selected':'')?>>VACACIONAL</option>
				    <option value="04" <?=($_SESSION['sFrameper_aca']=='04'?'Selected':'')?>>ADICIONAL</option>
                        </select></td>
			    </tr>
				<tr>
				  <td colspan="4" align="center">
				  </td>
			  </tr>
			</table>
			
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <td><div class="dboton"><a href="" onclick = "act_changeanoper(document.fData); return false;" class="icontinue" title="Aceptar">Cambiar</a></div></td>
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
	</form>
	
	
	
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Ingreso de notas a Actas </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="0" bordercolor="#FF0000" class="tlistsearch">
				<tr>
				  <th width="10">&nbsp;</th>
				  <th width="250">Curso</th>
				  <th width="20">Sm</th>
				  <th width="20">Es</th>
				  <th width="50">Grupo</th>
				  <th width="50">Modalidad</th>
				  <th width="200">Escuela Profesional </th>
			  	  <th width="16">&nbsp;</th>
				</tr>
			<?
			$tCarga = "cargaint".$_SESSION['sFrameano_aca'];
			
			$vQuery = "select ca.cod_car, ca.pln_est, ca.cod_cur, ca.mod_mat, ca.sec_gru, cu.nom_cur, cu.sem_anu, ";
			$vQuery .= "cu.cod_esp, gr.sec_des, mn.not_des, cr.car_des ";
			$vQuery .= "from $tCarga ca left join curso cu on ca.cod_car = cu.cod_car and ";
			$vQuery .= "ca.pln_est = cu.pln_est and ca.cod_cur = cu.cod_cur ";
			$vQuery .= "left join grupo gr on ca.sec_gru = gr.sec_gru ";
			$vQuery .= "left join modnot mn on ca.mod_mat = mn.mod_not ";
			$vQuery .= "left join carrera cr on ca.cod_car = cr.cod_car ";
			$vQuery .= "where ca.per_aca = '{$_SESSION['sFrameper_aca']}' and cod_prf = '{$_SESSION['sUsercod_usu']}' ";
			$vQuery .= "order by cod_car, sem_anu, cod_esp, sec_gru ";
			
			$cResult = fQuery($vQuery);
			$vNum_rows = fCountq($cResult);
			while($aResult = mysql_fetch_array($cResult))
			{
			?>
				<tr <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)">
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$vCont?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['nom_cur']))?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['sem_anu']?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['cod_esp']?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['sec_des']))?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['not_des']))?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['car_des']))?></td>
			  	  <td <?=ftdstyle($vNum_rows, $vCont)?>><a href="" onclick="act_viewestumat('<?=$aResult['cod_car']?>', '<?=$aResult['pln_est']?>', '<?=$aResult['cod_cur']?>', '<?=$aResult['sec_gru']?>', '<?=$aResult['mod_mat']?>'); return false;" class="enlaceb"><img src="../images/browse.png" alt="Ver estudiantes" width="16" height="16" /></a></td>
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
	else
	{
?>
	<center>
	<span class="wordi"><strong>El &uacute;ltimo d&iacute;a para el ingreso de Notas via Internet es <br />
	el Lunes 30 de Enero del 2009 hasta las 11:59 del d&iacute;a </strong><br />
	FECHA Y HORA: <?=fFechastd(fFecha())?> </span>
	</center>

<?
	}

	// Centro de Idiomas
	$vQuery = "select dc.cod_doc from docentes dc where dc.num_doc = '{$_SESSION['sUsernum_doc']}' ";
	
	$xSerdata = mysql_connect($_SESSION["sDbiHost"], $_SESSION["sDbiUser"], $_SESSION["sDbiPasswd"]) or die("Error");
	if($xSerdata)
	{
	$cResult = fQueryi($vQuery);
	if($aResult = mysql_fetch_array($cResult))
	{
		$vCont = 1;
		$_SESSION['sUsercod_doci'] = $aResult['cod_doc'];
?>
	<center>
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Ingreso de notas del Centro de Idiomas </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="0" bordercolor="#FF0000" class="tlistsearch">
				<tr>
				  <th width="10">&nbsp;</th>
				  <th width="50">C&oacute;digo</th>
				  <th width="80">Idioma</th>
				  <th width="100">Curso</th>
				  <th width="30">Gpo</th>
				  <th width="40">H.Ini.</th>
				  <th width="40">H.Fin</th>
				  <th width="16">&nbsp;</th>
				</tr>
			<?
			//$tCarga = "cargaint".$_SESSION['sFrameano_aca'];
			
			$vQuery = "select gp.cod_gpo, gp.cod_esp, es.nom_esp, gp.cod_cur, cu.des_cur, gp.cod_sec, sc.des_sec, ";
			$vQuery .= "  gp.hra_ini, substring(hr1.des_hra, 1, 5) as dhra_ini, gp.hra_fin, ";
			$vQuery .= "  substring(hr2.des_hra, 1, 5) as dhra_fin ";
			$vQuery .= "from gruposhab gp ";
			$vQuery .= "left join especialidades es on gp.cod_esp = es.cod_esp ";
			$vQuery .= "left join cursos cu on gp.cod_cur = cu.cod_cur ";
			$vQuery .= "left join seccion sc on gp.cod_sec = sc.cod_sec ";
			$vQuery .= "left join horas hr1 on gp.hra_ini = hr1.cod_hra ";
			$vQuery .= "left join horas hr2 on gp.hra_fin = hr2.cod_hra ";
			$vQuery .= "where gp.anio = '{$_SESSION['sFrameano_acai']}' and gp.cod_mes = '{$_SESSION['sFramecod_mesi']}' and ";
			$vQuery .= "gp.cod_doc = '{$_SESSION['sUsercod_doci']}' ";
			$vQuery .= "order by gp.hra_ini, gp.hra_fin, gp.cod_esp, gp.cod_cur, gp.cod_sec ";
			
			$cResult = fQueryi($vQuery);
			$vNum_rows = fCountqi($cResult);
			while($aResult = mysql_fetch_array($cResult))
			{
			?>
				<tr <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)">
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$vCont?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['cod_gpo']?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['nom_esp']?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['des_cur']?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['des_sec']?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['dhra_ini']?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['dhra_fin']?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><a href="" onclick="act_viewestumati('<?=$aResult['cod_gpo']?>'); return false;" class="enlaceb"><img src="../images/browse.png" alt="Ver estudiantes" width="16" height="16" /></a></td>
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
	}
?>