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
		//------------------
		if(!empty($_POST['rCap1']) and !empty($_POST['rPor_ca1']))
		{			
			$vQuery = "update $tSilaok set cap1 = '{$_POST['rCap1']}', por_ca1 = '{$_POST['rPor_ca1']}' ";
			
			for($ii = 2; $ii <= $_SESSION["sSilacan_cap2"]; $ii++)
			{
				$vCap = $_POST['rCap'.$ii];
				$vPro_cap = $_POST['rPor_ca'.$ii];
				$vQuery .= ", cap$ii = '$vCap', por_ca$ii = '$vPro_cap' ";			
			}
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
	<strong>V. EVALUACI&Oacute;NES </strong>
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
      <tr>
        <td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
        <th background="../images/ven_topcenter.jpg">Actitudes</th>
        <td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
      </tr>
      <tr>
        <td background="../images/ven_mediumleft.jpg"></td>
        <td align="center"><table border="0" cellpadding="0" cellspacing="0" bordercolor="#FF0000" class="tlistsearch">
          <tr>
            <th width="10">&nbsp;</th>
            <th width="440" align="right">Actitud</th>
            <th width="50">&nbsp;</th>
            </tr>
          <?
		  	$vCont = 1;
			$vQuery = "select act1, act2, act3, act4 ";
			$vQuery .= "from $tSilaok where pln_est = '{$_SESSION['sSilapln_est']}' and ";
			$vQuery .= "cod_cur = '{$_SESSION['sSilacod_cur']}' and sec_gru = '{$_SESSION['sSilasec_gru']}' and ";
			$vQuery .= "mod_mat = '{$_SESSION['sSilamod_mat']}' and cod_car = '{$_SESSION['sSilacod_car']}' and ";
			$vQuery .= "ano_aca = '{$_SESSION['sSilaano_aca']}' and per_aca = '{$_SESSION['sSilaper_aca']}' and ";
			$vQuery .= "cod_prf = '{$_SESSION['sUsercod_usu']}' ";
			
			$cResult = fQuery($vQuery);
			$vNum_rows = $_SESSION["sSilacan_act2"];
			if($aResult = mysql_fetch_array($cResult))
			{
				for($ii = 1; $ii <= $_SESSION["sSilacan_act2"]; $ii++)
				{
			
			?>
          <tr <?=ftrstyle($vCont)?>  onmouseover="mouseover(this)" onmouseout="mouseout(this)">
            <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$ii?></td>
            <td <?=ftdstyle($vNum_rows, $vCont)?>><textarea name="rAct<?=$ii?>" cols="80" rows="3" id="rAct<?=$ii?>"  onblur="fupper(this);"><?=$aResult['act'.$ii]?></textarea></td>
            <td <?=ftdstyle($vNum_rows, $vCont)?>>&nbsp;</td>
          </tr>
          <? 				
					$vCont++; 	
				}
			} 
			?>
        </table>
          <table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><div class="dboton"><a href="" onclick = "si2_savesilabo(document.fData); return false;" class="isave" title="Guardar">Guardar</a></div>
                  <div class="dboton"><a href="" onclick="<?=($_SESSION["sSilacaiu"]=='i'?"clicksilabo()":"clicksilabo()")?>; return false;" class="icancel" title="Cancelar">Cancelar</a></div></td>
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
	<!-- -->
        </td>
	  </tr>
	</table>

	
  </form>	
</center>
<?
	}
?>