<?php
require_once __DIR__ . '/../config/auth.php';
destroySession();
header('Location: ../home.php');
exit;