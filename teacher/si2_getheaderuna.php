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
		
		//-----------------------------------------------------
		$_SESSION["sSilatit_una"] = "";
		$_SESSION["sSilahrs_una"] = "";
		$_SESSION["sSilafch_des"] = "";
		$_SESSION["sSilafch_al"] = "";
		$_SESSION["sSilanum_com"] = "";
		$_SESSION["sSilacap_una"] = "";
		$_SESSION["sSilapro_unp"] = "";
		$_SESSION["sSilacon_unp"] = "";
		$_SESSION["sSilaind_log"] = "";
		$_SESSION["sSilaact_una"] = "";
		$_SESSION["sSilaind_act"] = "";			
		//-----------------------------------------------------	
						
		if(!empty($_POST['rCan_una']) and !empty($_POST['rCom1']))
		{
			$_SESSION["sSilacan_una"] = $_POST['rCan_una'];
			$_SESSION["sSilacom1"] = $_POST['rCom1'];
			$_SESSION["sSilacom2"] = $_POST['rCom2'];
			$_SESSION["sSilacom3"] = $_POST['rCom3'];
			$_SESSION["sSilacom4"] = $_POST['rCom4'];
			$_SESSION["sSilacom5"] = $_POST['rCom5'];
			$_SESSION["sSilacom6"] = $_POST['rCom6'];

			$_SESSION["sSilacont_una"] = 1;			
			
			$vQuery = "update $tSilaok set can_una = '{$_SESSION['sSilacan_una']}', can_com = '{$_SESSION['sSilacan_com']}', ";
			$vQuery .= "com1 = '{$_SESSION['sSilacom1']}', com2 = '{$_SESSION['sSilacom2']}', com3 = '{$_SESSION['sSilacom3']}', ";
			$vQuery .= "com4 = '{$_SESSION['sSilacom4']}', com5 = '{$_SESSION['sSilacom5']}', com6 = '{$_SESSION['sSilacom6']}' ";
			$vQuery .= "where pln_est = '{$_SESSION['sSilapln_est']}' and ";
			$vQuery .= "cod_cur = '{$_SESSION['sSilacod_cur']}' and sec_gru = '{$_SESSION['sSilasec_gru']}' and ";
			$vQuery .= "mod_mat = '{$_SESSION['sSilamod_mat']}' and  cod_car = '{$_SESSION['sSilacod_car']}' and ";
			$vQuery .= "ano_aca = '{$_SESSION['sSilaano_aca']}' and per_aca = '{$_SESSION['sSilaper_aca']}' and ";
			$vQuery .= "cod_prf = '{$_SESSION['sUsercod_usu']}' ";
			
			if($cSila = fInupde($vQuery))
			{				
				$bDatos = TRUE;				
			}		
		}	
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
			
			

