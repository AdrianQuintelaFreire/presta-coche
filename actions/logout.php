<?php

session_start();

session_destroy();

header("Location: /prestacoche/public/index.php");
exit();

?>