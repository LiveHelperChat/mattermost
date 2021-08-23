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
            'erLhcoreClassModelMattermostUser' => 'extension/mattermost/classes/erlhcoreclassmodelmmuser.php',
            'erLhcoreClassModelMattermostSetting' => 'extension/mattermost/classes/erlhcoreclassmodelmmsetting.php'
        );

        if (key_exists ( $className, $classesArray )) {
            include_once $classesArray [$className];
        }
    }

    public function botTransfer($params) {
        if (isset($params['action']['content']['command']) && $params['action']['content']['command'] == 'stopchat' && isset($params['is_online']) && $params['is_online'] == true) {
            try {
                erLhcoreClassMattermostValidator::createChat(array('chat' => $params['chat']));
            } catch (Exception $e) {
                self::logError($e);
            }
        }
    }

    public function chatCreated($params)
    {
        try {
            erLhcoreClassMattermostValidator::createChat($params);
        } catch (Exception $e) {
            self::logError($e);
        }
    }

    public function messageAdded($params)
    {
        try {
            erLhcoreClassMattermostValidator::messageSendByUser($params);
        } catch (Exception $e) {
            self::logError($e);
        }
    }

    public function explicitlyClosed($params)
    {
        try {
            erLhcoreClassMattermostValidator::explicitlyClosed($params);
        } catch (Exception $e) {
            self::logError($e);
        }
    }

    public function chatClosed($params)
    {
        try {
            erLhcoreClassMattermostValidator::chatClosed($params);
        } catch (Exception $e) {
            self::logError($e);
        }
    }

    public function logError($e) {
        erLhcoreClassLog::write($e->getMessage() . '|' . $e->getTraceAsString(),
            ezcLog::SUCCESS_AUDIT,
            array(
                'source' => 'mm',
                'category' => 'mm',
                'line' => __LINE__,
                'file' => __FILE__,
                'object_id' => 0
            )
        );
    }
}