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
		$_SESSION["sSilaiut_eva"] = 'i';
		$_SESSION["sSilatip_eva"] = '';
		$tSilaok = "silaok".$_SESSION['sSilaano_aca'];	
		$tSilauna = "silauna".$_SESSION['sSilaano_aca'];	
		$tSilacca = "silacca".$_SESSION['sSilaano_aca'];

		if(!empty($_POST['rCan_cca']) and !empty($_POST['rCon1']) and !empty($_POST['rTem1']))
		{
			//--------------------
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
				$vCan_cca = $aResult['can_cca'];
			}
			//------------------------
			
			$ii = 1;
			for($ii = 1; $ii <= $_POST['rCan_cca']; $ii++)
			{
				//$rCap_cca = $_POST['rCap'.$ii];
				$rCon_cca = $_POST['rCon'.$ii];
				//$rAct_cca = $_POST['rAct'.$ii];
				$rTem_cca = $_POST['rTem'.$ii];
				if($ii <= $vCan_cca)
				{
					
					$vQuery = "update $tSilacca set con_cca = '$rCon_cca', tem_cca = '$rTem_cca' ";
					$vQuery .= "where pln_est = '{$_SESSION['sSilapln_est']}' and ";
					$vQuery .= "cod_cur = '{$_SESSION['sSilacod_cur']}' and sec_gru = '{$_SESSION['sSilasec_gru']}' and ";
					$vQuery .= "mod_mat = '{$_SESSION['sSilamod_mat']}' and cod_car = '{$_SESSION['sSilacod_car']}' and ";
					$vQuery .= "ano_aca = '{$_SESSION['sSilaano_aca']}' and per_aca = '{$_SESSION['sSilaper_aca']}' and ";
					$vQuery .= "cod_prf = '{$_SESSION['sUsercod_usu']}' and ord_una = '{$_SESSION['sSilacont_una']}' and ";
					$vQuery .= "ord_cca = '$ii' ";
				}
				else
				{
					$vQuery = "insert into $tSilacca (pln_est, cod_cur, sec_gru, mod_mat, cod_car, ano_aca, per_aca, cod_prf, ";
					$vQuery .= "ord_una, ord_cca, cap_cca, con_cca, act_cca, tem_cca) values ";
					$vQuery .= "('{$_SESSION['sSilapln_est']}', '{$_SESSION['sSilacod_cur']}', '{$_SESSION['sSilasec_gru']}', ";
					$vQuery .= "'{$_SESSION['sSilamod_mat']}', '{$_SESSION['sSilacod_car']}', '{$_SESSION['sSilaano_aca']}', ";
					$vQuery .= "'{$_SESSION['sSilaper_aca']}', '{$_SESSION['sUsercod_usu']}', '{$_SESSION['sSilacont_una']}', ";
					$vQuery .= "'$ii', '', '$rCon_cca', '', '$rTem_cca') ";
				}
				if($cSila = fInupde($vQuery))
				{				
					$bDatos = TRUE;				
				}				
			}
			//--------------------
			$vQuery = "update $tSilauna set can_cca = '{$_POST['rCan_cca']}' ";
			$vQuery .= "where pln_est = '{$_SESSION['sSilapln_est']}' and ";
			$vQuery .= "cod_cur = '{$_SESSION['sSilacod_cur']}' and sec_gru = '{$_SESSION['sSilasec_gru']}' and ";
			$vQuery .= "mod_mat = '{$_SESSION['sSilamod_mat']}' and cod_car = '{$_SESSION['sSilacod_car']}' and ";
			$vQuery .= "ano_aca = '{$_SESSION['sSilaano_aca']}' and per_aca = '{$_SESSION['sSilaper_aca']}' and ";
			$vQuery .= "cod_prf = '{$_SESSION['sUsercod_usu']}' and ord_una = '{$_SESSION['sSilacont_una']}' ";
			
			if($cSila = fInupde($vQuery))
			{				
				$bDatos = TRUE;				
			}			
			
			//------------------------
			
/*			$vQuery = "update $tSilauna set pro_unp = '{$_POST['rPro_unp']}', con_unp = '{$_POST['rCon_unp']}', ";
			$vQuery .= "ind_log = '{$_POST['rInd_log']}', act_una = '{$_POST['rAct_una']}', ";
			$vQuery .= "ind_act = '{$_POST['rInd_act']}' ";
			$vQuery .= "where pln_est = '{$_SESSION['sSilapln_est']}' and ";
			$vQuery .= "cod_cur = '{$_SESSION['sSilacod_cur']}' and sec_gru = '{$_SESSION['sSilasec_gru']}' and ";
			$vQuery .= "mod_mat = '{$_SESSION['sSilamod_mat']}' and cod_car = '{$_SESSION['sSilacod_car']}' and ";
			$vQuery .= "ano_aca = '{$_SESSION['sSilaano_aca']}' and per_aca = '{$_SESSION['sSilaper_aca']}' and ";
			$vQuery .= "cod_prf = '{$_SESSION['sUsercod_usu']}' and ord_una = '{$_SESSION['sSilacont_una']}' ";*/

		}
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{		
		$_SESSION["sSilacan_cap2"] = 6 - $_SESSION["sSilacan_cap2"];
		$_SESSION["sSilacan_act2"] = 4 - $_SESSION["sSilacan_act2"];
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
	<strong>V. EVALUACI&Oacute;NES </strong>
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
      <tr>
        <td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
        <th background="../images/ven_topcenter.jpg">Nueva Evaluaci&oacute;n </th>
        <td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
      </tr>
      <tr>
        <td background="../images/ven_mediumleft.jpg"></td>
        <td align="center">
        	<div id="devaluatipo">
				<? include "si2_getevaluatipodata.php";?>
			</div>
        	
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
        <th background="../images/ven_topcenter.jpg">Lista de Evaluaciones </th>
        <td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
      </tr>
      <tr>
        <td background="../images/ven_mediumleft.jpg"></td>
        <td align="center">
				<div id="devalua">
					<? include "si2_getevaluadata.php"; ?>
				</div>
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