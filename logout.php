<?php include_once('model.php');
include_once('control.php');

include_once('./inc/header.php'); ?>
<div id="page">Deconnection</div>
<div id="main">
<?php

session_destroy();
echo '<script language="JavaScript">alert("Vous êtes déconnecté(e)");window.location="index.php"</script>';

?>

</div>
<div id="page">...</div>

<? include_once('./inc/footer.php');?>
