<?php include('../models/Admin.php'); $users = Admin::getAllUsers(); foreach ($users as $user) echo $user['full_name'].' ('.$user['role'].')<br>'; ?>
