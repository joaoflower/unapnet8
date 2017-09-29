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
		$tSilaok = "silaok".$_SESSION['sSilaano_aca'];	
			
		if(!empty($_POST['rFun_sil']) and !empty($_POST['rCnt1']))
		{			
			$_SESSION["sSilafun_sil"] = $_POST['rFun_sil'];
			$_SESSION["sSilacnt1"] = $_POST['rCnt1'];
			$_SESSION["sSilacnt2"] = $_POST['rCnt2'];
			$_SESSION["sSilacnt3"] = $_POST['rCnt3'];
			$_SESSION["sSilacnt4"] = $_POST['rCnt4'];
			
			
			if(empty($_SESSION["sSilacan_com"]))
				$_SESSION["sSilacan_com"] = $_SESSION["sSilacan_cnt"];
			if(empty($_SESSION["sSilacan_una"]))
				$_SESSION["sSilacan_una"] = $_SESSION["sSilacan_cnt"];
			
			//--------------------------------------------------------------------
			if($_SESSION["sSilacaiu"] == 'i')
			{
				$vQuery = "insert into $tSilaok (pln_est, cod_cur, sec_gru, mod_mat, cod_car, ano_aca, per_aca, cod_prf, ";
				$vQuery .= "cod_amb, fun_sil, can_cnt, cnt1, cnt2, cnt3, cnt4) values ";
				$vQuery .= "('{$_SESSION['sSilapln_est']}', '{$_SESSION['sSilacod_cur']}', '{$_SESSION['sSilasec_gru']}', ";
				$vQuery .= "'{$_SESSION['sSilamod_mat']}', '{$_SESSION['sSilacod_car']}', '{$_SESSION['sSilaano_aca']}', ";
				$vQuery .= "'{$_SESSION['sSilaper_aca']}', '{$_SESSION['sUsercod_usu']}', '{$_SESSION['sSilacod_amb']}', ";
				$vQuery .= "'{$_SESSION['sSilafun_sil']}', '{$_SESSION['sSilacan_cnt']}', '{$_SESSION['sSilacnt1']}', ";
				$vQuery .= "'{$_SESSION['sSilacnt2']}', '{$_SESSION['sSilacnt3']}', '{$_SESSION['sSilacnt4']}') ";
				
				if($cSila = fInupde($vQuery))
				{				
					$bDatos = TRUE;
				}			
			}
			elseif($_SESSION["sSilacaiu"] == 'u')
			{
				$vQuery = "update $tSilaok set fun_sil = '{$_SESSION['sSilafun_sil']}', can_cnt = '{$_SESSION['sSilacan_cnt']}', ";
				$vQuery .= "cnt1 = '{$_SESSION['sSilacnt1']}', cnt2 = '{$_SESSION['sSilacnt2']}', ";
				$vQuery .= "cnt3 = '{$_SESSION['sSilacnt3']}', cnt4 = '{$_SESSION['sSilacnt4']}', cod_amb = '{$_SESSION['sSilacod_amb']}' ";
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
	    <br /></td>
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
		
		<strong>III. COMPETENCIAS </strong>
		<table border="0" cellpadding="0" cellspacing="0" class="tventana">
		  <tr>
			<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
			<th background="../images/ven_topcenter.jpg">Competencias</th>
			<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
		  </tr>
		  <tr>
			<td background="../images/ven_mediumleft.jpg"></td>
			<td align="center"><div id="dsilabo">
			  <table border="0" cellpadding="0" cellspacing="0" bordercolor="#FF0000" class="tlistdata">
				  <tr>
					<th  width="515"  colspan="2">Cantidad : 
					  <select name="rCan_com" id="rCan_com" onchange="si2_getcompedata(this.value); return false;" >
						<option value="1" <?=($_SESSION["sSilacan_com"]=='1'?'Selected':'')?>>1</option>
						<option value="2" <?=($_SESSION["sSilacan_com"]=='2'?'Selected':'')?>>2</option>
						<option value="3" <?=($_SESSION["sSilacan_com"]=='3'?'Selected':'')?>>3</option>
						<option value="4" <?=($_SESSION["sSilacan_com"]=='4'?'Selected':'')?>>4</option>
						<option value="5" <?=($_SESSION["sSilacan_com"]=='5'?'Selected':'')?>>5</option>
						<option value="6" <?=($_SESSION["sSilacan_com"]=='6'?'Selected':'')?>>6</option>
					  </select></th>
				  </tr>             
				</table>
				<div id="dcontra">
					<? include "si2_getcompedata.php"; ?>
				</div>
				</div></td>
			<td background="../images/ven_mediumright.jpg"></td>
		  </tr>
		  <tr>
			<td><img src="../images/ven_bottomleft.jpg" width="16" height="16" border="0" alt="" /></td>
			<td background="../images/ven_bottomcenter.jpg"></td>
			<td><img src="../images/ven_bottomright.jpg" width="16" height="16" border="0" alt="" /></td>
		  </tr>
		</table>
		
		<strong>IV. PROGRAMACI&Oacute;N DE LA ASIGNATURA </strong>
		
		<table border="0" cellpadding="0" cellspacing="0" class="tventana">
          <tr>
            <td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
            <th background="../images/ven_topcenter.jpg">Unidades de Aprendizaje </th>
            <td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
          </tr>
          <tr>
            <td background="../images/ven_mediumleft.jpg"></td>
            <td align="center"><div id="div">
              <table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
                      <tr>
                        <td width="75">Cantidad : </td>
                        <th width="75"><select name="rCan_una" id="rCan_una">
                            <option value="1" <?=($_SESSION["sSilacan_una"]=='1'?'Selected':'')?>>1</option>
                            <option value="2" <?=($_SESSION["sSilacan_una"]=='2'?'Selected':'')?>>2</option>
                            <option value="3" <?=($_SESSION["sSilacan_una"]=='3'?'Selected':'')?>>3</option>
                            <option value="4" <?=($_SESSION["sSilacan_una"]=='4'?'Selected':'')?>>4</option>
                            <option value="5" <?=($_SESSION["sSilacan_una"]=='5'?'Selected':'')?>>5</option>
                            <option value="6" <?=($_SESSION["sSilacan_una"]=='6'?'Selected':'')?>>6</option>
                        </select></th>
                      </tr>
                    </table>
              <table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><div class="dboton"><a href="" onclick = "si2_getheaderuna(document.fData); return false;" class="icontinue" title="Continuar">Continuar</a></div>
                            <div class="dboton"><a href="" onclick="<?=($_SESSION["sSilacaiu"]=='i'?"clicksilabo()":"clicksilabo()")?>; return false;" class="icancel" title="Cancelar">Cancelar</a></div></td>
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
		<!-- -->		
		
		</td>
	  </tr>
	</table>

	
  </form>	
</center>
<?
	}
?>