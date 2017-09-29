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
		
		if($_SESSION['sSilaend_ing'] == 'F')
		{
/*			if($_SESSION['sUsercod_usu'] != '0000000')
				$_SESSION['sSilaend_ing'] = 'F';
			else
				$_SESSION['sSilaend_ing'] = 'T';*/
			$bDatos = TRUE;
		}
		
		$tCarga = "cargaint".$_SESSION['sFrameano_aca'];
		$tIngnota = "ingnota".$_SESSION['sFrameano_aca'];		
		
//		$bDatos = TRUE;
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{
		$_SESSION["sSilacod_car"] = $_SESSION['sUsercod_car'];
		
		$vQuery = "select pln_est from plan where cod_car = '{$_SESSION['sUsercod_car']}' and con_pln = '1' ";
		$cResult = fQuery2($vQuery);
		if($aResult = mysql_fetch_array($cResult))
			$_SESSION["sSilapln_est"] = $aResult['pln_est'];
			
		$_SESSION["sSilacod_cur"] = "999";
		$_SESSION["sSilasec_gru"] = "01";
		$_SESSION["sSilamod_mat"] = "01";
		$_SESSION["sSilasem_anu"] = "01";
		
		$_SESSION["sSilacaiu"] = $_POST['rIns_upd'];
		$_SESSION["sSilamat_des"] = "";
		
		$_SESSION["sSilanom_cur"] = "";
		$_SESSION["sSilaesp_nom"] = "";
		$_SESSION["sSilasem_des"] = "";
		$_SESSION["sSilasec_des"] = "";
		$_SESSION["sSilacod_amb"] = "";
				
		$_SESSION["sSilafun_sil"] = "";
		$_SESSION["sSilacan_cnt"] = 0;
		$_SESSION["sSilacnt1"] = "";
		$_SESSION["sSilacnt2"] = "";
		$_SESSION["sSilacnt3"] = "";
		$_SESSION["sSilacnt4"] = "";
		
		$_SESSION["sSilacan_com"] = 0;		
		$_SESSION["sSilacom1"] = "";
		$_SESSION["sSilacom2"] = "";
		$_SESSION["sSilacom3"] = "";
		$_SESSION["sSilacom4"] = "";
		$_SESSION["sSilacom5"] = "";
		$_SESSION["sSilacom6"] = "";		

		$_SESSION["sSilacan_una"] = 0;
		
		$_SESSION["sSilacan_cap"] = 0;
		$_SESSION["sSilacan_act"] = 0;
		$_SESSION["sSilacan_cap2"] = 6;
		$_SESSION["sSilacan_act2"] = 4;
		
		$_SESSION["sSilaact1"] = "";
		$_SESSION["sSilaact2"] = "";
		$_SESSION["sSilaact3"] = "";
		$_SESSION["sSilaact4"] = "";
		
		//-----------------------------
		$_SESSION["sSilacont_una"] = 0;
		$_SESSION["sSilaunaiu"] = "";
					
?>
<center>
	<form action="#" method="post" enctype="multipart/form-data" name="fData" id="fData">
	  <strong>I. IDENTIFICACI&Oacute;N	ACAD&Eacute;MICA  </strong>
	  <table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">1.1 ASIGNATURA </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
		<span class="wordi">SELECCIONE LA ESCUELA PROFESIONAL, SEMESTRE, <br />
		CURSO Y GRUPO, PARA PODER CONTICUAR. </span>
		<table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
			  <tr>
			    <td width="100">Escuela Prof.  : </td>
			    <th width="350"><select name="rCod_car" id="rCod_car" onchange="si2_viewsemcurgru(this.value); return false;" >
					<?=fviewcarrera($_SESSION["sSilacod_car"])?>
		        </select></th>
		      </tr>
		</table>
		
		<div id="dsemcurgru">
			<? include "si2_viewsemcurgrudata.php"; ?>
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
	
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td><div class="dboton"><a href="" onclick = "si2_getdocente(document.fData); return false;" class="icontinue" title="Continuar">Continuar</a></div>
				<div class="dboton"><a href="" onClick="<?=($_SESSION["sSilacaiu"]=='i'?"clicksilabo()":"clicksilabo()")?>; return false;" class="icancel" title="Cancelar">Cancelar</a></div></td>
		  </tr>
		</table>	
	
	</form>	
</center>
<?
	}
?>
