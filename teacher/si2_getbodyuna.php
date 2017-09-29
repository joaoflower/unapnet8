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
		$tSilauna = "silauna".$_SESSION['sSilaano_aca'];	

		if(!empty($_POST['rHrs_una']) and !empty($_POST['rFch_des']) and !empty($_POST['rFch_al']) and !empty($_POST['rNum_com']) and !empty($_POST['rTit_una']) and !empty($_POST['rCap_una']))
		{
			$_SESSION["sSilatit_una"] = $_POST['rTit_una'];
			$_SESSION["sSilahrs_una"] = $_POST['rHrs_una'];
			$_SESSION["sSilafch_des"] = $_POST['rFch_des'];
			$_SESSION["sSilafch_al"] = $_POST['rFch_al'];
			$_SESSION["sSilanum_com"] = $_POST['rNum_com'];
			$_SESSION["sSilacap_una"] = $_POST['rCap_una'];
			
			$vDesde = fFechamy($_POST['rFch_des']);
			$vAl = fFechamy($_POST['rFch_al']);

			
			//--------------------------------------------------------------------
			if($_SESSION["sSilaunaiu"] == 'i')
			{
				
				$vQuery = "insert into $tSilauna (pln_est, cod_cur, sec_gru, mod_mat, cod_car, ano_aca, per_aca, cod_prf, ";
				$vQuery .= "ord_una, tit_una, hrs_una, fch_des, fch_al, num_com, cap_una) values ";
				$vQuery .= "('{$_SESSION['sSilapln_est']}', '{$_SESSION['sSilacod_cur']}', '{$_SESSION['sSilasec_gru']}', ";
				$vQuery .= "'{$_SESSION['sSilamod_mat']}', '{$_SESSION['sSilacod_car']}', '{$_SESSION['sSilaano_aca']}', ";
				$vQuery .= "'{$_SESSION['sSilaper_aca']}', '{$_SESSION['sUsercod_usu']}', '{$_SESSION['sSilacont_una']}', ";
				$vQuery .= "'{$_SESSION['sSilatit_una']}', '{$_SESSION['sSilahrs_una']}', '$vDesde', ";
				$vQuery .= "'$vAl', '{$_SESSION['sSilanum_com']}', '{$_SESSION['sSilacap_una']}') ";
			
				
				if($cSila = fInupde($vQuery))
				{				
					$bDatos = TRUE;
				}			
			}
			elseif($_SESSION["sSilaunaiu"] == 'u')
			{
				$vQuery = "update $tSilauna set tit_una = '{$_SESSION['sSilatit_una']}', hrs_una = '{$_SESSION['sSilahrs_una']}', ";
				$vQuery .= "fch_des = '$vDesde',  fch_al = '$vAl', ";
				$vQuery .= "num_com = '{$_SESSION['sSilanum_com']}', cap_una = '{$_SESSION['sSilacap_una']}' ";
				$vQuery .= "where pln_est = '{$_SESSION['sSilapln_est']}' and ";
				$vQuery .= "cod_cur = '{$_SESSION['sSilacod_cur']}' and sec_gru = '{$_SESSION['sSilasec_gru']}' and ";
				$vQuery .= "mod_mat = '{$_SESSION['sSilamod_mat']}' and cod_car = '{$_SESSION['sSilacod_car']}' and ";
				$vQuery .= "ano_aca = '{$_SESSION['sSilaano_aca']}' and per_aca = '{$_SESSION['sSilaper_aca']}' and ";
				$vQuery .= "cod_prf = '{$_SESSION['sUsercod_usu']}' and ord_una = '{$_SESSION['sSilacont_una']}' ";
				
				if($cSila = fInupde($vQuery))
				{				
					$bDatos = TRUE;
				}
			}
			//-----------------------------------------------
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
	<form action="sil_savearchivo.php" method="post" enctype="multipart/form-data" name="fData" id="fData">
	
	<table border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="150" height="30" align="left" valign="top"><strong>AYUDA:</strong><br />
	    <br />
	    Ingrese la fundamentaci&oacute;n y los contenidos transversales del silabo. </td>
		<td width="580" align="center">
		
		<!-- -->
		<table border="0" cellpadding="0" cellspacing="0" class="tventana">
      <tr>
        <td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
        <th background="../images/ven_topcenter.jpg">Curso:
          <?=$_SESSION['sSilanom_cur']?></th>
        <td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
      </tr>
      <tr>
        <td background="../images/ven_mediumleft.jpg"></td>
        <td align="center"><table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
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
        </table></td>
        <td background="../images/ven_mediumright.jpg"></td>
      </tr>
      <tr>
        <td><img src="../images/ven_bottomleft.jpg" width="16" height="16" border="0" alt="" /></td>
        <td background="../images/ven_bottomcenter.jpg"></td>
        <td><img src="../images/ven_bottomright.jpg" width="16" height="16" border="0" alt="" /></td>
      </tr>
    </table>
	<strong>IV. PROGRAMACI&Oacute;N DE LA UNIDAD </strong>
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
      <tr>
        <td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
        <th background="../images/ven_topcenter.jpg">Unidad Program&aacute;tica <?=$_SESSION["sSilacont_una"]?></th>
        <td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
      </tr>
      <tr>
        <td background="../images/ven_mediumleft.jpg"></td>
        <td align="center"><table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
          <tr>
            <td width="100">Procedimental : </td>
            <th width="415"><textarea name="rPro_unp" cols="75" rows="3" id="rPro_unp"  onblur="fupper(this);"><?=$_SESSION['sSilapro_unp']?></textarea></th>
          </tr>
          <tr>
            <td>Conceptual : </td>
            <th><textarea name="rCon_unp" cols="75" rows="6" id="rCon_unp"  onblur="fupper(this);"><?=$_SESSION['sSilacon_unp']?></textarea></th>
          </tr>
          <tr>
            <td>Indic. de Logro : </td>
            <th><textarea name="rInd_log" cols="75" rows="3" id="rInd_log"  onblur="fupper(this);"><?=$_SESSION['sSilaind_log']?></textarea></th>
          </tr>
          <tr>
            <td>Actitudes : </td>
            <th><textarea name="rAct_una" cols="75" rows="2" id="rAct_una"  onblur="fupper(this);"><?=$_SESSION['sSilaact_una']?></textarea></th>
          </tr>
          <tr>
            <td>Indic. Actitudes : </td>
            <th><textarea name="rInd_act" cols="75" rows="3" id="rInd_act"  onblur="fupper(this);"><?=$_SESSION['sSilaind_act']?></textarea></th>
          </tr>
        </table>
		
		<table border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td><div class="dboton"><a href="" onclick = "<?=($_SESSION["sSilacan_una"] == $_SESSION["sSilacont_una"]?"si2_getevalua":"si2_getheaderunax")?>(document.fData); return false;" class="icontinue" title="Aceptar">Continuar</a></div>
					<div class="dboton"><a href="" onClick="<?=($_SESSION["sSilacaiu"]=='i'?"clicksilabo()":"clicksilabo()")?>; return false;" class="icancel" title="Cancelar">Cancelar</a></div></td>
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
	<!-- -->
        </td>
	  </tr>
	</table>

	
  </form>	
</center>
<?
	}
?>