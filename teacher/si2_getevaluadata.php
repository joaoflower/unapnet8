<STYLE type=text/css>
@import url( ../css/main.css );
@import url( ../css/frame.css );
@import url( ../css/framelogin.css );
@import url( ../css/style.css );
</STYLE>

<?	
	$aResult = "";
	$vPorcen = 0;
	
	if(!empty($_POST['rUni_pro']) and !empty($_POST['rTip_eva']) and !empty($_POST['rDes_eva']) and !empty($_POST['rFch_eva']) and !empty($_POST['rPor_eva']))
	{	
		session_start();
		include "../include/funcget.php";
		include "../include/funcsql.php";
		include "../include/funcstyle.php";
		
		$tSilaeva = "silaeva".$_SESSION['sSilaano_aca'];
		$vFch_eva = fFechamy($_POST['rFch_eva']);
		
		if($_SESSION["sSilaiut_eva"] == 'i')
		{
			$vQuery = "insert into $tSilaeva (ano_aca, per_aca, cod_car, pln_est, cod_cur, sec_gru, mod_mat, uni_pro, tip_eva, des_eva, fch_eva, por_eva) values ";
			$vQuery .= "('{$_SESSION['sSilaano_aca']}', '{$_SESSION['sSilaper_aca']}', '{$_SESSION['sSilacod_car']}', '{$_SESSION['sSilapln_est']}', ";
			$vQuery .= "'{$_SESSION['sSilacod_cur']}', '{$_SESSION['sSilasec_gru']}', '{$_SESSION['sSilamod_mat']}', '{$_POST['rUni_pro']}', ";
			$vQuery .= "'{$_POST['rTip_eva']}', '{$_POST['rDes_eva']}', '$vFch_eva', '{$_POST['rPor_eva']}') ";
	
			$cResult = fInupde2($vQuery);
			$bDatos = TRUE;
		}
		elseif($_SESSION["sSilaiut_eva"] == 'u')
		{
			$vUni_proo = substr($_SESSION["sSilatip_eva"], 0, 1);
			$vTip_evao = substr($_SESSION["sSilatip_eva"], 1, 2);
			$vFch_evao = substr($_SESSION["sSilatip_eva"], 3, 10);
						
			$vQuery = "update $tSilaeva set uni_pro = '{$_POST['rUni_pro']}', tip_eva = '{$_POST['rTip_eva']}', ";
			$vQuery .= "des_eva = '{$_POST['rDes_eva']}', fch_eva = '$vFch_eva', por_eva = '{$_POST['rPor_eva']}' ";
			$vQuery .= "where pln_est = '{$_SESSION['sSilapln_est']}' and ";
			$vQuery .= "cod_cur = '{$_SESSION['sSilacod_cur']}' and sec_gru = '{$_SESSION['sSilasec_gru']}' and ";
			$vQuery .= "mod_mat = '{$_SESSION['sSilamod_mat']}' and cod_car = '{$_SESSION['sSilacod_car']}' and ";
			$vQuery .= "ano_aca = '{$_SESSION['sSilaano_aca']}' and per_aca = '{$_SESSION['sSilaper_aca']}' and ";
			$vQuery .= "uni_pro = '$vUni_proo' and tip_eva = '$vTip_evao' and ";
			$vQuery .= "fch_eva = '$vFch_evao' ";

			$cResult = fInupde2($vQuery);
			$bDatos = TRUE;
		}
		$_SESSION["sSilaiut_eva"] = 'i';
		$_SESSION["sSilatip_eva"] = '';
	}
		
	if(fsafetylogin())
	{
		
?>
		<table border="0" cellpadding="0" cellspacing="0" bordercolor="#FF0000" class="tlistsearch">
				<tr>
				  <th width="10">&nbsp;</th>
				  <th width="50" align="right">Un.Pr.</th>
				  <th width="200" align="right">Tipo evaluaci&oacute;n </th>
				  <th width="50">Fecha</th>
				  <th width="50">Porc(%)</th>
				  <th width="16">&nbsp;</th>
				  <th width="16">&nbsp;</th>
				</tr>
			<?
			$vCont = 1;
			$tSilaeva = "silaeva".$_SESSION['sSilaano_aca'];

			$vQuery = "select se.uni_pro, if(se.uni_pro = '9', 'TODAS', se.uni_pro) as uni_pro2, se.tip_eva, te.eva_des, se.fch_eva, se.por_eva ";
			$vQuery .= "from $tSilaeva se left join tipoeva te on se.tip_eva = te.tip_eva ";
			$vQuery .= "where se.ano_aca = '{$_SESSION['sSilaano_aca']}' and se.per_aca = '{$_SESSION['sSilaper_aca']}' and ";
			$vQuery .= "se.cod_car = '{$_SESSION['sSilacod_car']}' and se.pln_est = '{$_SESSION['sSilapln_est']}' and ";
			$vQuery .= "se.cod_cur = '{$_SESSION['sSilacod_cur']}' and sec_gru = '{$_SESSION['sSilasec_gru']}' and ";
			$vQuery .= "mod_mat = '{$_SESSION['sSilamod_mat']}' order by uni_pro2, fch_eva";
			
			$cResult = fQuery2($vQuery);
			$vNum_rows = fCountq($cResult);
			while($aResult = mysql_fetch_array($cResult))
			{
			?>
				<tr <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)">
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$vCont?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['uni_pro2']?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['eva_des']?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?= fFechad($aResult['fch_eva'])?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['por_eva']?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><a href="" onclick="si2_updevalua('<?=$aResult['uni_pro']?>', '<?=$aResult['tip_eva']?>', '<?=$aResult['fch_eva']?>'); return false;" class="enlaceb"><img src="../images/edit.png" alt="Modificar Evaluacion" width="16" height="16" /></a></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>>&nbsp;</td>
				</tr>
			<? 
				$vPorcen+=$aResult['por_eva'];
				$vCont++; 	
			} 
			?>
			</table>
		<table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><div class="dboton"><a href="" onclick = "si2_getevaluacap(); return false;" class="icontinue" title="Aceptar">Continuar</a></div>
                <div class="dboton"><a href="" onclick="<?=($_SESSION["sSilacaiu"]=='i'?"clicksilabo()":"clicksilabo()")?>; return false;" class="icancel" title="Cancelar">Cancelar</a></div></td>
          </tr>
        </table>
		<?	
	}
?>