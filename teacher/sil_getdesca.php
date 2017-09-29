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
			if($_SESSION["sSilacaiu"] == 'u')
			{
				$tSilabo = "silabo".$_SESSION['sSilaano_aca'];
				
				$vQuery = "select cap1, cap2, cap3, cap4, cap5, cap6, act1, act2, act3, act4 ";
				$vQuery .= "from $tSilabo ";
				$vQuery .= "where pln_est = '{$_SESSION['sSilapln_est']}' and cod_cur = '{$_SESSION['sSilacod_cur']}' and ";
				$vQuery .= "sec_gru = '{$_SESSION['sSilasec_gru']}' and mod_mat = '{$_SESSION['sSilamod_mat']}' and ";
				$vQuery .= "cod_car = '{$_SESSION['sSilacod_car']}' and ano_aca = '{$_SESSION['sSilaano_aca']}' and ";
				$vQuery .= "per_aca = '{$_SESSION['sSilaper_aca']}' ";
				
				$cResult = fQuery2($vQuery);
				if($aResult = mysql_fetch_array($cResult))
				{
					$bDatos = TRUE;
				}
			}
			elseif($_SESSION["sSilacaiu"] == 'i')
			{
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
		$_SESSION["sSilacan_cap2"] = $_POST['rCan_cap'];
		$_SESSION["sSilacan_act2"] = $_POST['rCan_act'];
		
?>
		<span class="wordi"> INGRESE LA DESCRIPCIÓN DE LAS CAPACIDADES <br />
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
			<td><div class="dboton"><a href="" onclick = "sil_savesilabo(document.fData); return false;" class="icontinue" title="Aceptar">Continuar</a></div>
				<div class="dboton"><a href="" onClick="<?=($_SESSION["sSilacaiu"]=='i'?"clicksilabo()":"clicksilabo()")?>; return false;" class="icancel" title="Cancelar">Cancelar</a></div></td>
		  </tr>
		</table>	
<?
	}
?>

