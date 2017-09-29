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
		
		if(!empty($_SESSION["sCidcod_cur"]))
		{		
			$_SESSION['sCidimp_pag'] = 45.60;
			
			$vQuery = "SELECT cod_car FROM estumat2009all ";
			$vQuery .= "where ano_aca = '{$_SESSION['sFrameano_aca']}' and per_aca = '{$_SESSION['sFrameper_aca']}' and ";
			$vQuery .= "num_mat = '{$_SESSION['sUsercod_usu']}' ";
			
			$cResult = fQuery($vQuery);
			if($aResult = mysql_fetch_array($cResult))
			{
				$_SESSION['sCidimp_pag'] = 30.60;
			}
			$bDatos = TRUE;
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
<form action="#" method="post" enctype="multipart/form-data" name="fData" id="fData">
<img src="../images/boletabn.JPG" />
	<center>
	<span class="wordi"><strong>USTED DEBE DE PAGAR S/. <?=$_SESSION['sCidimp_pag']?></strong></span>
	</center>
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Matricula Actual </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
			  <tr>
				<td width="75">C&oacute;digo :</td>
				<th width="150"><?=$_SESSION['sCidnum_mat']?></th>
				<td width="75">&nbsp;</td>
				<th width="150">&nbsp;</th>
			  </tr>
			  <tr>
				<td>Nombres :</td>
				<th colspan="3"><?=$_SESSION['sUserpaterno']?> <?=$_SESSION['sUsermaterno']?>, <?=$_SESSION['sUsernombres']?></th>
			  </tr>
			  
			  <tr>
			    <td>A&ntilde;o - Mes  :</td>
			    <th><?=$_SESSION['sCidano']?> - <?=$_SESSION['sCiddes_mes']?></th>
			    <td>Especialidad : </td>
			    <th><?=$_SESSION['sCiddes_esp']?></th>
		      </tr>
			  <tr>
			    <td>Curso : </td>
			    <th><?=$_SESSION["sCiddes_cur"]?></th>
			    <td>Hora - Grupo  :</td>
			    <th><select name="rHra_sec" id="rHra_sec">
					<? fviewhoragrupo($_SESSION['sCidcod_esp'], $_SESSION["sCidcod_cur"], $_SESSION["sCidhra_ini"], $_SESSION["sCidhra_fin"], $_SESSION["sCidcod_sec"]) ?>
				  </select></th>
		      </tr>
			  <tr>
			    <td>Secuencia :</td>
			    <th><input name="rNum_rec" type="text" id="rNum_rec" size="7" maxlength="7" /></th>
			    <td>Importe pago : </td>
			    <th><input name="rImp_pag" type="text" id="rImp_pag" size="5" maxlength="5" > (S/. <?=$_SESSION['sCidimp_pag']?>) </th>
		      </tr>
			  <tr>
			    <td>Fecha Pago: </td>
			    <th><input name="rFch_pag" type="text" id="rFch_pag" size="10" maxlength="10" > 
			    (dd/mm/aaa) </th>
			    <td>&nbsp;</td>
			    <th>&nbsp;</th>
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
			
	<table border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td>
			<div class="dboton"><a href="" onClick = "cid_savematri(document.fData); return false;" class="icontinue" title="Matricular">Matricular</a></div>
			<div class="dboton"><a href="" onClick = "iclickmatricular();  return false;" class="icancel" title="Cancelar">Cancelar</a></div>			
		</td>
	  </tr>
	</table>
</form>
</center>
<?
	}
?>