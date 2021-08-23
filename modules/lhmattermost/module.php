<?php

$Module = array( "name" => "Mattermost",
				 'variable_params' => true );

$ViewList = array();

$ViewList['index'] = array(
    'params' => array(),
    'functions' => array('manage')
);

$ViewList['callback'] = array(
    'params' => array('id')
);

$ViewList['download'] = array(
    'params' => array('id','hash','file_id')
);

$ViewList['callbackbutton'] = array(
    'params' => array('id')
);

$ViewList['searchchannel'] = array(
    'params' => array(),
    'functions' => array('manage')
);

$ViewList['settings'] = array(
    'params' => array(),
    'functions' => array('manage')
);

$ViewList['listoptions'] = array(
    'params' => array(),
    'functions' => array('manage')
);

$ViewList['newoption'] = array(
    'params' => array(),
    'functions' => array('manage')
);

$ViewList['editoption'] = array(
    'params' => array('id'),
    'functions' => array('manage')
);

$ViewList['deleteoption'] = array(
    'params' => array('id'),
    'uparams' => array('csfr'),
    'functions' => array('manage')
);

$FunctionList['manage'] = array('explain' => 'Allow operator to manage Mattermost integration');
