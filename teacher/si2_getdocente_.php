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
	include "../include/funcoption.php";
	if(fsafetylogin())
	{
		$bDatos = FALSE;
						
		if($_POST['rIns_upd'] == 'i')
		{
			if(!empty($_POST['rCod_cur']) and !empty($_POST['rSec_gru']) and !empty($_POST['rMod_mat']))
			{
				$vQuery = "select cur.nom_cur, esp.esp_nom, sem.sem_des, gru.sec_des ";
				$vQuery .= "from ( ";
				$vQuery .= "   select cod_car, pln_est, cod_cur, nom_cur, cod_esp, sem_anu, '{$_POST['rSec_gru']}' as sec_gru ";
				$vQuery .= "   from curso ";
				$vQuery .= "   where cod_car = '{$_SESSION['sSilacod_car']}' and pln_est = '{$_SESSION['sSilapln_est']}' and ";
				$vQuery .= "      cod_cur = '{$_POST['rCod_cur']}' ";
				$vQuery .= ") cur ";
				$vQuery .= "left join especial esp on cur.cod_car = esp.cod_car and ";
				$vQuery .= "cur.pln_est = esp.pln_est and cur.cod_esp = esp.cod_esp ";
				$vQuery .= "left join semestre sem on cur.sem_anu = sem.sem_anu ";
				$vQuery .= "left join grupo gru on cur.sec_gru = gru.sec_gru ";
			
				$cResult = fQuery2($vQuery);
				if($aResult = mysql_fetch_array($cResult))
				{
					$_SESSION["sSilacod_cur"] = $_POST['rCod_cur'];
					$_SESSION["sSilasec_gru"] = $_POST['rSec_gru'];
					$_SESSION["sSilamod_mat"] = $_POST['rMod_mat'];
					
					$_SESSION["sSilanom_cur"] = $aResult['nom_cur'];
					$_SESSION["sSilaesp_nom"] = $aResult['esp_nom'];
					$_SESSION["sSilasem_des"] = $aResult['sem_des'];
					$_SESSION["sSilasec_des"] = $aResult['sec_des'];
					
					$vQuery = "select not_des from modnot where mod_not = '{$_SESSION['sSilamod_mat']}' ";
			
					$cResult = fQuery2($vQuery);
					if($aResult = mysql_fetch_array($cResult))
					{
						$_SESSION["sSilamat_des"] = $aResult['not_des'];
						$bDatos = TRUE;
					}					
				}
			}
		}
		elseif($_POST['rIns_upd'] == 'u')
		{
			if(!empty($_POST['rCod_car']) and !empty($_POST['rPln_est']) and !empty($_POST['rCod_cur']) and  !empty($_POST['rSec_gru']) and !empty($_POST['rMod_mat']))
			{
				$vQuery = "select cur.nom_cur, esp.esp_nom, sem.sem_des, gru.sec_des ";
				$vQuery .= "from ( ";
				$vQuery .= "   select cod_car, pln_est, cod_cur, nom_cur, cod_esp, sem_anu, '{$_POST['rSec_gru']}' as sec_gru ";
				$vQuery .= "   from curso ";
				$vQuery .= "   where cod_car = '{$_POST['rCod_car']}' and pln_est = '{$_POST['rPln_est']}' and ";
				$vQuery .= "      cod_cur = '{$_POST['rCod_cur']}' ";
				$vQuery .= ") cur ";
				$vQuery .= "left join especial esp on cur.cod_car = esp.cod_car and ";
				$vQuery .= "cur.pln_est = esp.pln_est and cur.cod_esp = esp.cod_esp ";
				$vQuery .= "left join semestre sem on cur.sem_anu = sem.sem_anu ";
				$vQuery .= "left join grupo gru on cur.sec_gru = gru.sec_gru ";
			
				$cResult = fQuery2($vQuery);
				if($aResult = mysql_fetch_array($cResult))
				{
					$tSilabo = "silabo".$_SESSION['sSilaano_aca'];
					
					$_SESSION["sSilacod_car"] = $_POST['rCod_car'];
					$_SESSION["sSilapln_est"] = $_POST['rPln_est'];
					$_SESSION["sSilacod_cur"] = $_POST['rCod_cur'];
					$_SESSION["sSilasec_gru"] = $_POST['rSec_gru'];
					$_SESSION["sSilamod_mat"] = $_POST['rMod_mat'];
					$_SESSION["sSilasem_anu"] = "01";
					$_SESSION["sSilacan_cap"] = 1;
					$_SESSION["sSilacan_act"] = 1;
					$_SESSION["sSilacan_cap2"] = 0;
					$_SESSION["sSilacan_act2"] = 0;
					$_SESSION["sSilacaiu"] = $_POST['rIns_upd'];
					
					$_SESSION["sSilanom_cur"] = $aResult['nom_cur'];
					$_SESSION["sSilaesp_nom"] = $aResult['esp_nom'];
					$_SESSION["sSilasem_des"] = $aResult['sem_des'];
					$_SESSION["sSilasec_des"] = $aResult['sec_des'];
					
					$vQuery = "select can_cap, can_act ";
					$vQuery .= "from $tSilabo ";
					$vQuery .= "where pln_est = '{$_SESSION['sSilapln_est']}' and cod_cur = '{$_SESSION['sSilacod_cur']}' and ";
					$vQuery .= "sec_gru = '{$_SESSION['sSilasec_gru']}' and mod_mat = '{$_SESSION['sSilamod_mat']}' and ";
					$vQuery .= "cod_car = '{$_SESSION['sSilacod_car']}' and ano_aca = '{$_SESSION['sSilaano_aca']}' and ";
					$vQuery .= "per_aca = '{$_SESSION['sSilaper_aca']}' ";
					
					$cResult2 = fQuery2($vQuery);
					if($aResult2 = mysql_fetch_array($cResult2))
					{
						$_SESSION["sSilacan_cap"] = $aResult2['can_cap'];
						$_SESSION["sSilacan_act"] = $aResult2['can_act'];
					}
					$bDatos = TRUE;
				}
			}
		}
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{	
		$vQuery = "select dc.cod_prf, dc.cod_car, dc.dep_aca, dc.cnd_prf, dc.cod_cat, dc.cod_gru, dc.esp_doc, ";
		$vQuery .= "     ca.car_des, da.dep_des, cd.cnd_des, ct.cat_des, gd.gru_des, dc.email ";
		$vQuery .= "from docente dc ";
		$vQuery .= "     left join carrera ca on dc.cod_car = ca.cod_car ";
		$vQuery .= "     left join depacad da on dc.dep_aca = da.dep_aca ";
		$vQuery .= "     left join condocen cd on dc.cnd_prf = cd.cnd_prf ";
		$vQuery .= "     left join catedocen ct on dc.cod_cat = ct.cod_cat ";
		$vQuery .= "     left join grudocen gd on dc.cod_gru = gd.cod_gru ";
		$vQuery .= "where dc.cod_prf = '{$_SESSION['sUsercod_usu']}' and dc.cod_car = '{$_SESSION['sUsercod_car']}' ";
		
		$cUser = fQuery($vQuery);
		if($aUser = mysql_fetch_array($cUser))
		{
			$bDatos = TRUE;
		}	
?>
<center>
	<form action="sil_savearchivo.php" method="post" enctype="multipart/form-data" name="fData" id="fData">
	
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Curso: <?=$_SESSION['sSilanom_cur']?></th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
			  <tr>
			    <td>Menci&oacute;n : </td>
			    <th colspan="3"><?=$_SESSION['sSilaesp_nom']?></th>
		      </tr>
			  <tr>
			    <td width="75">Semestre :</td>
			    <th width="150"><?=$_SESSION['sSilasem_des']?></th>
			    <td width="75">Grupo :</td>
			    <th width="150"><?=$_SESSION['sSilasec_des']?></th>
		      </tr>
			  <tr>
			    <td>Modalidad : </td>
			    <th><?=$_SESSION['sSilamat_des']?></th>
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
	<strong>I. IDENTIFICACI&Oacute;N	ACAD&Eacute;MICA  </strong>
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">1.2 Docente </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center"><div id="dsilabo">
			
			<table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
			  <tr>
			    <td width="100">Nomb. y Apell. : </td>
			    <th width="350"><?=$_SESSION['sUsernombres']?> <?=$_SESSION['sUserpaterno']?> <?=$_SESSION['sUsermaterno']?></th>
		      </tr>
			  <tr>
			    <td>Escuela Prof. : </td>
			    <th><?=$aUser['car_des']?></th>
		      </tr>
			  <tr>
			    <td>Dep. Acad&eacute;mico : </td>
			    <th><?=$aUser['dep_des']?></th>
		      </tr>
			  <tr>
				<td>Condici&oacute;n : </td>
				<th><?=$aUser['cnd_des']?></th>
			  </tr>
			  <tr>
				<td>Categor&iacute;a : </td>
				<th><?=$aUser['cat_des']?></th>
			  </tr>
			  <tr>
			    <td>Dedicaci&oacute;n : </td>
			    <th><?=$aUser['gru_des']?></th>
		      </tr>
			  <tr>
			    <td>E-mail : </td>
			    <th><input name="rEmail" type="text" class="" id="rEmail" value="<?=$aUser['email']?>" size="40" maxlength="40"/></th>
		      </tr>
			  <tr>
			    <td>Especialidad : </td>
			    <th><input name="rEsp_doc" type="text" class="" id="rEsp_doc" value="<?=$aUser['esp_doc']?>" size="50" maxlength="50" onblur="fupper(this);"/></th>
		      </tr>
			</table>
			</div></td>
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
        <th background="../images/ven_topcenter.jpg">1.3 Ambiente donde se realiza el aprendizaje </th>
        <td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
      </tr>
      <tr>
        <td background="../images/ven_mediumleft.jpg"></td>
        <td align="center"><div id="div">
          <table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">

                  <tr>
                    <td width="80">C&oacute;digo : </td>
                    <th width="200"><input name="rCod_amb" type="text" class="" id="rCod_amb" value="<?=$_SESSION['sSilacod_amb']?>" size="20" maxlength="20" onblur="fupper(this);"/></th>
                  </tr>
                </table>
          <table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div class="dboton"><a href="" onclick = "si2_getfuncon(document.fData); return false;" class="icontinue" title="Aceptar">Continuar</a></div>
                        <div class="dboton"><a href="" onclick="<?=($_SESSION["sSilacaiu"]=='i'?"clicksilabo()":"clicksilabo()")?>; return false;" class="icancel" title="Cancelar">Cancelar</a></div></td>
                  </tr>
                </table>
        </div></td>
        <td background="../images/ven_mediumright.jpg"></td>
      </tr>
      <tr>
        <td><img src="../images/ven_bottomleft.jpg" width="16" height="16" border="0" alt="" /></td>
        <td background="../images/ven_bottomcenter.jpg"></td>
        <td><img src="../images/ven_bottomright.jpg" width="16" height="16" border="0" alt="" /></td>
      </tr>
    </table>
	</form>	
</center>
<?
	}
?>