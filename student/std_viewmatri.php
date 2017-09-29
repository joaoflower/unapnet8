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
		if($_SESSION['sEstumat_ya'] == TRUE)
		{
			$tEstumat = "estumat".$_SESSION['sUsercod_car'].$_SESSION['sFrameano_aca'];
			$vQuery = "select em.niv_est, se.sem_des, em.mod_mat, mm.mod_des, em.tot_crd ";
			$vQuery .= "from $tEstumat em left join semestre se on em.niv_est = se.sem_anu ";
			$vQuery .= "left join modmat mm on em.mod_mat = mm.mod_mat ";
			$vQuery .= "where em.num_mat = '{$_SESSION['sUsercod_usu']}' and em.per_aca = '{$_SESSION['sFrameper_aca']}' ";
			$cResult = fQuery($vQuery);
			if($aResult = mysql_fetch_array($cResult))
				$bDatos = TRUE;
		}
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{
		$vNum_rows = 0;
		$vCont = 1;
?>
<center>
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Matricula realizada </th>
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
			    <th width="150"><?=$aResult['sem_des']?></th>
		        <td width="100">Modalidad : </td>
		        <th width="150"><?=$aResult['mod_des']?></th>
			  </tr>
			  <tr>
			    <td>Crd. Mat. : </td>
			    <th><?=$aResult['tot_crd']?> cr&eacute;ditos </th>
			    <td>&nbsp;</td>
			    <th>&nbsp;</th>
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
        <th background="../images/ven_topcenter.jpg">Cursos matriculados </th>
        <td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
      </tr>
      <tr>
        <td background="../images/ven_mediumleft.jpg"></td>
        <td align="center"><table border="0" cellpadding="0" cellspacing="0" class="tlistdata">
            <tr>
              <th width="15">N&deg;</th>
              <th width="20">C&oacute;d </th>
              <th width="330">Nombre de curso </th>
              <th width="15">Sm</th>
              <th width="60">Modalidad</th>
              <th width="50">Grupo</th>
              <th width="25">Crd</th>
            </tr>            
            <?
				$tCurmat = "curmat".$_SESSION['sUsercod_car'].$_SESSION['sFrameano_aca'];
				
				$vQuery = "select cm.cod_cur, cu.nom_cur, cu.sem_anu, mm.mod_des, gr.sec_des, cu.crd_cur ";
				$vQuery .= "from $tCurmat cm left join curso cu on cm.cod_car = cu.cod_car and ";
				$vQuery .= "cm.pln_est = cu.pln_est and cm.cod_cur = cu.cod_cur ";
				$vQuery .= "left join modmat mm on cm.mod_mat = mm.mod_mat ";
				$vQuery .= "left join grupo gr on cm.sec_gru = gr.sec_gru ";
				$vQuery .= "where cm.num_mat = '{$_SESSION['sUsercod_usu']}' and cm.per_aca = '{$_SESSION['sFrameper_aca']}' ";
				$cResult = fQuery($vQuery);
				$vNum_rows = fCountq($cResult);
				while($aResult = mysql_fetch_array($cResult))
				{
			 ?>
					
			<tr <?=ftrstyle($vCont)?>  onmouseover="mouseover(this)" onmouseout="mouseout(this)" id="rTr<?=$aCurso['cod_cur']?>">
              <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$vCont?></td>
              <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['cod_cur']?></td>
              <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['nom_cur']?></td>
              <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['sem_anu']?></td>
              <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['mod_des']))?></td>
              <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['sec_des']))?></td>
              <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['crd_cur']?></td>
            </tr>
            <?
			  		$vCont++;
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
</center>
<?
	}
	else
	{
?>
	<center>
	<span class="wordi"><strong>ACCESO RESTRINGIDO<br />
	SE CERRARA EL SISTEMA  </strong></span>
	</center>
<?
	}
?>