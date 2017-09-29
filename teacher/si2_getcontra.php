<STYLE type=text/css>
@import url( ../css/main.css );
@import url( ../css/frame.css );
@import url( ../css/framelogin.css );
@import url( ../css/style.css );
</STYLE>

<?
	
	$vCan_cnt = 1;
	$aResult = "";
	
	if(!empty($_POST['rCan_cnt']))
	{	
		session_start();
		include "../include/funcget.php";
		include "../include/funcsql.php";
		include "../include/funcstyle.php";
		$_SESSION["sSilacan_cnt"] = $_POST['rCan_cnt'];
	}
	if($_SESSION["sSilacan_cnt"] == 0)
		$_SESSION["sSilacan_cnt"] = 1;
	
	if(fsafetylogin())
	{
		
?>
		<table border="0" cellpadding="0" cellspacing="0" bordercolor="#FF0000" class="tlistdata">          
          <?
		  	for($ii = 1; $ii <= $_SESSION["sSilacan_cnt"]; $ii++)
			{
		  ?>
          <tr>
            <td width="10" class="tdultimo"><?=$ii?></td>
            <td width="480" class="tdultimo"><textarea name="rCnt<?=$ii?>" cols="95" rows="2" id="rCnt<?=$ii?>"  onblur="fupper(this);"><?=$_SESSION['sSilacnt'.$ii]?></textarea></td>
          </tr>
          <?
		  	}
		  ?>
        </table>
		<?	
	}
?>