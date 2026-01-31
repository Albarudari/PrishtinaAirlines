<?php
require_once 'M/UserMapper.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $userMapper = new UserMapper();
    
    
    try {
        $userMapper->deleteUser($id);
    } catch (Exception $e) {
       
    }
}


header("Location: admin_dashboard.php");
exit();
?>