<?php

$tpl = erLhcoreClassTemplate::getInstance('lhmattermost/index.tpl.php');

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('mattermost/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost', 'Mattermost integration')
    )
);

?>