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
		$tSilacca = "silacca".$_SESSION['sSilaano_aca'];	

		if(!empty($_POST['rHrs_una']) and !empty($_POST['rFch_des']) and !empty($_POST['rFch_al']) and !empty($_POST['rNum_com']) and !empty($_POST['rTit_una']) and !empty($_POST['rCan_cap']) and !empty($_POST['rCan_act']))
		{
			$_SESSION["sSilatit_una"] = $_POST['rTit_una'];
			$_SESSION["sSilahrs_una"] = $_POST['rHrs_una'];
			$_SESSION["sSilafch_des"] = $_POST['rFch_des'];
			$_SESSION["sSilafch_al"] = $_POST['rFch_al'];
			$_SESSION["sSilanum_com"] = $_POST['rNum_com'];
			$_SESSION["sSilacan_cap"] = $_POST['rCan_cap'];
			$_SESSION["sSilacan_act"] = $_POST['rCan_act'];
			
			$vDesde = fFechamy($_POST['rFch_des']);
			$vAl = fFechamy($_POST['rFch_al']);

			
			//--------------------------------------------------------------------
			if($_SESSION["sSilaunaiu"] == 'i')
			{
				
				$vQuery = "insert into $tSilauna (pln_est, cod_cur, sec_gru, mod_mat, cod_car, ano_aca, per_aca, cod_prf, ";
				$vQuery .= "ord_una, tit_una, hrs_una, fch_des, fch_al, num_com, cap_una, can_cap, can_act ) values ";
				$vQuery .= "('{$_SESSION['sSilapln_est']}', '{$_SESSION['sSilacod_cur']}', '{$_SESSION['sSilasec_gru']}', ";
				$vQuery .= "'{$_SESSION['sSilamod_mat']}', '{$_SESSION['sSilacod_car']}', '{$_SESSION['sSilaano_aca']}', ";
				$vQuery .= "'{$_SESSION['sSilaper_aca']}', '{$_SESSION['sUsercod_usu']}', '{$_SESSION['sSilacont_una']}', ";
				$vQuery .= "'{$_SESSION['sSilatit_una']}', '{$_SESSION['sSilahrs_una']}', '$vDesde', ";
				$vQuery .= "'$vAl', '{$_SESSION['sSilanum_com']}', '', '{$_SESSION['sSilacan_cap']}', '{{$_SESSION['sSilacan_act']}}') ";
			
				
				if($cSila = fInupde($vQuery))
				{				
					$bDatos = TRUE;
					$_SESSION["sSilacan_cap2"]-=$_SESSION["sSilacan_cap"];
					$_SESSION["sSilacan_act2"]-=$_SESSION["sSilacan_act"];
				}			
			}
			elseif($_SESSION["sSilaunaiu"] == 'u')
			{
				$vQuery = "update $tSilauna set tit_una = '{$_SESSION['sSilatit_una']}', hrs_una = '{$_SESSION['sSilahrs_una']}', ";
				$vQuery .= "fch_des = '$vDesde',  fch_al = '$vAl', num_com = '{$_SESSION['sSilanum_com']}', ";
				$vQuery .= "can_cap = '{$_SESSION['sSilacan_cap']}', can_act = '{$_SESSION['sSilacan_act']}' ";
				$vQuery .= "where pln_est = '{$_SESSION['sSilapln_est']}' and ";
				$vQuery .= "cod_cur = '{$_SESSION['sSilacod_cur']}' and sec_gru = '{$_SESSION['sSilasec_gru']}' and ";
				$vQuery .= "mod_mat = '{$_SESSION['sSilamod_mat']}' and cod_car = '{$_SESSION['sSilacod_car']}' and ";
				$vQuery .= "ano_aca = '{$_SESSION['sSilaano_aca']}' and per_aca = '{$_SESSION['sSilaper_aca']}' and ";
				$vQuery .= "cod_prf = '{$_SESSION['sUsercod_usu']}' and ord_una = '{$_SESSION['sSilacont_una']}' ";
				
				if($cSila = fInupde($vQuery))
				{				
					$bDatos = TRUE;
					$_SESSION["sSilacan_cap2"]-=$_SESSION["sSilacan_cap"];
					$_SESSION["sSilacan_act2"]-=$_SESSION["sSilacan_act"];
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
		$vQuery = "select can_cca ";
		$vQuery .= "from $tSilauna ";
		$vQuery .= "where pln_est = '{$_SESSION['sSilapln_est']}' and ";
		$vQuery .= "cod_cur = '{$_SESSION['sSilacod_cur']}' and sec_gru = '{$_SESSION['sSilasec_gru']}' and ";
		$vQuery .= "mod_mat = '{$_SESSION['sSilamod_mat']}' and cod_car = '{$_SESSION['sSilacod_car']}' and ";
		$vQuery .= "ano_aca = '{$_SESSION['sSilaano_aca']}' and per_aca = '{$_SESSION['sSilaper_aca']}' and ";
		$vQuery .= "cod_prf = '{$_SESSION['sUsercod_usu']}' and ord_una = '{$_SESSION['sSilacont_una']}' ";
		
		$cResult = fQuery($vQuery);
		if($aResult = mysql_fetch_array($cResult))
		{
			$_SESSION["sSilacan_cca"] = $aResult['can_cca'];
		}
				
?>
<center>
	<form action="sil_savearchivo.php" method="post" enctype="multipart/form-data" name="fData" id="fData">
	
	<table border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="150" height="30" align="left" valign="top"><strong>AYUDA:</strong><br />
	    <br />
	    Ingrese la fundamentaci&oacute;n y los contenidos transversales del silabo. </td>
		<td width="580" align="center">
	
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
        <td align="center">
			<table border="0" cellpadding="0" cellspacing="0" bordercolor="#FF0000" class="tlistdata">
              <tr>
                <th  colspan="3">Cantidad : 
                  <select name="rCan_cca" id="rCan_cca" onchange="si2_getcca(this.value); return false;" >
                    <option value="1" <?=($_SESSION["sSilacan_cca"]=='1'?'Selected':'')?>>1</option>
                    <option value="2" <?=($_SESSION["sSilacan_cca"]=='2'?'Selected':'')?>>2</option>
                    <option value="3" <?=($_SESSION["sSilacan_cca"]=='3'?'Selected':'')?>>3</option>
                    <option value="4" <?=($_SESSION["sSilacan_cca"]=='4'?'Selected':'')?>>4</option>
					<option value="5" <?=($_SESSION["sSilacan_cca"]=='5'?'Selected':'')?>>5</option>
					<option value="6" <?=($_SESSION["sSilacan_cca"]=='6'?'Selected':'')?>>6</option>
					<option value="7" <?=($_SESSION["sSilacan_cca"]=='7'?'Selected':'')?>>7</option>
					<option value="8" <?=($_SESSION["sSilacan_cca"]=='8'?'Selected':'')?>>8</option>
					<option value="9" <?=($_SESSION["sSilacan_cca"]=='9'?'Selected':'')?>>9</option>
					<option value="10" <?=($_SESSION["sSilacan_cca"]=='10'?'Selected':'')?>>10</option>
					<option value="11" <?=($_SESSION["sSilacan_cca"]=='11'?'Selected':'')?>>11</option>
					<option value="12" <?=($_SESSION["sSilacan_cca"]=='12'?'Selected':'')?>>12</option>
					<option value="13" <?=($_SESSION["sSilacan_cca"]=='13'?'Selected':'')?>>13</option>
					<option value="14" <?=($_SESSION["sSilacan_cca"]=='14'?'Selected':'')?>>14</option>
					<option value="15" <?=($_SESSION["sSilacan_cca"]=='15'?'Selected':'')?>>15</option>
					<option value="16" <?=($_SESSION["sSilacan_cca"]=='16'?'Selected':'')?>>16</option>
					<option value="17" <?=($_SESSION["sSilacan_cca"]=='17'?'Selected':'')?>>17</option>
                  </select></th>
              </tr>
              <tr>
                <th  width="15">&nbsp;</th>
                <th  width="440">Contenidos</th>
                <th width="50">Tem(T/H)</th>
              </tr>                          
            </table>
			<div id="dcca">
				<? include "si2_getcca.php"; ?>
			</div>
			<table border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td><div class="dboton"><a href="" onclick = "<?=($_SESSION["sSilacan_una"] == $_SESSION["sSilacont_una"]?"si2_getevalua":"si2_getheaderunax")?>(document.fData); return false;" class="icontinue" title="Aceptar">Continuar</a></div>
					<div class="dboton"><a href="" onclick="<?=($_SESSION["sSilacaiu"]=='i'?"clicksilabo()":"clicksilabo()")?>; return false;" class="icancel" title="Cancelar">Cancelar</a></div></td>
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