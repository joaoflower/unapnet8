<STYLE type=text/css>
@import url( ../css/main.css );
@import url( ../css/frame.css );
@import url( ../css/framelogin.css );
@import url( ../css/style.css );
</STYLE>

<?
	if(!empty($_POST['rCan_bol']))
	{	
		session_start();
		include "../include/funcget.php";
		include "../include/funcsql.php";
		include "../include/funcstyle.php";
		$_SESSION['sEstucan_bol'] = $_POST['rCan_bol'];
	}
	
	if(fsafetylogin())
	{
		
?>
		<table border="0" cellpadding="0" cellspacing="0" bordercolor="#FF0000" class="tlistdata">   
		  <tr>
            <th width="10" class="tdultimo">&nbsp;</th>
            <th width="80" class="tdultimo">Secuencia</th>
            <th width="115" class="tdultimo">Fecha (dd/mm/aaaa) </th>
            <th width="70" class="tdultimo">Importe</th>
          </tr>       
          <?
		  	for($ii = 1; $ii <= $_SESSION['sEstucan_bol']; $ii++)
			{
		  ?>
          
          <tr>
            <td class="tdultimo"><?=$ii?></td>
            <td class="tdultimo"><input name="rSecuencia<?=$ii?>" type="text" class="" id="rSecuencia<?=$ii?>" value="<?=$_SESSION[""]?>" size="7" maxlength="7" onblur="fupper(this);"/></td>
            <td class="tdultimo"><input name="rFch_pag<?=$ii?>" type="text" class="" id="rFch_pag<?=$ii?>" value="<?=$_SESSION[""]?>" size="10" maxlength="10" onblur="fupper(this);"/></td>
            <td class="tdultimo"><input name="rImp_pag<?=$ii?>" type="text" class="" id="rImp_pag<?=$ii?>" value="<?=$_SESSION[""]?>" size="6" maxlength="6" onblur="fupper(this);"/></td>
          </tr>
          <?
		  	}
		  ?>
        </table>
		<?	
	}
?>