<STYLE type=text/css>
@import url( ../css/main.css );
@import url( ../css/frame.css );
@import url( ../css/framelogin.css );
@import url( ../css/style.css );
</STYLE>

<?
	if(fsafetylogin())
	{
		$bDatos = TRUE;
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
	
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Cambio de contrase&ntilde;a </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
			<?	if($_SESSION['sPswMessage'] == TRUE)	{	?>
			<span class="wordi">LA(S) CONTRASE&Ntilde;A(S) INGRESADA(S)<br />
			ES(SON) INCORRECTA(S) </span>
			<?	}	$_SESSION['sPswMessage'] = FALSE;	?>
			<table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
			  <tr>
			    <td width="120">Contrase&ntilde;a antigua :  </td>
			    <th width="120"><input name="rOldpasswd" type="password" class="" id="rOldpasswd" size="15" maxlength="20" /></th>
		      </tr>
			  <tr>
			    <td>Contrase&ntilde;a nueva  :</td>
			    <th><input name="rNewpasswd" type="password" class="" id="rNewpasswd" size="15" maxlength="20" /></th>
		      </tr>
			  <tr>
			    <td>Repita contrase&ntilde;a : </td>
			    <th><input name="rReppasswd" type="password" class="" id="rReppasswd" size="15" maxlength="20" /></th>
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
			<div class="dboton"><a href="" onClick = "psw_savepasswd(document.fData); return false;" class="isave" title="Cambiar contraseña">Cambiar</a></div>
		</td>
	  </tr>
	</table>
	
	</form>	
	</center>
<?
	}
?>