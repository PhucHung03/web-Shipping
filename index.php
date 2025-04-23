<?php
require_once("./component/header.php");

if (!isset($_GET['url'])) {
    require_once("./public/trangchu.php");
} else {
    switch ($_GET['url']) {
        case 'trangchu':
            require_once("./public/trangchu.php");
            break;
        case 'contact':
            require_once("./public/view/contact.php");
            break;
        case 'create-shipment':
            require_once("./public/view/create-shipment.php");
            break;
        case 'success-create-shipment':
            require_once("./public/view/success.php");
            break;
        case 'manager-shipment':
            require_once("./public/view/QL_donGiao.php");
            break;
        case 'login':
            require_once("./public/view/login.php");
            break;
        case 'register':
            require_once("./public/view/register.php");
            break;
        case 'logout':
            require_once("./public/view/logout.php");
            break;
        case 'contact':
            require_once("./public/view/contact.php");
            break;
    }
}



require_once("./component/footer.php");
