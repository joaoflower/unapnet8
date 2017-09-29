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
		$vCont = 1;
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
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Plan de Estudios </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="0" bordercolor="#FF0000" class="tlistsearch">
				<tr>
				  <th width="20">&nbsp;</th>
				  <th width="30">CC</th>
				  <th width="120">Curso</th>
		  	    </tr>
			<?
			$vQuery = "select cod_cur, des_cur, nivel from cursos where cod_esp = '{$_SESSION['sCidcod_esp']}' order by nivel ";
			
			$cResult = fQueryi($vQuery);
			$vNum_rows = fCountqi($cResult);
			while($aResult = mysql_fetch_array($cResult))
			{
			?>
				<tr <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)">
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['nivel']?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['cod_cur']?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['des_cur']?></td>
		  	    </tr>
			<? 
				$vCont++; 	
			} 
			?>
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
			
	</center>	
<?		
	}
?>
