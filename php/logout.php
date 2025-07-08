<?php
session_start();
session_destroy();
header("Location: ../index.html"); // Ajuste o caminho se necessário
exit;
