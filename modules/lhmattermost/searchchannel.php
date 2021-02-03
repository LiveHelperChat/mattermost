<?php

if ($_POST['q'] != '') {
    $channels = erLhcoreClassMattermostValidator::suggestChannel($_POST['t'], $_POST['q']);
} else {
    $channels = [];
}

$tpl = erLhcoreClassTemplate::getInstance('lhmattermost/searchchannel.tpl.php');

$tpl->set('channels', $channels);

echo $tpl->fetch();

exit;


?>