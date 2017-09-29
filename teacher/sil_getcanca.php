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
						
		if($_POST['rIns_upd'] == 'i')
		{
			if(!empty($_POST['rCod_cur']) and !empty($_POST['rSec_gru']))
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
					$bDatos = TRUE;
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
?>
<center>
	<form action="sil_savearchivo.php" method="post" enctype="multipart/form-data" name="fData" id="fData">
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Curso: <?=$aResult['nom_cur']?></th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
			  <tr>
			    <td>Menci&oacute;n : </td>
			    <th colspan="3"><?=$aResult['esp_nom']?></th>
		      </tr>
			  <tr>
			    <td width="75">Semestre :</td>
			    <th width="150"><?=$aResult['sem_des']?></th>
			    <td width="75">Grupo :</td>
			    <th width="150"><?=$aResult['sec_des']?></th>
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
		<th background="../images/ven_topcenter.jpg">Ingreso de nuevo silabo </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center"><div id="dsilabo">
			<span class="wordi">SELECCIONE LA CANTIDAD DE <br />
			CAPACIDADES Y ACTITUDES <br />
			DEL CURSO</span>
			<table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
			  <tr>
				<td width="75">Capacidades : </td>
				<th width="75"><select name="rCan_cap" id="rCan_cap">
				  <option value="1" <?=($_SESSION["sSilacan_cap"]=='1'?'Selected':'')?>>1</option>
				  <option value="2" <?=($_SESSION["sSilacan_cap"]=='2'?'Selected':'')?>>2</option>
				  <option value="3" <?=($_SESSION["sSilacan_cap"]=='3'?'Selected':'')?>>3</option>
				  <option value="4" <?=($_SESSION["sSilacan_cap"]=='4'?'Selected':'')?>>4</option>
				  <option value="5" <?=($_SESSION["sSilacan_cap"]=='5'?'Selected':'')?>>5</option>
				  <option value="6" <?=($_SESSION["sSilacan_cap"]=='6'?'Selected':'')?>>6</option>
				</select></th>
			  </tr>
			  <tr>
				<td>Actitudes : </td>
				<th><select name="rCan_act" id="rCan_act">
				  <option value="1" <?=($_SESSION["sSilacan_act"]=='1'?'Selected':'')?>>1</option>
				  <option value="2" <?=($_SESSION["sSilacan_act"]=='2'?'Selected':'')?>>2</option>
				  <option value="3" <?=($_SESSION["sSilacan_act"]=='3'?'Selected':'')?>>3</option>
				  <option value="4" <?=($_SESSION["sSilacan_act"]=='4'?'Selected':'')?>>4</option>
				</select></th>
			  </tr>
			</table>
			<table border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td><div class="dboton"><a href="" onclick = "sil_getdesca(document.fData); return false;" class="icontinue" title="Aceptar">Continuar</a></div>
					<div class="dboton"><a href="" onClick="<?=($_SESSION["sSilacaiu"]=='i'?"clicksilabo()":"clicksilabo()")?>; return false;" class="icancel" title="Cancelar">Cancelar</a></div></td>
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