<?php
ob_start();
session_start();

// Hủy toàn bộ session
session_destroy();

ob_end_clean();
header('Location: /webgiaohang/index.php?url=login');
exit;
?>
