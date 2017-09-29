<?php
	session_start();
	include "../include/funcget.php";
	include "../include/funcsql.php";
	include "../include/funcstyle.php";
	include "../include/funcoption.php";
	
	if(fsafetylogin())
	{
		$_SESSION['sSilaupload'] = FALSE;
	}
	else
	{
		$_SESSION['sIni'] = "";
		header("Location:../index.php");
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/main.css">
<link rel="stylesheet" href="../css/frame.css">
<link rel="stylesheet" href="../css/framelogin.css">
<link rel="stylesheet" href="../css/style.css">
<title>Un@p.Net&reg; - Sistema Acad&eacute;mico via Web - UNA - Puno</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../js/ggw3.js"></script>
<script language="JavaScript" src="../js/function.js"></script>
<script language="JavaScript" src="../js/teacher.js"></script>
<script language="JavaScript">
	function enfocar()
	{
		maximizar();
	}

</script>
</head>

<body onLoad="enfocar();">
	<center>
	
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
                          <tr>
                            <td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
                            <th background="../images/ven_topcenter.jpg">Silabos del [
                                <?=$_SESSION['sSilaano_aca']?>
                              -
                              <?=$_SESSION['sSilaper_aca']?>
                              ] </th>
                            <td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
                          </tr>
                          <tr>
                            <td background="../images/ven_mediumleft.jpg"></td>
                            <td align="center"><table border="1" cellpadding="1" cellspacing="0" bordercolor="#333333" class="tlistsearch">
                                <tr>
                                  <th width="10">&nbsp;</th>
                                  <th width="400">Curso</th>
                                  <th width="20">Sm</th>
                                  <th width="20">Es</th>
                                  <th width="60">Grupo</th>
                                  <th width="50">Modalidad</th>
                                  <th width="40">&nbsp;</th>
                                  <th width="50">&nbsp;</th>
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
			$vQuery .= "cu.cod_esp, gr.sec_des, mn.not_des, cr.car_des, si.cod_prf ";
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
                                  <td colspan="7" class="wordizqb"><strong>Escuela Profesional:
                                  <?=$aResult['car_des']?></strong>                                 
                                  </td>
                                </tr>
                                <?
			  	}
				if($vSem_anu != $aResult['sem_anu'])
				{
					$vSem_anu = $aResult['sem_anu'];
			  ?>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="7" class="wordizqb"><strong>Semestre:
                                    <?=$aResult['sem_anu']?></strong></td>
                                </tr>
                                <?
			  	}
				$vDestino = "car".$aResult['cod_car']."/".$_SESSION['sSilaano_aca'];
				$vDestino .= $_SESSION['sSilaper_aca'].$aResult['cod_car'].$aResult["pln_est"];
				$vDestino .= $aResult["cod_cur"].$aResult["sec_gru"].$aResult["mod_mat"];
				$vDestino .= "_".$aResult['cod_prf'].".pdf";	
				
				$vDestino2 = "car".$aResult['cod_car']."/".$_SESSION['sSilaano_aca'];
				$vDestino2 .= $_SESSION['sSilaper_aca'].$aResult['cod_car'].$aResult["pln_est"];
				$vDestino2 .= $aResult["cod_cur"].$aResult["sec_gru"].$aResult["mod_mat"];
				$vDestino2 .= "_".$aResult['cod_prf'].".doc";	
			  ?>
                                <tr <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)">
                                  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$vCont?></td>
                                  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['nom_cur']))?></td>
                                  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['sem_anu']?></td>
                                  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['cod_esp']?></td>
                                  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['sec_des']))?></td>
                                  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=ucwords(strtolower($aResult['not_des']))?></td>
                                  <td <?=ftdstyle($vNum_rows, $vCont)?>><a href="<?=$vDestino?>" class="enlaceb">PDF</a></td>
                                  <td <?=ftdstyle($vNum_rows, $vCont)?>><a href="<?=$vDestino2?>" class="enlaceb">DOC</a></td>
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
</body>
</html>