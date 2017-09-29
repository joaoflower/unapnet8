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
		
		$cResult = fQueryi($_SESSION['sPrnSql1']);
		$vNum_rows = fCountqi($cResult);
		if($aResult = mysql_fetch_array($cResult))
		{
			$bDatos = TRUE;
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
          <td height="22">&nbsp;</td>
          <td colspan="4" >&nbsp;</td>
        </tr>
        <tr>
          <td height="22">&nbsp;</td>
          <td colspan="4" ><strong>Universidad Nacional del Altiplano - Puno </strong></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="4"><strong>Centro de Idiomas </strong></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
          <td width="10">&nbsp;</td>
          <td width="75" bgcolor="#CCCCCC" ><strong>Curso :</strong></td>
          <td align="left"><?=$aResult['des_cur']?></td>
          <td width="75" bgcolor="#CCCCCC" ><strong>&nbsp;A&ntilde;o-Mes:</strong></td>
          <td align="left"><?=$_SESSION['sFrameano_acai']?> - <?=$_SESSION['sFramecod_mesi']?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td bgcolor="#CCCCCC"><strong>Idioma : </strong></td>
          <td colspan="3" align="left"><?=$aResult['nom_esp']?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td bgcolor="#CCCCCC"><strong>Grupo :</strong></td>
          <td width="150" align="left"><?=$aResult['des_sec']?></td>
          <td width="75" bgcolor="#CCCCCC"><strong>Horario :</strong></td>
          <td width="150" align="left"><?=$aResult['dhra_ini']?> - <?=$aResult['dhra_fin']?></td>
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
			    <th width="15" bgcolor="#CCCCCC" >N&deg;</th>
			    <th width="30" bgcolor="#CCCCCC">C&oacute;digo </th>
				<th width="210" bgcolor="#CCCCCC">Apellidos y Nombres </th>
		        <th width="60" bgcolor="#CCCCCC">Modalidad</th>
		        <th bgcolor="#CCCCCC">&nbsp;</th>
		        <th width="20" bgcolor="#CCCCCC">EE</th>
		        <th width="20" bgcolor="#CCCCCC">EO</th>
		        <th width="18" bgcolor="#FFFF79">PF</th>
	          </tr>
			  <?
				$cResult = fQueryi($_SESSION['sPrnSql6']);
				$vNum_rows = fCountqi($cResult);
				while($aResult = mysql_fetch_array($cResult))
				{
					
			  ?>
			  <tr>
			    <td><?=$vCont?></td>
			    <td><?=$aResult['codigo']?></td>
			    <td><?=ucwords(strtolower($aResult['nom_est']))?></td>
		        <td><?=ucwords(strtolower($aResult['des_con']))?></td>
	            <td>&nbsp;</td>
	            <td><font color="#<?=($aResult['escrito']>74?"0000FF":"FF0000")?>"><?=$aResult['escrito']?></font></td>
	            <td><font color="#<?=($aResult['oral']>74?"0000FF":"FF0000")?>"><?=$aResult['oral']?></font></td>
	            <td bgcolor="#FFFF79" ><font color="#<?=($aResult['final']>74?"0000FF":"FF0000")?>"><?=$aResult['final']?></font></td>
			  </tr>
			  <?
					$vCont++;
			  	}
			  ?>
</table>

<?
	}
?>