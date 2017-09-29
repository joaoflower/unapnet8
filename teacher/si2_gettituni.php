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
						
		if(!empty($_POST['rCod_car']) and !empty($_POST['rDep_aca']) and !empty($_POST['rCnd_prf']) and !empty($_POST['rCod_cat'])and !empty($_POST['rCod_gru'])and !empty($_POST['rEsp_doc'])and !empty($_POST['rCod_amb']))
		{
			$vQuery = "update docente set cod_car = '{$_POST['rCod_car']}', dep_aca = '{$_POST['rDep_aca']}',  ";
			$vQuery .= "cnd_prf = '{$_POST['rCnd_prf']}', cod_cat = '{$_POST['rCod_cat']}', cod_gru = '{$_POST['rCod_gru']}', ";
			$vQuery .= "esp_doc = '{$_POST['rEsp_doc']}' ";
			$vQuery .= "where cod_prf = '{$_SESSION['sUsercod_usu']}' and cod_car = '{$_SESSION['sUsercod_car']}' ";
					
			if($cUser = fInupde($vQuery))
			{
				$_SESSION["sSilacod_amb"] = $_POST['rCod_amb'];
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
	<strong>II. FUNDAMENTACI&Oacute;N Y CONTENIDOS TRANSVERSALES </strong>
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
      <tr>
        <td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
        <th background="../images/ven_topcenter.jpg">a) Fundamentaci&oacute;n </th>
        <td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
      </tr>
      <tr>
        <td background="../images/ven_mediumleft.jpg"></td>
        <td align="center"><textarea name="rFun_sil" cols="100" rows="5" id="rFun_sil"  onblur="fupper(this);"><?=$_SESSION['sSilafun_sil']?></textarea></td>
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
		<th background="../images/ven_topcenter.jpg">b) Contenidos Transversales </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center"><div id="dsilabo">
		  <table border="0" cellpadding="0" cellspacing="0" bordercolor="#FF0000" class="tlistdata">
              <tr>
                <th  width="515"  colspan="2">Cantidad : 
                  <select name="rCan_cnt" id="rCan_cnt" onchange="si2_getcontra(this.value); return false;" >
                    <option value="1" <?=($_SESSION["sSilacan_cnt"]=='1'?'Selected':'')?>>1</option>
                    <option value="2" <?=($_SESSION["sSilacan_cnt"]=='2'?'Selected':'')?>>2</option>
                    <option value="3" <?=($_SESSION["sSilacan_cnt"]=='3'?'Selected':'')?>>3</option>
                    <option value="4" <?=($_SESSION["sSilacan_cnt"]=='4'?'Selected':'')?>>4</option>
                    <option value="5" <?=($_SESSION["sSilacan_cnt"]=='5'?'Selected':'')?>>5</option>
                    <option value="6" <?=($_SESSION["sSilacan_cnt"]=='6'?'Selected':'')?>>6</option>
                  </select></th>
              </tr>             
            </table>
			<div id="dcontra">
				<? include "si2_getcontra.php"; ?>
			</div>
			<table border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td><div class="dboton"><a href="" onclick = "si2_getcompe(document.fData); return false;" class="icontinue" title="Aceptar">Continuar</a></div>
					<div class="dboton"><a href="" onClick="<?=($_SESSION["sSilacaiu"]=='i'?"clicksilabo()":"clicksilabo()")?>; return false;" class="icancel" title="Cancelar">Cancelar</a></div></td>
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
		<!-- -->		</td>
	  </tr>
	</table>

	
  </form>	
</center>
<?
	}
?>