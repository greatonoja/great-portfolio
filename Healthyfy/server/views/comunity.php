<?php include('../models/Community.php'); $posts = Community::getAllPosts(); foreach ($posts as $post) echo $post['title'].'<br>'; ?>
