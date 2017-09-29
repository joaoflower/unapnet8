<STYLE type=text/css>
@import url( ../css/main.css );
@import url( ../css/frame.css );
@import url( ../css/framelogin.css );
@import url( ../css/style.css );
</STYLE>

<?
	if($_POST['rIns_upd'] == 'u')
	{
		session_start();
		include "../include/funcget.php";
		include "../include/funcsql.php";
		include "../include/funcstyle.php";
		$_SESSION["sActacaiu"] = $_POST['rIns_upd'];
	}	
	else
	{
		$_SESSION["sActacaiu"] = 'i';
	}
	
	if(fsafetylogin())
	{
		$bDatos = FALSE;
		$bDatos = TRUE;
	}
	else
	{
		header("Location:../index.php");
	}
	if($bDatos == TRUE)
	{
		
?>
		<span class="wordi">INGRESAR LA CANTIDAD DE <br />
			CAPACIDADES Y ACTITUDES <br />
			DEL CURSO</span>
		<table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
          <tr>
            <td width="75">Capacidades : </td>
            <th width="75"><select name="rCan_cap" id="rCan_cap">
              <option value="1" <?=($_SESSION["sActacan_cap"]=='1'?'Selected':'')?>>1</option>
              <option value="2" <?=($_SESSION["sActacan_cap"]=='2'?'Selected':'')?>>2</option>
              <option value="3" <?=($_SESSION["sActacan_cap"]=='3'?'Selected':'')?>>3</option>
              <option value="4" <?=($_SESSION["sActacan_cap"]=='4'?'Selected':'')?>>4</option>
              <option value="5" <?=($_SESSION["sActacan_cap"]=='5'?'Selected':'')?>>5</option>
              <option value="6" <?=($_SESSION["sActacan_cap"]=='6'?'Selected':'')?>>6</option>
            </select></th>
          </tr>
          <tr>
            <td>Actitudes : </td>
            <th><select name="rCan_act" id="rCan_act">
              <option value="1" <?=($_SESSION["sActacan_act"]=='1'?'Selected':'')?>>1</option>
              <option value="2" <?=($_SESSION["sActacan_act"]=='2'?'Selected':'')?>>2</option>
              <option value="3" <?=($_SESSION["sActacan_act"]=='3'?'Selected':'')?>>3</option>
              <option value="4" <?=($_SESSION["sActacan_act"]=='4'?'Selected':'')?>>4</option>
            </select></th>
          </tr>
        </table>
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td><div class="dboton"><a href="" onclick = "act_getdesca(document.fData); return false;" class="icontinue" title="Aceptar">Continuar</a></div>
				<div class="dboton"><a href="" onClick="<?=($_SESSION["sActacaiu"]=='i'?"clickacta()":"act_cancelnota()")?>; return false;" class="icancel" title="Cancelar">Cancelar</a></div></td>
		  </tr>
		</table>	
<?
	}
?>

