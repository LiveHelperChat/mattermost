<?php
$tpl = erLhcoreClassTemplate::getInstance('lhmattermost/editoption.tpl.php');

$item = erLhcoreClassModelMattermostSetting::fetch($Params['user_parameters']['id']);
$data = $item->settings_array;

$tpl->set('item', $item);

if (ezcInputForm::hasPostData()) {

    $Errors = erLhcoreClassMattermostValidator::validateSettings($data, array('per_department' => true, 'item' => & $item));

    if (count($Errors) == 0) {
        try {
            $item->settings_array = $data;
            $item->settings = json_encode($data);
            $item->saveThis();

            if (!isset($_POST['Update_action'])) {
                erLhcoreClassModule::redirect('mattermost/listoptions');
                exit ;
            } else {
                $tpl->set('updated',true);
            }

        } catch (Exception $e) {
            $tpl->set('errors',array($e->getMessage()));
        }

    } else {
        $tpl->set('errors',$Errors);
    }
}

$tpl->set('data', $data);

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('mattermost/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost', 'Mattermost')
    ),
    array(
        'url' => erLhcoreClassDesign::baseurl('mattermost/listoptions'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost', 'Integration per department')
    ),
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost', 'Edit')
    )
);


?>