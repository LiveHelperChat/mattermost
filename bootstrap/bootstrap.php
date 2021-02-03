<?php

/**
 * Direct integration with Mattermost
 * */
class erLhcoreClassExtensionMattermost
{
    private static $persistentSession;

    public function __construct()
    {
        
    }

    public function run()
    {
        $this->registerAutoload ();
        
        $dispatcher = erLhcoreClassChatEventDispatcher::getInstance();

        $dispatcher->listen('chat.close', array(
            $this,
            'chatClosed'
        ));

        // chat started event
        $dispatcher->listen('chat.chat_started', array(
            $this,
            'chatCreated'
        ));

        $dispatcher->listen('chat.data_changed_auto_assign', array(
            $this,
            'chatStarted'
        ));

        $dispatcher->listen('chat.genericbot_chat_command_transfer', array(
            $this,
            'botTransfer'
        ));

        // @todo send messages to mattermost
        $dispatcher->listen('chat.web_add_msg_admin', array(
            $this,
            'messageAdded'
        ));

        $dispatcher->listen('chat.addmsguser', array(
            $this,
            'messageAdded'
        ));

        $dispatcher->listen('chat.explicitly_closed', array(
            $this,
            'explicitlyClosed'
        ));

    }

    public function registerAutoload() {
        spl_autoload_register ( array (
            $this,
            'autoload'
        ), true, false );
    }

    public static function getSession() {
        if (! isset ( self::$persistentSession )) {
            self::$persistentSession = new ezcPersistentSession ( ezcDbInstance::get (), new ezcPersistentCodeManager ( './extension/mattermost/pos' ) );
        }
        return self::$persistentSession;
    }

    public function autoload($className) {
        $classesArray = array (
            'erLhcoreClassMattermostValidator' => 'extension/mattermost/classes/erlhcoreclassMattermostValidator.php',
            'erLhcoreClassModelMattermostChat' => 'extension/mattermost/classes/erlhcoreclassmodelmmchat.php',
            'erLhcoreClassModelMattermostUser' => 'extension/mattermost/classes/erlhcoreclassmodelmmuser.php'
        );

        if (key_exists ( $className, $classesArray )) {
            include_once $classesArray [$className];
        }
    }

    public function botTransfer($params) {
        if (isset($params['action']['content']['command']) && $params['action']['content']['command'] == 'stopchat' && isset($params['is_online']) && $params['is_online'] == true) {
            erLhcoreClassMattermostValidator::createChat(array('chat' => $params['chat']));
        }
    }

    public function chatCreated($params)
    {
        erLhcoreClassMattermostValidator::createChat($params);
    }

    public static function messageAdded($params)
    {
        erLhcoreClassMattermostValidator::messageSendByUser($params);
    }

    public static function explicitlyClosed($params)
    {
        erLhcoreClassMattermostValidator::explicitlyClosed($params);
    }

    public function chatClosed($params)
    {
        erLhcoreClassMattermostValidator::chatClosed($params);
    }
}