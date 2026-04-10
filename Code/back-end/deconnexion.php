<?php
session_start();

session_unset();

session_destroy();

echo "<div style='padding:15px; background:#d4edda; border:1px solid #c3e6cb; color:#155724;'>
        Vous avez bien été déconnecté.
      </div>";

header("refresh:2;url=../index.php");
exit;
?>