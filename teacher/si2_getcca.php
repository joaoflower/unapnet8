<STYLE type=text/css>
@import url( ../css/main.css );
@import url( ../css/frame.css );
@import url( ../css/framelogin.css );
@import url( ../css/style.css );
</STYLE>

<?
	
	$vCan_cca = 1;
	$aResult = "";
	
	if(!empty($_POST['rCan_cca']))
	{	
		session_start();
		include "../include/funcget.php";
		include "../include/funcsql.php";
		include "../include/funcstyle.php";
		$_SESSION["sSilacan_cca"] = $_POST['rCan_cca'];
	}
	if($_SESSION["sSilacan_cca"] == 0)
		$_SESSION["sSilacan_cca"] = 1;
	
	if(fsafetylogin())
	{
		$tSilacca = "silacca".$_SESSION['sSilaano_aca'];
		
		
		$vQuery = "select ord_cca, con_cca, tem_cca "; //cap_cca, con_cca, act_cca, tem_cca  ";
		$vQuery .= "from $tSilacca ";
		$vQuery .= "where pln_est = '{$_SESSION['sSilapln_est']}' and ";
		$vQuery .= "cod_cur = '{$_SESSION['sSilacod_cur']}' and sec_gru = '{$_SESSION['sSilasec_gru']}' and ";
		$vQuery .= "mod_mat = '{$_SESSION['sSilamod_mat']}' and cod_car = '{$_SESSION['sSilacod_car']}' and ";
		$vQuery .= "ano_aca = '{$_SESSION['sSilaano_aca']}' and per_aca = '{$_SESSION['sSilaper_aca']}' and ";
		$vQuery .= "cod_prf = '{$_SESSION['sUsercod_usu']}' and ord_una = '{$_SESSION['sSilacont_una']}' ";
		
		$cResult = fQuery($vQuery);
		while($aResult = mysql_fetch_array($cResult))
		{
			//$sCca[$aResult['ord_cca']]['cap_cca'] = $aResult['cap_cca'];
			$sCca[$aResult['ord_cca']]['con_cca'] = $aResult['con_cca'];
			//$sCca[$aResult['ord_cca']]['act_cca'] = $aResult['act_cca'];
			$sCca[$aResult['ord_cca']]['tem_cca'] = $aResult['tem_cca'];
		}
		
?>
		<table border="0" cellpadding="0" cellspacing="0" bordercolor="#FF0000" class="tlistdata">         
          <?
		  	for($ii = 1; $ii <= $_SESSION["sSilacan_cca"]; $ii++)
			{
		  ?>
		  	<tr>
		  	  <td width="15"  class="tdultimo"><?=$ii?></td>
                <td width="440"  class="tdultimo"><textarea name="rCon<?=$ii?>" cols="80" rows="3" id="rCon<?=$ii?>"  onblur="fupper(this);"><?=$sCca[$ii]['con_cca']?></textarea></td>
                <td width="50"  class="tdultimo"><input name="rTem<?=$ii?>" type="text" class="" id="rTem<?=$ii?>" value="<?=$sCca[$ii]['tem_cca']?>" size="3" maxlength="3" onblur="fupper(this);"/></td>
              </tr> 
          <?
		  	}
		  ?>
        </table>
		<?	
	}
?>