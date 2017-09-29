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
	  <table border="1" cellpadding="0" cellspacing="0" bordercolor="#BDD37B" class="tlistdata">
        <tr>
          <th width="20" bgcolor="#CCCCCC">N&deg;</th>
          <th width="30" bgcolor="#CCCCCC">C&oacute;digo</th>
          <th width="300" bgcolor="#CCCCCC">Apellidos y Nombres</th>
          <th width="60" bgcolor="#CCCCCC">Modalidad</th>
        </tr>
        <?				
				$cResult = fQuery($_SESSION['sPrnSql2']);
				$vNum_rows = fCountq($cResult);
				while($aResult = mysql_fetch_array($cResult))
				{
					
			  ?>
        <tr>
          <td><?=$vCont?></td>
          <td><?=$aResult['num_mat']?></td>
          <td><?=$aResult['nom_est']?></td>
          <td><?=ucwords(strtolower($aResult['mod_des']))?></td>
        </tr>
        <?
					$vCont++;
			  	}
			  ?>
</table>

<?
	}
?>