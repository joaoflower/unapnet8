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
		if(!empty($_POST['rCan_cap']) and !empty($_POST['rCan_act']))
		{
			if($_SESSION["sActacaiu"] == 'u')
			{
				$tIngnota = "ingnota".$_SESSION['sFrameano_aca'];
				
				$vQuery = "select cap1, cap2, cap3, cap4, cap5, cap6, act1, act2, act3, act4 ";
				$vQuery .= "from $tIngnota ";
				$vQuery .= "where pln_est = '{$_SESSION['sActapln_est']}' and cod_cur = '{$_SESSION['sActacod_cur']}' and ";
				$vQuery .= "sec_gru = '{$_SESSION['sActasec_gru']}' and mod_mat = '{$_SESSION['sActamod_mat']}' and ";
				$vQuery .= "cod_car = '{$_SESSION['sActacod_car']}' and ano_aca = '{$_SESSION['sFrameano_aca']}' and ";
				$vQuery .= "per_aca = '{$_SESSION['sFrameper_aca']}' ";
				
				$cResult = fQuery2($vQuery);
				if($aResult = mysql_fetch_array($cResult))
				{
					$bDatos = TRUE;
				}
			}
			elseif($_SESSION["sActacaiu"] == 'i')
			{
				/*$tSilabo = "silabo".$_SESSION['sFrameano_aca'];	
				
				$vQuery = "select cap1, cap2, cap3, cap4, cap5, cap6, act1, act2, act3, act4 ";
				$vQuery .= "from $tSilabo ";
				$vQuery .= "where pln_est = '{$_SESSION['sActapln_est']}' and cod_cur = '{$_SESSION['sActacod_cur']}' and ";
				$vQuery .= "sec_gru = '{$_SESSION['sActasec_gru']}' and mod_mat = '{$_SESSION['sActamod_mat']}' and ";
				$vQuery .= "cod_car = '{$_SESSION['sActacod_car']}' and ano_aca = '{$_SESSION['sFrameano_aca']}' and ";
				$vQuery .= "per_aca = '{$_SESSION['sFrameper_aca']}' ";
				
				$cResult = fQuery2($vQuery);
				if($aResult = mysql_fetch_array($cResult))
				{
					$bDatos = TRUE;
				}
				$bDatos = TRUE;*/
				
				$tSilauna = "silauna".$_SESSION['sFrameano_aca'];	
				
				$vQuery = "select ord_una, cap_una, act_una ";
				$vQuery .= "from $tSilauna ";
				$vQuery .= "where pln_est = '{$_SESSION['sActapln_est']}' and cod_cur = '{$_SESSION['sActacod_cur']}' and ";
				$vQuery .= "sec_gru = '{$_SESSION['sActasec_gru']}' and mod_mat = '{$_SESSION['sActamod_mat']}' and ";
				$vQuery .= "cod_car = '{$_SESSION['sActacod_car']}' and ano_aca = '{$_SESSION['sFrameano_aca']}' and ";
				$vQuery .= "per_aca = '{$_SESSION['sFrameper_aca']}' and cod_prf = '{$_SESSION['sUsercod_usu']}' ";
				
				$cResult = fQuery2($vQuery);
				while($aResult2 = mysql_fetch_array($cResult))
				{
					$aResult['cap'.$aResult2['ord_una']] = $aResult2['cap_una'];
					$aResult['act'.$aResult2['ord_una']] = $aResult2['act_una'];
					$bDatos = TRUE;
				}
				$bDatos = TRUE;
			}
		}
	}
	else
	{
		header("Location:../index.php");
	}
	if($bDatos == TRUE)
	{
		$_SESSION["sActacan_cap2"] = $_POST['rCan_cap'];
		$_SESSION["sActacan_act2"] = $_POST['rCan_act'];
		
?>
		<span class="wordi">INGRESAR LA DESCRIPCIÓN DE LAS CAPACIDADES <br />
			Y ACTITUDES DEL CURSO</span>
		<table border="0" cellpadding="0" cellspacing="0" bordercolor="#FF0000" class="tlistdata">
          <tr>
            <th colspan="2">Capacidades : </th>
          </tr>
		  <?
		  	for($ii = 1; $ii <= $_POST['rCan_cap']; $ii++)
			{
		  ?>
          <tr>
            <td width="20" class="tdultimo"><?=$ii?></td>
            <td width="500" class="tdultimo"><textarea name="rCap<?=$ii?>" cols="95" rows="2" id="rCap<?=$ii?>"  onblur="fupper(this);"><?=$aResult['cap'.$ii]?></textarea></td>
          </tr>
		  <?
		  	}
		  ?>
          <tr>
            <th colspan="2">Actitudes : </th>
          </tr>
          <?
		  	for($ii = 1; $ii <= $_POST['rCan_act']; $ii++)
			{
		  ?>
          <tr>
            <td class="tdultimo"><?=$ii?></td>
            <td class="tdultimo"><textarea name="rAct<?=$ii?>" cols="60" rows="2" id="rAct<?=$ii?>"  onblur="fupper(this);"><?=$aResult['act'.$ii]?></textarea></td>
          </tr>
		  <?
		  	}
		  ?>
        </table>
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td><div class="dboton"><a href="" onclick = "act_saveca(document.fData); return false;" class="icontinue" title="Aceptar">Continuar</a></div>
				<div class="dboton"><a href="" onClick="<?=($_SESSION["sActacaiu"]=='i'?"clickacta()":"act_cancelnota()")?>; return false;" class="icancel" title="Cancelar">Cancelar</a></div></td>
		  </tr>
		</table>	
<?
	}
?>

