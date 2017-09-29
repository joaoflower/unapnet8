<STYLE type=text/css>
@import url( ../css/main.css );
@import url( ../css/frame.css );
@import url( ../css/framelogin.css );
@import url( ../css/style.css );
</STYLE>

<?
//	$vCanti = $_SESSION["sSilacan_com"];
	$aResult = "";
	
	if(!empty($_POST['rCan_com']))
	{	
		session_start();
		include "../include/funcget.php";
		include "../include/funcsql.php";
		include "../include/funcstyle.php";
		//$vCanti = $_POST['rCan_com'];
		$_SESSION["sSilacan_com"] = $_POST['rCan_com'];
	}
	//$_SESSION["sSilacan_com"] = $vCanti;
	
	if(fsafetylogin())
	{
		
?>
		<table border="0" cellpadding="0" cellspacing="0" bordercolor="#FF0000" class="tlistdata">          
          <?
		  	for($ii = 1; $ii <= $_SESSION["sSilacan_com"]; $ii++)
			{
		  ?>
          <tr>
            <td width="10" class="tdultimo"><?=$ii?></td>
            <td width="480" class="tdultimo"><textarea name="rCom<?=$ii?>" cols="95" rows="3" id="rCom<?=$ii?>"  onblur="fupper(this);"><?=$_SESSION["sSilacom".$ii]?></textarea></td>
          </tr>
          <?
		  	}
		  ?>
        </table>
		<?	
	}
?>