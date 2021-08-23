<?php
$tpl = erLhcoreClassTemplate::getInstance('lhmattermost/settings.tpl.php');

$osTicketOptions = erLhcoreClassModelChatConfig::fetch('mattermost_options');
$data = (array) $osTicketOptions->data;

if (ezcInputForm::hasPostData()) {

    $Errors = erLhcoreClassMattermostValidator::validateSettings($data);

    if (count($Errors) == 0) {
        try {
            $osTicketOptions->explain = '';
            $osTicketOptions->type = 0;
            $osTicketOptions->hidden = 1;
            $osTicketOptions->identifier = 'mattermost_options';
            $osTicketOptions->value = serialize($data);
            $osTicketOptions->saveThis();
            
            $tpl->set('updated', true);
        } catch (Exception $e) {
            $tpl->set('errors', array(
                $e->getMessage()
            ));
        }

    } else {
        $tpl->set('errors', $Errors);
    }
}

$tpl->set('data',$data);

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('mattermost/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost', 'Mattermost')
    ),
    array(
        'url' => erLhcoreClassDesign::baseurl('mattermost/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost', 'Mattermost integration settings')
    )
);

?>