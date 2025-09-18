<?php include('../models/Tip.php'); $tips = Tip::getAllTips(); foreach ($tips as $tip) echo $tip['title'].'<br>'; ?>
