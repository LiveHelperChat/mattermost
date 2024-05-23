This extension allow making conversations directly on [Mattermost](https://mattermost.com/) platform without touching Live Helper Chat back office completely.

Mattermost is a [Slack](https://slack.com/), [Rocket.Chat](https://rocket.chat/) alternative.

## Requirements

Min 3.62v Live Helper Chat version.

Youtube video can be found here https://youtu.be/MnJHuHXbiXY

![See image](https://raw.githubusercontent.com/LiveHelperChat/mattermost/main/doc/screenshot.png)

## How it works

1. customer requests a chat from your website
2. Live Helper Chat will send a message into a specified channel with a button to accept this chat request
3. One operator will click the button to accept the request (the message now disappears)
4. Live Helper Chat will now create a new channel for this chat and invites the operator
5. All messages from the customer will appear in this new channel and all messages from the operator will apear to the customer on your website, even files can be made aviable for the customer or for the operator
6. (optional) The Channel will be deleted after a given amount of time after the chat has been completed. All chats are still aviable in Live Helper Chat Backoffice for the manager

## Install instructions for Mattermost part

1. I would suggest creating a new team dedicated just for your customers.
2. Create a user under which Live Helper Chat will be sending messages, creating channels and webhooks. It should be a user with admin permissions.
3. Create one channel in this group where live chat request will appear.
4. Invite few operators to this group.

## Install instructions for Live Helper Chat

1. Clone github repository
2. Move `mattermost` directory in extension/ directory
3. Activate extension in main Live Helper Chat settings file `lhc_web/settings/settings.ini.php` file
``` 
'extensions' => 
    array (          
        'mattermost'
    ),
```
4. Modify main [`composer.json`](https://github.com/LiveHelperChat/livehelperchat/blob/master/lhc_web/composer.json#L50) file under `lhc_web` folder and add 
``` 
"require": {
    ...
    "gnello/php-mattermost-driver": "dev-master#e4ba6c4db5de05a1ca8685ed54adf8ab13afb448"
},
``` 
5. Update composer dependencies by executing `composer install` from `lhc_web` folder
6. Clean cache. Just click clean cache in Live Helper Chat back office.
7. Execute doc/install.sql on database manager or just run. You will have to wait 10 seconds for queries to be executed.
    ```
    php cron.php -s site_admin -e mattermost -c cron/update_structure
    ```
8. Navigate to back office of Live Helper Chat, under module you will find `Mattermost` section.
9. To delete old Mattermost chats you should be having this cronjob
    ```
    php cron.php -s site_admin -e mattermost -c cron/archive
    ```

## Troubleshooting

* Check mattermost server for an error
* Check cache/default.log for an error in Live Helper Chat
* Check audit log in Live Helper Chat back office

## Tips

### Staying online

Because most of the time you won't be logged to Live Helper Chat back office, system won't know are you online or not. To avoid the offline widget you can set up

* [Department online hours](https://doc.livehelperchat.com/docs/department/department/#automate-online-hours)

### Permanently delete old chats

For Mattermost to remove completely old chats instead of soft deletes. Mattermost has to have configured permanent deletion. Otherwise you will encounter issue [#7](https://github.com/LiveHelperChat/mattermost/issues/7)

https://docs.mattermost.com/administration/config-settings.html#enable-api-channel-deletion

### Disable reopening old chats

Make sure you have disabled re-opening old chats. https://doc.livehelperchat.com/docs/chat/configuration#reopen-chat-functionality-enabled

Read issue [#8](https://github.com/LiveHelperChat/mattermost/issues/8)
