<?php

use \Gnello\Mattermost\Driver;
#[\AllowDynamicProperties]
class erLhcoreClassMattermostValidator
{
    public static function validateSettings(& $data, $params = array())
    {
            $definition = array(
                'username' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ),
                'host' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ),
                'password' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ),
                'team_id' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ),
                'channel_id' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ),
                'channel_name' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ),
                'msg_request' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ),
                'intro_header' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ),
                'intro_request' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ),
                'channel_chat_name' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ),
                'enabled' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'boolean'
                ),
                'all_departments' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'boolean'
                ),
                'delete_after' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'int'
                ),
                'user_departments' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'int', null, FILTER_REQUIRE_ARRAY
                ),
                'user_departments_groups' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'int', null, FILTER_REQUIRE_ARRAY
                ),
                'user_groups' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'int', null, FILTER_REQUIRE_ARRAY
                ),
                'active' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'boolean'
                ),
                'dep_id' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'int', array('min_range' => 1)
                ),
            );

            $form = new ezcInputForm( INPUT_POST, $definition );
            $Errors = array();

            if ( $form->hasValidData( 'username' ) && $form->username != '')
            {
                $data['username'] = $form->username;
            } else {
                $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Please enter a username!');
            }

            if (isset($params['per_department']) && $params['per_department'] == true) {

                if ($form->hasValidData('active') && $form->active == true) {
                    $params['item']->active = 1;
                } else {
                    $params['item']->active = 0;
                }

                if ($form->hasValidData('dep_id')) {
                    $params['item']->dep_id = $form->dep_id;
                } else {
                    $Errors[] = erTranslationClassLhTranslation::getInstance()->getTranslation('xmppservice/operatorvalidator', 'Please choose a department!');
                }

            }

            if ( $form->hasValidData( 'host' ) && $form->host != '')
            {
                $data['host'] = $form->host;
            } else {
                $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Please enter a host!');
            }

            if ( $form->hasValidData( 'delete_after' ) )
            {
                $data['delete_after'] = $form->delete_after;
            } else {
                $data['delete_after'] = 0;
            }

            if ( $form->hasValidData( 'channel_id' ))
            {
                $data['channel_id'] = $form->channel_id;
            }

            if ( $form->hasValidData( 'msg_request' ))
            {
                $data['msg_request'] = $form->msg_request;
            } else {
                $data['msg_request'] = '';
            }

            if ( $form->hasValidData( 'channel_chat_name' ))
            {
                $data['channel_chat_name'] = $form->channel_chat_name;
            } else {
                $data['channel_chat_name'] = '';
            }

            if ( $form->hasValidData( 'intro_header' ))
            {
                $data['intro_header'] = $form->intro_header;
            } else {
                $data['intro_header'] = '';
            }

            if ( $form->hasValidData( 'intro_request' ))
            {
                $data['intro_request'] = $form->intro_request;
            } else {
                $data['intro_request'] = '';
            }

            if ( $form->hasValidData( 'user_departments' ))
            {
                $data['user_departments'] = $form->user_departments;
            }

            if ( $form->hasValidData( 'user_departments_groups' ))
            {
                $data['user_departments_groups'] = $form->user_departments_groups;
            }

            if ( $form->hasValidData( 'user_groups' ))
            {
                $data['user_groups'] = $form->user_groups;
            }

            if ( $form->hasValidData( 'channel_name' ))
            {
                $data['channel_name'] = $form->channel_name;
            }

            if ( $form->hasValidData( 'team_id' ) && $form->team_id != '')
            {
                $teamId = explode('___',$form->team_id);
                $data['team_id'] = $teamId[0];
                $data['team_name'] = $teamId[1];
            }

            if ( $form->hasValidData( 'enabled' ) && $form->enabled == true)
            {
                $data['enabled'] = true;
            } else {
                $data['enabled'] = false;
            }

            if ( $form->hasValidData( 'all_departments' ) && $form->all_departments == true)
            {
                $data['all_departments'] = true;
            } else {
                $data['all_departments'] = false;
            }

            if ( $form->hasValidData( 'password' ) && $form->password != '')
            {
                $data['password'] = $form->password;
            } else {
                $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Please enter a password!');
            }

            return $Errors;
    }

    public static function getTeams($params = array())
    {

        $driver = self::getDriver($params);

        $resp = $driver->getTeamModel()->getTeams([
            "page" => 0,
            "per_page" => 200,
            "include_total_count" => false,
        ]);

        if ($resp->getStatusCode() == 200) {
            return json_decode($resp->getBody(), true);
        } else {
            throw new Exception('We could not fetch a teams!');
        }

        return array();
    }

    public static function getDriver($params = array())
    {
        static $driverInstance = null;

        if ($driverInstance !== null) {
            return $driverInstance;
        }

        if (isset($params['chat'])) {
            $settingsPerDepartment = erLhcoreClassModelMattermostSetting::findOne(array('filter' => array('dep_id' => $params['chat']->dep_id)));
        } elseif (isset($params['item']) && $params['item'] instanceof erLhcoreClassModelMattermostSetting) {
            $settingsPerDepartment = $params['item'];
        } else {
            $settingsPerDepartment = null;
        }

        if ($settingsPerDepartment instanceof erLhcoreClassModelMattermostSetting) {
            $data = $settingsPerDepartment->settings_array;
        } else {
            $osTicketOptions = erLhcoreClassModelChatConfig::fetch('mattermost_options');
            $data = (array) $osTicketOptions->data;
        }

        include_once 'extension/mattermost/vendor/autoload.php';

        $container = new \Pimple\Container([
            "driver" => [
                'scheme' => (strpos($data['host'],'http://') !== false ? 'http' : 'https'),
                "url" => str_replace(array('http://','https://'),'',$data['host']),
                "login_id" => $data['username'],
                "password" => $data['password'],
            ]
        ]);

        $driverInstance = new Driver($container);
        $driverInstance->authenticate();

        return $driverInstance;
    }

    public static function login($params, $paramsExecution = array()) {

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode(array('login_id' => $params['username'], 'password' => $params['password'])));
        curl_setopt($ch, CURLOPT_URL, rtrim($params['host'],'/') . '/api/v4/users/login');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  array('Accept' => 'application/json'));
        @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $content = json_decode(curl_exec($ch), true);

        if (curl_errno($ch)) {
            $http_error = curl_error($ch);
        }

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpcode == 200) {
            if (isset($content['id']) && !empty($content['id'])) {

                if (isset($paramsExecution['item']) && $paramsExecution['item'] instanceof erLhcoreClassModelMattermostSetting) {

                    $data = $paramsExecution['item']->settings_array;
                    $data['user_id'] = $content['id'];

                    $paramsExecution['item']->settings_array = $data;
                    $paramsExecution['item']->settings = json_encode($data);

                    if ($paramsExecution['item']->id > 0) {
                        $paramsExecution['item']->saveThis();
                    }

                } else {
                    $osTicketOptions = erLhcoreClassModelChatConfig::fetch('mattermost_options');
                    $data = (array) $osTicketOptions->data;
                    $data['user_id'] = $content['id'];
                    $osTicketOptions->value = serialize($data);
                    $osTicketOptions->saveThis();
                }

            } else {
                throw new Exception(erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Authenticated user id could not be found!'));
            }
        } else {
            throw new Exception(erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Invalid response. Please check your logins!'));
        }
    }

    public static function chatClosed($params)
    {
        $params['msg'] = new stdClass();
        $params['msg']->msg = erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Chat was closed!');

        self::explicitlyClosed($params);
    }

    public static function explicitlyClosed($params)
    {
        $chat = $params['chat'];

        $variablesArray = $chat->chat_variables_array;

        if (isset($variablesArray['mm_ch_id'])) {

            $driver = self::getDriver(array('chat' => $chat));

            $resp = $driver->getPostModel()->createPost([
                "channel_id" => $variablesArray['mm_ch_id'],
                "message" => '***' . erLhcoreClassBBCodePlain::make_clickable((isset($params['msg']) && is_object($params['msg']) ? $params['msg']->msg : erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Chat was close by the visitor!')) . '***', array('sender' => 0)),
            ]);

            if ($resp->getStatusCode() != 201) {
                throw new Exception('Message could not be send to Mattermost!');
            }

        }
    }

    public static function messageSendByUser($params)
    {
        // Ignore our own callback
        if ($params['lhc_caller']['function'] == 'processMattermostMessage' && $params['lhc_caller']['class'] == 'erLhcoreClassMattermostValidator')
        {
            return;
        }

        $chat = $params['chat'];

        $variablesArray = $chat->chat_variables_array;

        if (isset($variablesArray['mm_ch_id'])) {

            $driver = self::getDriver(array('chat' => $chat));

            $resp = $driver->getPostModel()->createPost([
                "channel_id" => $variablesArray['mm_ch_id'],
                "message" =>
                    (($params['msg']->user_id > 0) ? '***'.$params['msg']->name_support .'***: ' : '') . erLhcoreClassBBCodePlain::make_clickable($params['msg']->msg, array('sender' => 0))
            ]);

            if ($resp->getStatusCode() != 201) {
                throw new Exception('Message could not be send to Mattermost!');
            }
        }
    }

    public static function getOperatorByMatterMostUserId($userId, $params = array())
    {
        $mmUser = erLhcoreClassModelMattermostUser::findOne(['filter' => ['mm_user_id' => $userId]]);

        if ($mmUser instanceof erLhcoreClassModelMattermostUser) {
            $user = erLhcoreClassModelUser::fetch($mmUser->lhc_user_id);
            if ($user instanceof erLhcoreClassModelUser) {
                return $user;
            }
        }

        $settingsPerDepartment = null;

        if (isset($params['chat'])) {
            $settingsPerDepartment = erLhcoreClassModelMattermostSetting::findOne(array('filter' => array('dep_id' => $params['chat']->dep_id)));
        }

        if ($settingsPerDepartment instanceof erLhcoreClassModelMattermostSetting) {
            $data = $settingsPerDepartment->settings_array;
        } else {
            $osTicketOptions = erLhcoreClassModelChatConfig::fetch('mattermost_options');
            $data = (array) $osTicketOptions->data;
        }

        $driver = self::getDriver($params);

        $resp = $driver->getUserModel()->getUser($userId);

        if ($resp->getStatusCode() == 200) {
            $userData = json_decode($resp->getBody(), true);

            $user = new erLhcoreClassModelUser();
            $user->all_departments = isset($data['all_departments']) && $data['all_departments'] == true ? 1 : 0;
            $user->chat_nickname = (string)$userData['nickname'];
            $user->email = (string)$userData['email'];
            $user->username = 'mm_'.(string)$userData['username'];
            $user->name = (string)$userData['first_name'];
            $user->surname = (string)$userData['last_name'];
            $user->setPassword(erLhcoreClassModelForgotPassword::randomPassword(40));
            $user->saveThis();

            if ($user->all_departments == 1) {
                if (!isset($data['user_departments'])) {
                    $data['user_departments'] = [];
                }
                $data['user_departments'][] = 0;
            }

            if (isset($data['user_departments']) && !empty($data['user_departments'])) {
                erLhcoreClassUserDep::addUserDepartaments($data['user_departments'], $user->id, $user, []);
            }

            if (isset($data['user_departments_groups']) && !empty($data['user_departments_groups'])) {
                erLhcoreClassModelDepartamentGroupUser::addUserDepartmentGroups($user, $data['user_departments_groups']);
            }

            foreach ($data['user_groups'] as $group_id){
                $groupUser = new erLhcoreClassModelGroupUser();
                $groupUser->group_id = $group_id;
                $groupUser->user_id = $user->id;
                $groupUser->saveThis();
            }

            $user->departments_ids = implode(',', isset($data['user_departments']) ? $data['user_departments'] : []);
            $user->updateThis();

            // Save user mapping
            $mmUser = new erLhcoreClassModelMattermostUser();
            $mmUser->lhc_user_id = $user->id;
            $mmUser->mm_user_id = $userId;
            $mmUser->saveThis();

            return $user;
        } else {
            throw new Exception('Operator could not be fetched from Mattermost');
        }

    }

    public static function processAcceptChat($chat, $payload)
    {

        $settingsPerDepartment = erLhcoreClassModelMattermostSetting::findOne(array('filter' => array('dep_id' => $chat->dep_id)));

        if ($settingsPerDepartment instanceof erLhcoreClassModelMattermostSetting){
            $data = $settingsPerDepartment->settings_array;
        } else {
            $osTicketOptions = erLhcoreClassModelChatConfig::fetch('mattermost_options');
            $data = (array) $osTicketOptions->data;
        }

        $driver = self::getDriver(array('chat' => $chat));

        $chatVariables = $chat->chat_variables_array;

        // Add operator to chat channel who has accepted a chat
        $driver->getChannelModel()->addUser($chatVariables['mm_ch_id'], ['user_id' => $payload['user_id']]);

        $operator = self::getOperatorByMatterMostUserId($payload['user_id'], array('chat' => $chat));

        // Login operator
        erLhcoreClassUser::instance()->setLoggedUser($operator->id);

        $operatorAccepted = false;
        $chatDataChanged = false;

        if ($chat->user_id == 0 && $chat->status != erLhcoreClassModelChat::STATUS_BOT_CHAT && $chat->status != erLhcoreClassModelChat::STATUS_CLOSED_CHAT) {
            $chat->user_id = $operator->id;
            $chat->status_sub = erLhcoreClassModelChat::STATUS_SUB_OWNER_CHANGED;
            $chatDataChanged = true;
        }

        // If status is pending change status to active
        if ($chat->status == erLhcoreClassModelChat::STATUS_PENDING_CHAT) {
            $chat->status = erLhcoreClassModelChat::STATUS_ACTIVE_CHAT;

            $chat->wait_time = time() - ($chat->pnd_time > 0 ? $chat->pnd_time : $chat->time);
            $chat->user_id = $operator->id;

            $chat->status_sub = erLhcoreClassModelChat::STATUS_SUB_OWNER_CHANGED;

            // User status in event of chat acceptance
            $chat->usaccept = $operator->hide_online;

            $operatorAccepted = true;
            $chatDataChanged = true;
        }

        // Check does chat transfer record exists if operator opened chat directly
        if ($chat->transfer_uid > 0) {
            erLhcoreClassTransfer::handleTransferredChatOpen($chat, $operator->id);
        }

        if ($chat->support_informed == 0 || $chat->has_unread_messages == 1 ||  $chat->unread_messages_informed == 1) {
            $chatDataChanged = true;
        }

        // Store who has acceped a chat so other operators will be able easily indicate this
        if ($operatorAccepted == true) {

            $msg = new erLhcoreClassModelmsg();
            $msg->name_support = $operator->name_support;

            erLhcoreClassChatEventDispatcher::getInstance()->dispatch('chat.before_msg_admin_saved', array('msg' => & $msg, 'chat' => & $chat, 'user_id' => $operator->id));

            $msg->msg = (string)$msg->name_support.' '.erTranslationClassLhTranslation::getInstance()->getTranslation('chat/adminchat','has accepted the chat!');
            $msg->chat_id = $chat->id;
            $msg->user_id = -1;
            $msg->time = time();

            if ($chat->last_msg_id < $msg->id) {
                $chat->last_msg_id = $msg->id;
            }

            erLhcoreClassChat::getSession()->save($msg);
        }

        // Update general chat attributes
        if ($chat->user_id == $operator->id) {
            $chat->support_informed = 1;
            $chat->has_unread_messages = 0;
            $chat->unread_messages_informed = 0;
        }

        if ($chat->unanswered_chat == 1 && ($chat->user_status_front == 0 || $chat->user_status_front == 2))
        {
            $chat->unanswered_chat = 0;
        }

        if ($chatDataChanged == true) {
            erLhcoreClassChatEventDispatcher::getInstance()->dispatch('chat.data_changed',array('chat' => & $chat, 'user' => erLhcoreClassUser::instance()));
        }

        if ($operatorAccepted == true) {
            erLhcoreClassChatEventDispatcher::getInstance()->dispatch('chat.accept',array('chat' => & $chat,'user' => erLhcoreClassUser::instance()));
            erLhcoreClassChat::updateActiveChats($chat->user_id);

            if ($chat->department !== false) {
                erLhcoreClassChat::updateDepartmentStats($chat->department);
            }

            if ($chat->auto_responder !== false) {
                $chat->auto_responder->chat = $chat;
                $chat->auto_responder->processAccept();
            }

            erLhcoreClassChatWorkflow::presendCannedMsg($chat);
            $options = $chat->department->inform_options_array;
            erLhcoreClassChatWorkflow::chatAcceptedWorkflow(array('department' => $chat->department, 'options' => $options),$chat);

            // Just update if some extension modified data and forgot to update.
            // Also this is solving strange issue after chat assignment it's assignment got reset.
            // So this should help if not we will need something more.
            $chat->updateThis();
        };

        return array(
            'operator' => $operator->name_support,
            'url' =>  $data['host'] . '/' . $data['team_name'] . '/channels/lhc-' . $chat->id,
        );

    }

    public static function replaceVariables($string, $params)
    {
        $string = str_replace(array(
            '{department}',
            '{phone}',
            '{time_created_front}',
            '{additional_data}',
            '{id}',
            '{url}',
            '{referrer}',
            '{messages}',
            '{remarks}',
            '{nick}',
            '{email}',
            '{country_code}',
            '{country_name}',
            '{city}',
            '{user_tz_identifier}'
        ), array(
            (string)$params['chat']->department,
            (string)$params['chat']->phone,
            date(erLhcoreClassModule::$dateDateHourFormat,$params['chat']->time),
            $params['chat']->additional_data,
            $params['chat']->id,
            (erLhcoreClassSystem::$httpsMode == true ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . erLhcoreClassDesign::baseurl('user/login') . '/(r)/' . rawurlencode(base64_encode('chat/single/' . $params['chat']->id)),
            $params['chat']->referrer,
            $params['msg'],
            $params['chat']->remarks,
            $params['chat']->nick,
            $params['chat']->email,
            $params['chat']->country_code,
            $params['chat']->country_name,
            $params['chat']->city,
            $params['chat']->user_tz_identifier
        ), $string);

        $string = erLhcoreClassGenericBotWorkflow::translateMessage($string, array('chat' => $params['chat'], 'args' => []));

        return $string;

    }


    public static function createChat($params)
    {
        // Chat is in bot mode so just ignore it.
        if ($params['chat']->status == erLhcoreClassModelChat::STATUS_BOT_CHAT) {
            return;
        }

        $settingsPerDepartment = erLhcoreClassModelMattermostSetting::findOne(array('filter' => array('dep_id' => $params['chat']->dep_id)));

        if ($settingsPerDepartment instanceof erLhcoreClassModelMattermostSetting){
            $data = $settingsPerDepartment->settings_array;
        } else {
            $osTicketOptions = erLhcoreClassModelChatConfig::fetch('mattermost_options');
            $data = (array) $osTicketOptions->data;

            // Check is extension enabled
            if ($data['enabled'] !== true) {
                return null;
            }
        }

        $driver = self::getDriver($params);

        $messagesContent = (is_object($params['msg']) && $params['msg']->msg != '') ? $params['msg']->msg : '';

        $intro = self::replaceVariables($data['intro_header'], ['chat' => $params['chat'], 'msg' => $messagesContent]);
        $intro_request = self::replaceVariables($data['intro_request'], ['chat' => $params['chat'], 'msg' => $messagesContent]);
        $msg_initial = self::replaceVariables($data['msg_request'], ['chat' => $params['chat'], 'msg' => erLhcoreClassBBCodePlain::make_clickable($messagesContent, array('sender' => 0))]);
        $channel_chat_name = self::replaceVariables($data['channel_chat_name'], ['chat' => $params['chat'], 'msg' => erLhcoreClassBBCodePlain::make_clickable($messagesContent, array('sender' => 0))]);

        if (empty($channel_chat_name)) {
            $channel_chat_name = ($params['chat']->nick != 'Visitor' ?  ($params['chat']->nick.', ' . date('Y-m-d H:i:s') ) : ('ID' . $params['chat']->id. ', ' . date('Y-m-d H:i:s')));
        }

        $resp = $driver->getChannelModel()->createChannel([
            "team_id" => $data['team_id'],
            "name" => 'lhc-' . $params['chat']->id,
            "display_name" => $channel_chat_name,
            "header" => $intro,
            "type" => 'O'
        ]);

        if ($resp->getStatusCode() == 201) {

            $channel = json_decode($resp->getBody(), true);

            // Store channel ID
            $chatVariables = $params['chat']->chat_variables_array;
            $chatVariables['mm_ch_id'] = $channel['id'];

            // Create a notification in main chat channel
            $driver->getPostModel()->createPost([
                "channel_id" => $data['channel_id'],
                "props" => [
                    'attachments' => [
                        [
                            "pretext" => $intro_request,
                            "text" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','To accept a chat click accept'),
                            'actions' => [
                                [
                                    'action_id' => 'update',
                                    'name' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Accept a chat'),
                                    'integration' => [
                                        'url' => erLhcoreClassXMP::getBaseHost() . $_SERVER['HTTP_HOST'] . erLhcoreClassDesign::baseurldirect('mattermost/callbackbutton') . '/' . $params['chat']->id . '/' . $params['chat']->hash,
                                        'context' => [
                                            'action' => 'accept_chat_' . $params['chat']->id
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]);

            // Send original message to the chat
            $driver->getPostModel()->createPost([
                "channel_id" => $channel['id'],
                "message" => $msg_initial,
            ]);


            // Create outgoing webhook
            $resp = $driver->getWebhookModel()->createOutgoingWebhook([
                'team_id' => $data['team_id'],
                'display_name' => 'Chat ID - ' . $params['chat']->id,
                'channel_id' => $channel['id'],
                'content_type' => 'application/json',
                'callback_urls' => [
                    erLhcoreClassXMP::getBaseHost() . $_SERVER['HTTP_HOST'] . erLhcoreClassDesign::baseurldirect('mattermost/callback') . '/' . $params['chat']->id . '/' . $params['chat']->hash
                ]
            ]);

            if ($resp->getStatusCode() == 201) {
                $webhook = json_decode($resp->getBody(), true);
                $chatVariables['mm_wh_id'] = $webhook['id'];
            } else {
                throw new Exception('Webhook could not be created!');
            }

            // Save related chat data
            $params['chat']->chat_variables = json_encode($chatVariables);
            $params['chat']->updateThis(array('update' => array('chat_variables')));

            $mmChat = new erLhcoreClassModelMattermostChat();
            $mmChat->ctime = time();
            $mmChat->chat_id = $params['chat']->id;
            $mmChat->mm_ch_id = $channel['id'];
            $mmChat->saveThis();

        } else {
            throw new Exception('Chat could not be created in mattermost. Please check your integration!');
        }
    }

    public static function suggestChannel($teamID, $query, $item = null)
    {
        $driver = self::getDriver(array('item' => $item));

        $resp = $driver->getChannelModel()->autocompleteChannels($teamID, [
            "name" => $query,
        ]);

        if ($resp->getStatusCode() == 200) {
            return json_decode($resp->getBody(), true);
        } else {
            throw new Exception('We could not retrieve a channel!');
        }

        return [];
    }

    public static function processMattermostMessage($chat, $payload)
    {

        $settingsPerDepartment = erLhcoreClassModelMattermostSetting::findOne(array('filter' => array('dep_id' => $chat->dep_id)));

        if ($settingsPerDepartment instanceof erLhcoreClassModelMattermostSetting){
            $data = $settingsPerDepartment->settings_array;
        } else {
            $osTicketOptions = erLhcoreClassModelChatConfig::fetch('mattermost_options');
            $data = (array)$osTicketOptions->data;
        }


        // Ignore our own messages send to a channel
        if ($payload['user_id'] == $data['user_id']) {
            return;
        }

        $operator = self::getOperatorByMatterMostUserId($payload['user_id'], array('chat' => $chat));

        if ($chat->status == erLhcoreClassModelChat::STATUS_PENDING_CHAT) {
            $chat->status = erLhcoreClassModelChat::STATUS_ACTIVE_CHAT;
            $chat->status_sub = erLhcoreClassModelChat::STATUS_SUB_OWNER_CHANGED;
            $chat->user_id = $operator->id;
        }

        $msgText = trim($payload['text']);
        $messageUserId = $operator->id;

        $ignoreMessage = false;

        if (strpos($msgText, '!') === 0) {
            $statusCommand = erLhcoreClassChatCommand::processCommand(array('no_ui_update' => true, 'user' => $operator, 'msg' => $msgText, 'chat' => & $chat));
            if ($statusCommand['processed'] === true) {
                $messageUserId = -1; // Message was processed set as internal message

                $rawMessage = !isset($statusCommand['raw_message']) ? $msgText : $statusCommand['raw_message'];

                $msgText = trim($rawMessage .' '. ($statusCommand['process_status'] != '' ? '|| '.$statusCommand['process_status'] : ''));

                if (isset($statusCommand['ignore']) && $statusCommand['ignore'] == true) {
                    $ignoreMessage = true;
                }

                if (isset($statusCommand['info'])) {
                    $msgText .= $statusCommand['info'];
                }

                $msg = new erLhcoreClassModelmsg();
                $msg->user_id = $operator->id;
                $msg->msg = $msgText;
                $msg->name_support = $operator->name_support;

                self::messageSendByUser(array('chat' => $chat, 'msg' => $msg));
            }
        }

        if ($ignoreMessage == false) {

            // Save message
            $msg = new erLhcoreClassModelmsg();
            $msg->msg = $msgText;
            $msg->chat_id = $chat->id;
            $msg->user_id = $messageUserId;
            $msg->time = time();
            $msg->name_support = $payload['user_name'];

            if (!empty($payload['file_ids'])) {
                $files = explode(',', $payload['file_ids']);

                $driver = self::getDriver(array('chat' => $chat));

                foreach ($files as $fileId) {
                    $resp = $driver->getFileModel()->getMetadataForFile($fileId);
                    if ($resp->getStatusCode() == 200) {
                        $linkData = json_decode($resp->getBody(), true);
                        $msg->msg .= "\n" . '[url=' . erLhcoreClassXMP::getBaseHost() . $_SERVER['HTTP_HOST'] . erLhcoreClassDesign::baseurldirect('mattermost/download') . '/' . $chat->id . '/' . $chat->hash . '/' . $fileId . ']' . $linkData['name'] . '[/url]';
                    }
                }

                $msg->msg = trim($msg->msg);
            }

            erLhcoreClassChatEventDispatcher::getInstance()->dispatch('chat.before_msg_admin_saved', array('msg' => & $msg, 'chat' => & $chat));

            $msg->saveThis();

            // Update chat
            $chat->last_msg_id = $msg->id;
            $chat->last_op_msg_time = time();
            $chat->has_unread_op_messages = 1;
            $chat->unread_op_messages_informed = 0;
        }

        $chat->updateThis(array('update' => array('status','status_sub','user_id','last_msg_id','last_op_msg_time','has_unread_op_messages','unread_op_messages_informed')));

        erLhcoreClassChatEventDispatcher::getInstance()->dispatch('chat.web_add_msg_admin', array('msg' => & $msg, 'chat' => & $chat));
    }

}