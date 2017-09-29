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
		<th background="../images/ven_topcenter.jpg">Historial de Notas - Idioma: <?=$_SESSION['sCiddes_esp']?></th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="0" bordercolor="#FF0000" class="tlistsearch">
				<tr>
				  <th width="20">&nbsp;</th>
				  <th width="35">A&ntilde;o</th>
				  <th width="20">CM</th>
				  <th width="80">Mes</th>
				  <th width="30">CC</th>
				  <th width="120">Curso</th>
			  	  <th width="40">Escrito</th>
			  	  <th width="40">Oral</th>
			  	  <th width="40">Final</th>
				</tr>
			<?
			$vQuery = "select nota.*, cu.des_cur from (select ma.anio, ma.cod_mes, me.des_mes, gh.cod_cur, ma.escrito, ma.oral, ";
			$vQuery .= "round((ma.escrito + ma.oral)/2) as final ";
			$vQuery .= "from matriculas ma left join meses me on ma.cod_mes = me.cod_mes ";
			$vQuery .= "left join dbcidiomas.gruposhab gh on ma.cod_gpo = gh.cod_gpo ";
			$vQuery .= "where ma.codigo = '{$_SESSION['sCidnum_mat']}' order by anio, cod_mes) nota ";
			$vQuery .= "left join cursos cu on nota.cod_cur = cu.cod_cur ";
			
			$cResult = fQueryi($vQuery);
			$vNum_rows = fCountqi($cResult);
			while($aResult = mysql_fetch_array($cResult))
			{
			?>
				<tr <?=ftrstyle($vCont)?>  onMouseOver="mouseover(this)" onMouseOut="mouseout(this)">
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$vCont?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['anio']?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['cod_mes']?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['des_mes']?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['cod_cur']?></td>
				  <td <?=ftdstyle($vNum_rows, $vCont)?>><?=$aResult['des_cur']?></td>
			  	  <td <?=ftdstylenotai($vNum_rows, $vCont, $aResult['escrito'])?>><?=$aResult['escrito']?></td>
			  	  <td <?=ftdstylenotai($vNum_rows, $vCont, $aResult['oral'])?>><?=$aResult['oral']?></td>
			  	  <td <?=ftdstylenotai($vNum_rows, $vCont, $aResult['final'])?>><?=$aResult['final']?></td>
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