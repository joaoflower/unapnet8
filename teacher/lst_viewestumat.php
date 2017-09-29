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
		
		$tCarga = "cargaint".$_SESSION['sFrameano_aca'];
		
		$vQuery = "select car.*, esp.esp_nom, sem.sem_des ";
		$vQuery .= "from ( ";
		$vQuery .= "select ca.cod_car, ca.pln_est, cu.nom_cur, cu.sem_anu, cu.cod_esp, gr.sec_des, ";
		$vQuery .= "mm.mod_des, cr.car_des, cu.crd_cur ";
		$vQuery .= "from $tCarga ca left join curso cu on ca.cod_car = cu.cod_car and ";
		$vQuery .= "ca.pln_est = cu.pln_est and ca.cod_cur = cu.cod_cur ";
		$vQuery .= "left join grupo gr on ca.sec_gru = gr.sec_gru ";
		$vQuery .= "left join modmat mm on ca.mod_mat = mm.mod_mat ";
		$vQuery .= "left join carrera cr on ca.cod_car = cr.cod_car ";
		$vQuery .= "where ca.per_aca = '{$_SESSION['sFrameper_aca']}' and ca.cod_car = '{$_POST['rCod_car']}' and ";
		$vQuery .= "ca.pln_est = '{$_POST['rPln_est']}' and ca.cod_cur = '{$_POST['rCod_cur']}' and ca.sec_gru = '{$_POST['rSec_gru']}' ";
		$vQuery .= ") car ";
		$vQuery .= "left join especial esp on car.cod_car = esp.cod_car and car.pln_est = esp.pln_est and ";
		$vQuery .= "car.cod_esp = esp.cod_esp ";
		$vQuery .= "left join semestre sem on car.sem_anu = sem.sem_anu";
		
		$_SESSION['sPrnSql1'] = $vQuery;
		
		$cResult = fQuery($vQuery);
		$vNum_rows = fCountq($cResult);
		if($aResult = mysql_fetch_array($cResult))
		{
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
	<center>
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Listado de Estudiantes por Curso </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
			  
			  <tr>
			    <td>Curso :</td>
			    <th colspan="3"><?=$aResult['nom_cur']?></th>
	          </tr>
			  <tr>
			    <td>Escuela Prof. : </td>
			    <th colspan="3"><?=$aResult['car_des']?></th>
		      </tr>
			  <tr>
			    <td>Menci&oacute;n : </td>
			    <th colspan="3"><?=$aResult['esp_nom']?></th>
		      </tr>
			  <tr>
			    <td width="75">Semestre :</td>
			    <th width="150"><?=$aResult['sem_des']?></th>
			    <td width="75">Modalidad :</td>
			    <th width="150"><?=$aResult['mod_des']?></th>
		      </tr>
			  <tr>
			    <td>Grupo :</td>
			    <th><?=$aResult['sec_des']?></th>
		        <td>Creditos :</td>
		        <th><?=$aResult['crd_cur']?></th>
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
		<th background="../images/ven_topcenter.jpg">Estudiantes matriculados </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="0" class="tlistdata">
			  <tr>
			    <th width="20">N&deg;</th>
			    <th width="30">C&oacute;digo </th>
				<th width="300">Apellidos y Nombres </th>
		        <th width="60">Modalidad</th>
		      </tr>
			  <?
				$tCurmat = "curmat".$_POST['rCod_car'].$_SESSION['sFrameano_aca'];
			  
			  	$vQuery = "select cm.num_mat, concat(es.paterno, ' ', es.materno, ', ',es.nombres) as nom_est, mm.mod_des ";
				$vQuery .= "from $tCurmat cm ";
				$vQuery .= "left join estudiante es on cm.num_mat = es.num_mat and cm.cod_car = es.cod_car ";
				$vQuery .= "left join modmat mm on cm.mod_mat = mm.mod_mat ";
				$vQuery .= "where cm.cod_car = '{$_POST['rCod_car']}' and cm.ano_aca = '{$_SESSION['sFrameano_aca']}' and ";
				$vQuery .= "cm.per_aca = '{$_SESSION['sFrameper_aca']}' and cm.pln_est = '{$_POST['rPln_est']}' and ";
				$vQuery .= "cm.cod_cur = '{$_POST['rCod_cur']}' and cm.sec_gru = '{$_POST['rSec_gru']}' and ";
				$vQuery .= "mm.mod_act = '{$_POST['rMod_mat']}'";
				$vQuery .= "order by nom_est ";
				
				$_SESSION['sPrnSql2'] = $vQuery;

				$cResult = fQuery($vQuery);
				$vNum_rows = fCountq($cResult);
				while($aResult = mysql_fetch_array($cResult))
				{
					
			  ?>
			  <tr <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)" id="rTr<?=$aResult['cod_cur']?>">
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$vCont?></td>
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['num_mat']?></td>
			    <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['nom_est']?></td>
		        <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['mod_des']))?></td>
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
	
	<table border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td>
			<div class="dboton"><a href="xls_estumatcurso.php" class="ireport" title="Imprimir" >Export XLS</a></div>
			<div class="dboton"><a href="" onClick="clicklistado(); return false;" class="icurso" title="Listar Cursos">Ver Cursos</a></div>	
		</td>
	  </tr>
	</table>

	</center>
<?
	}
?>