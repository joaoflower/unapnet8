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
		$tSilaok = "silaok".$_SESSION['sSilaano_aca'];	
					
		if($_POST['rIns_upd'] == 'i')
		{
			if($_SESSION["sSilacaiu"] == 'i')
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
				
					$cResult = fQuery($vQuery);
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
						
						//--------------------------------------------------
						$vQuery = "select cod_prf from $tSilaok where pln_est = '{$_SESSION['sSilapln_est']}' and ";
						$vQuery .= "cod_cur = '{$_SESSION['sSilacod_cur']}' and sec_gru = '{$_SESSION['sSilasec_gru']}' and ";
						$vQuery .= "mod_mat = '{$_SESSION['sSilamod_mat']}' and cod_car = '{$_SESSION['sSilacod_car']}' and ";
						$vQuery .= "ano_aca = '{$_SESSION['sSilaano_aca']}' and per_aca = '{$_SESSION['sSilaper_aca']}' and ";
						$vQuery .= "cod_prf = '{$_SESSION['sUsercod_usu']}' ";
						
						$cResult = fQuery($vQuery);
						if($aResult = mysql_fetch_array($cResult))
						{
							$_SESSION["sSilacaiu"] = 'u';
						}
						//-----------------------------------------------------									
					}
				}
			}
		}
		elseif($_POST['rIns_upd'] == 'u')
		{
			if(!empty($_POST['rCod_car']) and !empty($_POST['rPln_est']) and !empty($_POST['rCod_cur']) and !empty($_POST['rSec_gru']) and !empty($_POST['rMod_mat']))
			{
				$_SESSION["sSilacod_car"] = "";
				$_SESSION["sSilapln_est"] = "01";
			
				$_SESSION["sSilacod_cur"] = "999";
				$_SESSION["sSilasec_gru"] = "01";
				$_SESSION["sSilamod_mat"] = "01";
				$_SESSION["sSilasem_anu"] = "01";
				
				$_SESSION["sSilacaiu"] = $_POST['rIns_upd'];
				$_SESSION["sSilamat_des"] = "";
				
				$_SESSION["sSilanom_cur"] = "";
				$_SESSION["sSilaesp_nom"] = "";
				$_SESSION["sSilasem_des"] = "";
				$_SESSION["sSilasec_des"] = "";
				$_SESSION["sSilacod_amb"] = "";
						
				$_SESSION["sSilafun_sil"] = "";
				$_SESSION["sSilacan_cnt"] = 0;
				$_SESSION["sSilacnt1"] = "";
				$_SESSION["sSilacnt2"] = "";
				$_SESSION["sSilacnt3"] = "";
				$_SESSION["sSilacnt4"] = "";
				
				$_SESSION["sSilacan_com"] = 0;		
				$_SESSION["sSilacom1"] = "";
				$_SESSION["sSilacom2"] = "";
				$_SESSION["sSilacom3"] = "";
				$_SESSION["sSilacom4"] = "";
				$_SESSION["sSilacom5"] = "";
				$_SESSION["sSilacom6"] = "";		
		
				$_SESSION["sSilacan_una"] = 0;
				
				$_SESSION["sSilacan_cap"] = 0;
				$_SESSION["sSilacan_act"] = 0;
				$_SESSION["sSilacan_cap2"] = 6;
				$_SESSION["sSilacan_act2"] = 4;
				
				$_SESSION["sSilaact1"] = "";
				$_SESSION["sSilaact2"] = "";
				$_SESSION["sSilaact3"] = "";
				$_SESSION["sSilaact4"] = "";
								
				$_SESSION["sSilacont_una"] = 0;
				$_SESSION["sSilaunaiu"] = "";
			
				//-----------------------------
				$vQuery = "select cur.*, esp.esp_nom, sem.sem_des, gru.sec_des, mn.not_des from ( ";
				$vQuery .= "select si.pln_est, si.cod_cur, si.sec_gru, si.mod_mat, si.cod_car, cu.nom_cur, cu.cod_esp, cu.sem_anu ";
				$vQuery .= "from $tSilaok si left join curso cu on si.cod_car = cu.cod_car and si.pln_est = cu.pln_est and si.cod_cur = cu.cod_cur ";
				$vQuery .= "where si.pln_est = '{$_POST['rPln_est']}' and si.cod_cur = '{$_POST['rCod_cur']}' and ";
				$vQuery .= "si.sec_gru = '{$_POST['rSec_gru']}' and si.mod_mat = '{$_POST['rMod_mat']}' and si.cod_car = '{$_POST['rCod_car']}' and ";
				$vQuery .= "si.ano_aca = '{$_SESSION['sSilaano_aca']}' and si.per_aca = '{$_SESSION['sSilaper_aca']}' and ";
				$vQuery .= "si.cod_prf = '{$_SESSION['sUsercod_usu']}' ";
				$vQuery .= ")cur ";
				$vQuery .= "left join especial esp on cur.cod_car = esp.cod_car and ";
				$vQuery .= "cur.pln_est = esp.pln_est and cur.cod_esp = esp.cod_esp ";
				$vQuery .= "left join semestre sem on cur.sem_anu = sem.sem_anu ";
				$vQuery .= "left join grupo gru on cur.sec_gru = gru.sec_gru ";
				$vQuery .= "left join modnot mn on cur.mod_mat = mn.mod_not ";
				
				$cResult = fQuery($vQuery);
				if($aResult = mysql_fetch_array($cResult))
				{
					$bDatos = TRUE;
					/*$_SESSION["sSilacod_car"] = $_SESSION['sUsercod_car'];
					$_SESSION["sSilapln_est"] = $aResult['pln_est'];
					$_SESSION["sSilacod_cur"] = $aResult['cod_cur'];
					$_SESSION["sSilasec_gru"] = $aResult['sec_gru'];
					$_SESSION["sSilamod_mat"] = $aResult['mod_mat'];*/
					$_SESSION["sSilacod_car"] = $_POST['rCod_car'];
					$_SESSION["sSilapln_est"] = $_POST['rPln_est'];
					$_SESSION["sSilacod_cur"] = $_POST['rCod_cur'];
					$_SESSION["sSilasec_gru"] = $_POST['rSec_gru'];
					$_SESSION["sSilamod_mat"] = $_POST['rMod_mat'];
					$_SESSION["sSilasem_anu"] = $aResult['sem_anu'];
					
					$_SESSION["sSilamat_des"] = $aResult['not_des'];
					
					$_SESSION["sSilanom_cur"] = $aResult['nom_cur'];
					$_SESSION["sSilaesp_nom"] = $aResult['esp_nom'];
					$_SESSION["sSilasem_des"] = $aResult['sem_des'];
					$_SESSION["sSilasec_des"] = $aResult['sec_des'];
				}
			}
		}
		
		if($_SESSION["sSilacaiu"] == 'u')
		{
			$vQuery = "select cod_amb, fun_sil, can_cnt, cnt1, cnt2, cnt3, cnt4, can_com, com1, com2, com3, com4, com5, ";
			$vQuery .= "com6, can_una, can_cap, can_act, act1, act2, act3, act4 from $tSilaok ";
			$vQuery .= "where pln_est = '{$_SESSION['sSilapln_est']}' and ";
			$vQuery .= "cod_cur = '{$_SESSION['sSilacod_cur']}' and sec_gru = '{$_SESSION['sSilasec_gru']}' and ";
			$vQuery .= "mod_mat = '{$_SESSION['sSilamod_mat']}' and  cod_car = '{$_SESSION['sSilacod_car']}' and ";
			$vQuery .= "ano_aca = '{$_SESSION['sSilaano_aca']}' and per_aca = '{$_SESSION['sSilaper_aca']}' and ";
			$vQuery .= "cod_prf = '{$_SESSION['sUsercod_usu']}' ";
			
			$cResult = fQuery($vQuery);
			if($aResult = mysql_fetch_array($cResult))
			{
				$_SESSION["sSilacod_amb"] = $aResult['cod_amb'];
					
				$_SESSION["sSilafun_sil"] = $aResult['fun_sil'];
				$_SESSION["sSilacan_cnt"] = $aResult['can_cnt'];
				$_SESSION["sSilacnt1"] = $aResult['cnt1'];
				$_SESSION["sSilacnt2"] = $aResult['cnt2'];
				$_SESSION["sSilacnt3"] = $aResult['cnt3'];
				$_SESSION["sSilacnt4"] = $aResult['cnt4'];
				
				$_SESSION["sSilacan_com"] = $aResult['can_com'];	
				$_SESSION["sSilacom1"] = $aResult['com1'];
				$_SESSION["sSilacom2"] = $aResult['com2'];
				$_SESSION["sSilacom3"] = $aResult['com3'];
				$_SESSION["sSilacom4"] = $aResult['com4'];
				$_SESSION["sSilacom5"] = $aResult['com5'];
				$_SESSION["sSilacom6"] = $aResult['com6'];		
		
				$_SESSION["sSilacan_una"] = $aResult['can_una'];
				
				$_SESSION["sSilacan_cap"] = $aResult['can_cap'];
				$_SESSION["sSilacan_act"] = $aResult['can_act'];
				
				$_SESSION["sSilaact1"] = $aResult['act1'];
				$_SESSION["sSilaact2"] = $aResult['act2'];
				$_SESSION["sSilaact3"] = $aResult['act3'];
				$_SESSION["sSilaact4"] = $aResult['act4'];
				
				$_SESSION["sSilacont_una"] = 0;
			}
			
			
			
		}
		/*elseif($_POST['rIns_upd'] == 'u')
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
		}*/
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
                    <td><div class="dboton"><a href="" onclick = "si2_getfuncon(document.fData); return false;" class="icontinue" title="Continuar">Continuar</a></div>
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