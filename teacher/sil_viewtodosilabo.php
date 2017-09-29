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
		$vCont = 1;
	}
	else
	{
		header("Location:../index.php");
	}
	if($bDatos == TRUE)
	{
?>
<center>
	<span class="wordi"><strong>EL INGRESO DE SILABUS TERMINA INDEFECTIBLEMENTE <br>
                        EL MARTES 11 DE MARZO A HORAS: 11:59 PM </strong></span>
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Silabos del [<?=$_SESSION['sSilaano_aca']?> - <?=$_SESSION['sSilaper_aca']?>] </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="0" bordercolor="#FF0000" class="tlistsearch">
				<tr>
				  <th width="10">&nbsp;</th>
				  <th width="270">Curso</th>
				  <th width="20">Sm</th>
				  <th width="20">Es</th>
				  <th width="40">Grupo</th>
				  <th width="50">Modalidad</th>
				  <th width="180">Escuela Profesional </th>
		  	      <th width="16">&nbsp;</th>
				  <th width="16">&nbsp;</th>
				</tr>
				
			<?
			$vCod_car = "";
			$vSem_anu = "";
			
			$tSilabo = "silabo".$_SESSION['sSilaano_aca'];
			
			/*$vQuery = "select si.cod_car, si.pln_est, si.cod_cur, si.mod_mat, si.sec_gru, cu.nom_cur, cu.sem_anu, ";
			$vQuery .= "cu.cod_esp, gr.sec_des, mn.not_des, cr.car_des ";
			$vQuery .= "from $tSilabo si left join curso cu on si.cod_car = cu.cod_car and ";
			$vQuery .= "si.pln_est = cu.pln_est and si.cod_cur = cu.cod_cur ";
			$vQuery .= "left join grupo gr on si.sec_gru = gr.sec_gru ";
			$vQuery .= "left join modnot mn on si.mod_mat = mn.mod_not ";
			$vQuery .= "left join carrera cr on si.cod_car = cr.cod_car ";
			$vQuery .= "where si.per_aca = '{$_SESSION['sSilaper_aca']}' and si.cod_prf = '{$_SESSION['sUsercod_usu']}' ";
			$vQuery .= "order by cod_car, sem_anu, cod_esp, sec_gru ";*/
			
			$vQuery = "select si.cod_car, si.pln_est, si.cod_cur, si.mod_mat, si.sec_gru, cu.nom_cur, cu.sem_anu, ";
			$vQuery .= "cu.cod_esp, gr.sec_des, mn.not_des, cr.car_des ";
			$vQuery .= "from $tSilabo si left join curso cu on si.cod_car = cu.cod_car and ";
			$vQuery .= "si.pln_est = cu.pln_est and si.cod_cur = cu.cod_cur ";
			$vQuery .= "left join grupo gr on si.sec_gru = gr.sec_gru ";
			$vQuery .= "left join modnot mn on si.mod_mat = mn.mod_not ";
			$vQuery .= "left join carrera cr on si.cod_car = cr.cod_car ";
			$vQuery .= "where si.per_aca = '{$_SESSION['sSilaper_aca']}' ";
			$vQuery .= "order by cod_car, sem_anu, cod_esp, sec_gru ";
			
			
			$cResult = fQuery2($vQuery);
			$vNum_rows = fCountq($cResult);
			while($aResult = mysql_fetch_array($cResult))
			{
				if($vCod_car != $aResult['cod_car'])
				{
					$vCod_car = $aResult['cod_car'];
			?>
				<tr>
				  <td>&nbsp;</td>
				  <td colspan="8" class="wordizqb">Escuela Profesional: <?=$aResult['car_des']?></td>
			  </tr>
			  <?
			  	}
				if($vSem_anu != $aResult['sem_anu'])
				{
					$vSem_anu = $aResult['sem_anu'];
			  ?>
				<tr>
				  <td>&nbsp;</td>
				  <td colspan="8" class="wordizqb">Semestre: <?=$aResult['sem_anu']?></td>
			  </tr>
			  <?
			  	}
			  ?>
				<tr <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)">
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$vCont?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['nom_cur']))?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['sem_anu']?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['cod_esp']?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['sec_des']))?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['not_des']))?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['car_des']))?></td>
		  	      <td <?=ftdstyle($vNum_rows, $vCont)?>><a href="" onclick="sil_updsilabo('<?=$aResult['cod_car']?>', '<?=$aResult['pln_est']?>', '<?=$aResult['cod_cur']?>', '<?=$aResult['sec_gru']?>', '<?=$aResult['mod_mat']?>'); return false;" class="enlaceb"><img src="../images/edit.png" alt="Modificar Silabo" width="16" height="16" /></a></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><a href="" onclick="sil_delsilabopre('<?=$aResult['cod_car']?>', '<?=$aResult['pln_est']?>', '<?=$aResult['cod_cur']?>', '<?=$aResult['sec_gru']?>', '<?=$aResult['mod_mat']?>'); return false;" class="enlaceb"><img src="../images/drop.png" alt="Eliminar Silabo" width="16" height="16" /></a></td>
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
	<?	
		if($_SESSION['sSilaend_ing'] == 'F')
		{
	?>
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td><div class="dboton"><a href="" onclick = "sil_newsilabo(); return false;" class="inew" title="Nuevo Silabo">Nuevo Sil.</a></div>
			</td>
		  </tr>
		</table>	
	<?
		}
	?>
	
	
			
</center>
<?
	}
?>
