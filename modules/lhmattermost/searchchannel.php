<?php

$item = null;

if (isset($_POST['i']) && is_numeric($_POST['i']) ) {
    $item = erLhcoreClassModelMattermostSetting::fetch($_POST['i']);
}

if ($_POST['q'] != '') {
    $channels = erLhcoreClassMattermostValidator::suggestChannel($_POST['t'], $_POST['q'], $item);
} else {
    $channels = [];
}

$tpl = erLhcoreClassTemplate::getInstance('lhmattermost/searchchannel.tpl.php');

$tpl->set('channels', $channels);

echo $tpl->fetch();

exit;


?>