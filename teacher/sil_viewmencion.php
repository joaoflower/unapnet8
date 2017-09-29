<?
	session_start();
	include "../include/funcget.php";
	include "../include/funcsql.php";
	include "../include/funcstyle.php";
	include "../include/funcoption.php";
	if(fsafetylogin())
	{
		if(!empty($_POST['rCod_cur']))
		{
			$_SESSION["sSilacod_cur"] = $_POST['rCod_cur'];
?>
			<?=fNomespcurso($_SESSION["sSilacod_car"], $_SESSION["sSilapln_est"], $_SESSION["sSilacod_cur"]);?>
<?
		}
	}
?>