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
		$tSilabo = "silabo".$_SESSION['sSilaano_aca'];
		if($_SESSION["sSilacaiu"] == 'i')
		{
			$vQuery = "insert into $tSilabo (pln_est, cod_cur, sec_gru, mod_mat, cod_car, ano_aca, per_aca, cod_prf, can_cap, can_act,  ";
			$vQuery .= "cap1, cap2, cap3, cap4, cap5, cap6, act1, act2, act3, act4, fch_ing ) values ";
			$vQuery .= "('{$_SESSION['sSilapln_est']}', '{$_SESSION['sSilacod_cur']}', '{$_SESSION['sSilasec_gru']}', ";
			$vQuery .= "'{$_SESSION['sSilamod_mat']}', '{$_SESSION['sSilacod_car']}', '{$_SESSION['sSilaano_aca']}', ";
			$vQuery .= "'{$_SESSION['sSilaper_aca']}', '{$_SESSION['sUsercod_usu']}', '{$_SESSION['sSilacan_cap2']}', '{$_SESSION['sSilacan_act2']}', ";
			$vQuery .= "'{$_POST['rCap1']}', '{$_POST['rCap2']}', '{$_POST['rCap3']}', '{$_POST['rCap4']}', '{$_POST['rCap5']}', ";
			$vQuery .= "'{$_POST['rCap6']}', '{$_POST['rAct1']}', '{$_POST['rAct2']}', '{$_POST['rAct3']}', '{$_POST['rAct4']}', ";
			$vQuery .= "now() ) ";

			$cResult = fInupde2($vQuery);
			$bDatos = TRUE;
		}
		elseif($_SESSION["sSilacaiu"] == 'u')
		{
			$vQuery = "update $tSilabo set can_cap = '{$_SESSION['sSilacan_cap2']}', can_act = '{$_SESSION['sSilacan_act2']}', ";
			$vQuery .= "cap1 = '{$_POST['rCap1']}', cap2 = '{$_POST['rCap2']}', cap3 = '{$_POST['rCap3']}', ";
			$vQuery .= "cap4 = '{$_POST['rCap4']}', cap5 = '{$_POST['rCap5']}', cap6 = '{$_POST['rCap6']}', ";
			$vQuery .= "act1 = '{$_POST['rAct1']}', act2 = '{$_POST['rAct2']}', act3 = '{$_POST['rAct3']}', ";
			$vQuery .= "act4 = '{$_POST['rAct4']}' ";
			$vQuery .= "where pln_est = '{$_SESSION['sSilapln_est']}' and cod_cur = '{$_SESSION['sSilacod_cur']}' and ";
			$vQuery .= "sec_gru = '{$_SESSION['sSilasec_gru']}' and mod_mat = '{$_SESSION['sSilamod_mat']}' and ";
			$vQuery .= "cod_car = '{$_SESSION['sSilacod_car']}' and ano_aca = '{$_SESSION['sSilaano_aca']}' and ";
			$vQuery .= "per_aca = '{$_SESSION['sSilaper_aca']}' ";
			
			$cResult = fInupde2($vQuery);
			$bDatos = TRUE;
		}
		else
		{
			header("Location:../index.php");
		}
	}
	else
	{
		header("Location:../index.php");
	}
	if($bDatos == TRUE)
	{
		$_SESSION["sSilacan_cap"] = $_SESSION["sSilacan_cap2"];
		$_SESSION["sSilacan_act"] = $_SESSION["sSilacan_act2"];
		$_SESSION['sSilaupload'] = FALSE;
?>
		<span class="wordi">HAGA CLICK EN &quot; Examinar... &quot; PARA ESPECIFICAR LA UBICACI&Oacute;N F&Iacute;SICA <br />
		DEL ARCHIVO DEL SILABO.</span>
		<table border="0" cellpadding="0" cellspacing="0" bordercolor="#FF0000" class="tlistdata">
          <tr>
            <th width="520">Archivo del Silabo en formato DOC </th>
          </tr>
          <tr>
            <td class="tdultimo">Archivo : <input name="rArchivo" type="file" id="rArchivo" size="50"></td>
          </tr>
        </table>
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td><div class="dboton"><a href="" onclick = "document.fData.submit(); return false;" class="isave" title="Enviar">Enviar</a></div>
				<div class="dboton"><a href="" onClick="<?=($_SESSION["sSilacaiu"]=='i'?"clicksilabo()":"clicksilabo()")?>; return false;" class="icancel" title="Cancelar">Cancelar</a></div></td>
		  </tr>
		</table>	
<?
	}
?>