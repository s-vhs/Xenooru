<?php

$endtime = microtime(true);
$smarty->assign("loadingtime", substr($endtime - $starttime, 0, -10));