//			$bDatos = TRUE;
			$_SESSION["sSilacont_una"]++;
		}
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{		
		$_SESSION["sSilaunaiu"] = 'i';
				
		$vQuery = "select tit_una, hrs_una, fch_des, fch_al, num_com, cap_una, pro_unp, con_unp, ind_log, act_una, ind_act, can_cca, can_cap, can_act ";
		$vQuery .= "from $tSilauna ";
		$vQuery .= "where pln_est = '{$_SESSION['sSilapln_est']}' and ";
		$vQuery .= "cod_cur = '{$_SESSION['sSilacod_cur']}' and sec_gru = '{$_SESSION['sSilasec_gru']}' and ";
		$vQuery .= "mod_mat = '{$_SESSION['sSilamod_mat']}' and cod_car = '{$_SESSION['sSilacod_car']}' and ";
		$vQuery .= "ano_aca = '{$_SESSION['sSilaano_aca']}' and per_aca = '{$_SESSION['sSilaper_aca']}' and ";
		$vQuery .= "cod_prf = '{$_SESSION['sUsercod_usu']}' and ord_una = '{$_SESSION['sSilacont_una']}' ";
		
		$cResult = fQuery($vQuery);
		if($aResult = mysql_fetch_array($cResult))
		{
			$_SESSION["sSilaunaiu"] = 'u';
			$_SESSION["sSilatit_una"] = $aResult['tit_una'];
			$_SESSION["sSilahrs_una"] = $aResult['hrs_una'];
			$_SESSION["sSilafch_des"] = $aResult['fch_des'];
			$_SESSION["sSilafch_al"] = $aResult['fch_al'];
			$_SESSION["sSilanum_com"] = $aResult['num_com'];
			$_SESSION["sSilacap_una"] = $aResult['cap_una'];
			$_SESSION["sSilapro_unp"] = $aResult['pro_unp'];
			$_SESSION["sSilacon_unp"] = $aResult['con_unp'];
			$_SESSION["sSilaind_log"] = $aResult['ind_log'];
			$_SESSION["sSilaact_una"] = $aResult['act_una'];
			$_SESSION["sSilaind_act"] = $aResult['ind_act'];
			$_SESSION["sSilacan_cca"] = $aResult['can_cca'];
			$_SESSION["sSilacan_cap"] = $aResult['can_cap'];
			$_SESSION["sSilacan_act"] = $aResult['can_act'];
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
            <td width="100">T&iacute;tulo : </td>
            <th width="415"><textarea name="rTit_una" cols="75" rows="2" id="rTit_una"  onblur="fupper(this);"><?=$_SESSION["sSilatit_una"]?></textarea></th>
          </tr>
          <tr>
            <td>Total de horas : </td>
            <th><input name="rHrs_una" type="text" class="" id="rHrs_una" value="<?=$_SESSION["sSilahrs_una"]?>" size="3" maxlength="3" onblur="fupper(this);"/> 
              Horas </th>
          </tr>
          <tr>
            <td>Tiempo de desarr. : </td>
            <th>Del : 
              <input name="rFch_des" type="text" class="" id="rFch_des" value="<?=fFechad($_SESSION["sSilafch_des"])?>" size="10" maxlength="10" onblur="fupper(this);"/><img src="../images/browse.png" width="16" height="16" onclick="return showCalendar('rFch_des', '%d/%m/%Y');" />
              al 
              <input name="rFch_al" type="text" class="" id="rFch_al" value="<?=fFechad($_SESSION["sSilafch_al"])?>" size="10" maxlength="10" onblur="fupper(this);"/><img src="../images/browse.png" width="16" height="16" onclick="return showCalendar('rFch_al', '%d/%m/%Y');" /> <span class="wordi">(dd/mm/aaaa)</span></th>
          </tr>
          <tr>
            <td>Competencia : </td>
            <th><select name="rNum_com" id="rNum_com">
              <?=fviewcompeuna($_SESSION["sSilanum_com"])?>
            </select></th>
          </tr>
          <tr>
            <td>Cantidad Cap.  : </td>
            <th><select name="rCan_cap" id="rCan_cap" >
			<?
				for($ii = 1; $ii <= $_SESSION["sSilacan_cap2"]; $ii++)
				{
			?>
              <option value="<?=$ii?>" <?=($_SESSION["sSilacan_cap"]==$ii?'Selected':'')?>><?=$ii?></option>              
			 <?
			 	}
			?>
            </select></th>
          </tr>
          <tr>
            <td>Cantidad Act. : </td>
            <th><select name="rCan_act" id="rCan_act" >
             <?
				for($ii = 1; $ii <= $_SESSION["sSilacan_act2"]; $ii++)
				{
			?>
              <option value="<?=$ii?>" <?=($_SESSION["sSilacan_act"]==$ii?'Selected':'')?>><?=$ii?></option>              
			 <?
			 	}
			?>
            </select></th>
          </tr>
        </table>
		
		<table border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td><div class="dboton"><a href="" onclick = "si2_getbodyuna(document.fData); return false;" class="icontinue" title="Continuar">Continuar</a></div>
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