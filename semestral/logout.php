<?php
session_start();
session_unset();
session_destroy();
header('Location: login.php'); // Redireciona para o login após o logout
exit();
