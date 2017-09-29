<?
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=relcurso.xls");
	session_start();
	include "../include/funcget.php";
	include "../include/funcsql.php";
	if(fsafetylogin())
	{
		$bDatos = FALSE;
		$vCont = 1;
		
		$cResult = fQuery($_SESSION['sPrnSql1']);
		$vNum_rows = fCountq($cResult);
		if($aResult = mysql_fetch_array($cResult))
		{
			$bDatos = TRUE;
		}
		
		//---------------------------------------------
		$vCont = 1;
		$vCan_cap = 0;
		$vCan_act = 0;

		$vPro_cap = 0;
		$vPro_act = 0;
		$vPro_fin = 0;
		
		//----------------------------------------------------
		$cCan_cap = fQuery2($_SESSION['sPrnSql2']);
		if($aCan_cap = mysql_fetch_array($cCan_cap))
			$vCan_cap = $aCan_cap['ord_not'];

		//----------------------------------------------------
		$cCan_act = fQuery2($_SESSION['sPrnSql3']);
		if($aCan_act = mysql_fetch_array($cCan_act))
			$vCan_act = $aCan_act['ord_not'];
		
		(empty($vCan_cap)?$vCan_cap=0:$vCan_cap=$vCan_cap);
		(empty($vCan_act)?$vCan_act=0:$vCan_act=$vCan_act);
		//----------------------------------------------------
		if($vCan_cap > 0)
		{
			$cNotacap = fQuery2($_SESSION['sPrnSql4']);
			while($aNotacap = mysql_fetch_array($cNotacap))
				$sNotacap[$aNotacap['num_mat']][$aNotacap['ord_not']] = $aNotacap['not_cur'];
		}			
		if($vCan_act > 0)
		{
			$cNotaact = fQuery2($_SESSION['sPrnSql5']);
			while($aNotaact = mysql_fetch_array($cNotaact))
				$sNotaact[$aNotaact['num_mat']][$aNotaact['ord_not']] = $aNotaact['not_cur'];
		}	
		//----------------------------------------------------		
		
		$bDatos = TRUE;
		//---------------------------------------------
		
		
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{
?>
	
	  <table border="1" cellpadding="0" cellspacing="0" bordercolor="#BDD37B" class="tviewdata">
        <tr>
          <td width="10">&nbsp;</td>
          <td bgcolor="#CCCCCC" ><strong>Curso :</strong></td>
          <td colspan="3" align="left"><?=$aResult['nom_cur']?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td bgcolor="#CCCCCC"><strong>Escuela Prof. : </strong></td>
          <td colspan="3" align="left"><?=$aResult['car_des']?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td bgcolor="#CCCCCC"><strong>Menci&oacute;n : </strong></td>
          <td colspan="3" align="left"><?=$aResult['esp_nom']?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td width="75" bgcolor="#CCCCCC"><strong>Semestre :</strong></td>
          <td width="150" align="left"><?=$aResult['sem_des']?></td>
          <td width="75" bgcolor="#CCCCCC"><strong>Modalidad :</strong></td>
          <td width="150" align="left"><?=$aResult['mod_des']?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td bgcolor="#CCCCCC"><strong>Grupo :</strong></td>
          <td align="left"><?=$aResult['sec_des']?></td>
          <td bgcolor="#CCCCCC"><strong>Creditos :</strong></td>
          <td align="left"><?=$aResult['crd_cur']?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td>&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
</table>
	  <table border="1" cellpadding="0" cellspacing="0"  bordercolor="#BDD37B" class="tviewdata">
			  <tr>
			    <th width="15" rowspan="2" bgcolor="#CCCCCC" >N&deg;</th>
			    <th width="30" rowspan="2" bgcolor="#CCCCCC">C&oacute;digo </th>
				<th width="210" rowspan="2" bgcolor="#CCCCCC">Apellidos y Nombres </th>
		        <th width="60" rowspan="2" bgcolor="#CCCCCC">Modalidad</th>
		        <th rowspan="2" bgcolor="#CCCCCC">&nbsp;</th>
		        <th width="40" colspan="2" bgcolor="#CCCCCC">Capacidades</th>
		        <th width="18" rowspan="2" bgcolor="#FFFF79">PC</th>
		        <th width="40" colspan="2" bgcolor="#CCCCCC">Actitudes</th>
		        <th width="17" rowspan="2" bgcolor="#FFFF79">PA</th>
		        <th width="18" rowspan="2" bgcolor="#FFFF79">PF</th>
			  </tr>
			  
			  <tr class="trpar" id="p" >
			    <td colspan="2" bgcolor="#CCCCCC"><table border="0" cellpadding="0" cellspacing="0" class="tlistdata">
                 <tr class="celdainpar">
					<?	for($i = 0; $i < $vCan_cap;$i++)	{  ?>
                   <td width="17" >C-<?=$i+1?></td>
					<?	}	?>
                 </tr>
               </table></td>
			    <td colspan="2" bgcolor="#CCCCCC"><table border="0" cellpadding="0" cellspacing="0" class="tlistdata">
                 <tr class="celdainpar">
					<?	for($i = 0; $i < $vCan_act;$i++)	{  ?>
                   <td width="17">A-<?=$i+1?></td>
					<?	}	?>
                 </tr>
               </table></td>
		      </tr>
			  <?
				$cResult = fQuery2($_SESSION['sPrnSql6']);
				$vNum_rows = fCountq2($cResult);
				while($aResult = mysql_fetch_array($cResult))
				{
					$vPro_cap = 0;
					$vPro_act = 0;
			  ?>
			  <tr>
			    <td><?=$vCont?></td>
			    <td><?=$aResult['num_mat']?></td>
			    <td><?=ucwords(strtolower($aResult['nom_est']))?></td>
		        <td><?=ucwords(strtolower($aResult['mod_des']))?></td>
	            <td>&nbsp;</td>
	            <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="tlistdata" >
                 <tr >
					<?	for($i = 0; $i < $vCan_cap;$i++)	{	$vPro_cap += $sNotacap[$aResult['num_mat']][$i+1];  ?>
                   <td width="17" ><font color="#<?=($sNotacap[$aResult['num_mat']][$i+1]>10?"0000FF":"FF0000")?>"><?=$sNotacap[$aResult['num_mat']][$i+1]?></font></td>
					<?	}	
						if($vCan_cap > 0)	
							$vPro_cap = round($vPro_cap/$vCan_cap);						
					?>
                 </tr>
               </table></td>
	            <td bgcolor="#FFFF79" ><font color="#<?=($vPro_cap>10?"0000FF":"FF0000")?>">
				<?	if($vCan_cap > 0)	{	echo $vPro_cap;	} ?>				</font></td>
	            <td colspan="2" ><table border="0" cellpadding="0" cellspacing="0" class="tlistdata" >
                 <tr >
					<?	for($i = 0; $i < $vCan_act;$i++)	{	$vPro_act += $sNotaact[$aResult['num_mat']][$i+1];  ?>
                   <td width="17"  class="tdnotaapr"><font color="#0000FF"><?=$sNotaact[$aResult['num_mat']][$i+1]?></font></td>
					<?	}	
						if($vCan_act > 0)	
							$vPro_act = round($vPro_act/$vCan_act);						
					?>
                 </tr>
               </table></td>
	            <td bgcolor="#FFFF79"><font color="#0000FF">
				<?	if($vCan_act > 0)	{	echo $vPro_act;	} ?></font></td>
				<?
					if($vCan_cap > 0 || $vCan_act > 0)	
					{	
						if($vCan_act > 0)	$vPro_fin = round(($vPro_cap * 0.9) + $vPro_act);	
						else $vPro_fin = $vPro_cap;
					}
				?>
				<td bgcolor="#FFFF79" ><strong><font color="#<?=( $vPro_fin>10?"0000FF":"FF0000")?>">
				<?	if($vCan_cap > 0 || $vCan_act > 0)	{	echo $vPro_fin;	}	?></font></strong></td>
			  </tr>
			  <?
					$vCont++;
			  	}
			  ?>
</table>

<?
	}
?>