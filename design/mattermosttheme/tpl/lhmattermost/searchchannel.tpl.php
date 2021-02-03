<div class="py-2">
    <?php foreach ($channels as $channel)  : ?>
        <label><button type="button" onclick='setChannelNotifications(<?php echo json_encode($channel)?>)' class="btn btn-xs btn-info"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','set')?></button> <?php echo htmlspecialchars($channel['display_name'])?></label>
    <?php endforeach; ?>
</div>
