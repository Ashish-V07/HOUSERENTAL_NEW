<?php
session_start();
session_unset();
session_destroy();
header("Location: /houserental-master/homlisti/my-account/index.php");
exit();
?>
