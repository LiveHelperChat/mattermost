This extension allow making conversations directly on [Mattermost](https://mattermost.com/) platform without touching Live Helper Chat back office completely.

## Requirements

Min 3.62v Live Helper Chat version.

Youtube tutorial should be done in a few days. Thank you for patient :)

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
4. Install composer requirements with. You have to download composer or just have it installed already.
``` 
cd extension/mattermost && composer.phar install
``` 
5. Clean cache. Just click clean cache in Live Helper Chat back office.
6. Execute doc/install.sql on database manager or just run. You will have to wait 10 seconds for queries to be executed.
    ```
    php cron.php -s site_admin -e mattermost -c cron/update_structure
    ```
7. Navigate to back office of Live Helper Chat, under module you will find `Mattermost` section.
8. To delete old Mattermost chats you should be having this cronjob
    ```
    php cron.php -s site_admin -e mattermost -c cron/archive
    ```