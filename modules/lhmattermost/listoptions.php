<?php

$tpl = erLhcoreClassTemplate::getInstance('lhmattermost/listoptions.tpl.php');

if (isset($_GET['doSearch'])) {
    $filterParams = erLhcoreClassSearchHandler::getParams(array('customfilterfile' => 'extension/mattermost/classes/filter.php','format_filter' => true, 'use_override' => true, 'uparams' => $Params['user_parameters_unordered']));
    $filterParams['is_search'] = true;
} else {
    $filterParams = erLhcoreClassSearchHandler::getParams(array('customfilterfile' => 'extension/mattermost/classes/filter.php','format_filter' => true, 'uparams' => $Params['user_parameters_unordered']));
    $filterParams['is_search'] = false;
}

$append = erLhcoreClassSearchHandler::getURLAppendFromInput($filterParams['input_form']);

$pages = new lhPaginator();
$pages->items_total = erLhcoreClassModelMattermostSetting::getCount($filterParams['filter']);
$pages->translationContext = 'chat/activechats';
$pages->serverURL = erLhcoreClassDesign::baseurl('mattermost/listoptions').$append;
$pages->paginate();
$tpl->set('pages',$pages);

if ($pages->items_total > 0) {
    $items = erLhcoreClassModelMattermostSetting::getList(array_merge(array('limit' => $pages->items_per_page, 'offset' => $pages->low),$filterParams['filter']));
    $tpl->set('items',$items);
}

$filterParams['input_form']->form_action = erLhcoreClassDesign::baseurl('mattermost/listoptions');
$tpl->set('input',$filterParams['input_form']);
$tpl->set('inputAppend',$append);

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('mattermost/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost', 'Mattermost')
    ),
    array(
        'url' => erLhcoreClassDesign::baseurl('mattermost/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost', 'Integration per department')
    )
);

?>