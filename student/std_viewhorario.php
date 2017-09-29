<STYLE type=text/css>
@import url( ../css/main.css );
@import url( ../css/frame.css );
@import url( ../css/framelogin.css );
@import url( ../css/style.css );
</STYLE>

<?
	session_start();
	include "../include/funcget.php";
	include "../include/funcoption.php";
	include "../include/funcsql.php";
	include "../include/funcstyle.php";
	if(fsafetylogin())
	{
		$bDatos = FALSE;
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
	<span class="wordi"><strong>SELECCIONE EL SEMESTRE, GRUPO Y MENCI&Oacute;N  <br />
	PARA VER EL HORARIO. <br />
	</strong></span>
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Horarios</th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center"><table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
          <tr>
            <td width="120">Sem-Grupo-Menci&oacute;n : </td>
            <th width="400"><select name="rClave" id="rClave" onchange="std_viewhorasge(this.value); return false;" onfocus="std_viewhorasge(this.value); return false;">
                <? fviewsemgruesp('010100'); ?>
            </select></th>
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
	<div id="dhorario">
	</div>

</center>
<?		
	}
?>