<?php
session_start();
session_destroy();
header("Location: PublicSignin.php");
exit;
