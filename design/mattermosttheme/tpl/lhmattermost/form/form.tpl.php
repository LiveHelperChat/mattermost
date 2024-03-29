<?php if (isset($item) && $item instanceof erLhcoreClassModelMattermostSetting) : ?>
    <div class="form-group">
        <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Department');?>*</label>
        <?php echo erLhcoreClassRenderHelper::renderCombobox(array(
            'input_name'     => 'dep_id',
            'optional_field' => erTranslationClassLhTranslation::getInstance()->getTranslation('chat/lists/search_panel','Select department'),
            'selected_id'    => $item->dep_id,
            'css_class'      => 'form-control',
            'list_function'  => 'erLhcoreClassModelDepartament::getList',
            'list_function_params'  => array(),
        )); ?>
    </div>

    <label><input type="checkbox" value="on" name="active" <?php $item->active == 1 ? print 'checked="checked"' : '' ?> /> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Active configuration')?></label>

<?php endif; ?>

<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Mattermost host');?></label>
    <input type="text" class="form-control" name="host" value="<?php echo isset($data['host']) ? htmlspecialchars($data['host']) : ''?>" />
</div>

<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Username');?></label>
    <input type="text" class="form-control" autocomplete="new-password" placeholder="Username" name="username" value="<?php echo (isset($data['username']) && !empty($data['username'])) ? htmlspecialchars($data['username']) : ''?>" />
</div>

<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Password');?></label>
    <input type="password" class="form-control" autocomplete="new-password" name="password" value="<?php echo (isset($data['password']) && !empty($data['password'])) ? htmlspecialchars($data['password']) : ''?>" />
</div>

<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label><input type="checkbox" value="on" name="enabled" <?php echo isset($data['enabled']) && $data['enabled'] == true ? 'checked="checked"' : '' ?> /> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Enabled extension')?></label>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <input type="text" class="form-control form-control-sm" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','After how many hours delete chats from Mattermost');?>" placeholder="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','After how many hours delete chats from Mattermost');?>" name="delete_after" value="<?php echo (isset($data['delete_after']) && !empty($data['delete_after'])) ? htmlspecialchars($data['delete_after']) : ''?>" />
        </div>
    </div>
</div>

<?php if (isset($data['username']) && isset($data['password']) && isset($data['host'])) :

    try {
        $itemEdit = (isset($item) ? $item : null);
        $loginStatus = erLhcoreClassMattermostValidator::login($data, array('item' => & $itemEdit));
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }

    if (!isset($errorMessage)) :

        $teams = erLhcoreClassMattermostValidator::getTeams(array('item' => (isset($item) ? $item : null))); ?>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Team');?></label>
                    <select name="team_id" id="id_team_id" class="form-control form-control-sm">
                        <option value=""><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Choose a team');?></option>
                        <?php foreach ($teams as $team) : ?>
                            <option <?php if (isset($data['team_id']) && $team['id'] == $data['team_id']) : ?>selected="selected"<?php endif; ?> value="<?php echo htmlspecialchars($team['id'])?>___<?php echo htmlspecialchars($team['name'])?>"><?php echo htmlspecialchars($team['display_name'])?></option>
                        <?php endforeach; ?>
                    </select>
                    <p><small><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','In this team new channels will be created for the visitors chats.');?></small></p>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','In what channel to publish new chat notification');?></label>
                    <input type="text" class="form-control form-control-sm" id="channel-search" placeholder="Start typing to see suggestions" value="" />
                    <div id="channel-result-search"></div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Channel in which notifications will be published');?>:</strong>

            <span id="id_channel_name_display" class="badge bg-info"><?php echo htmlspecialchars(isset($data['channel_name']) ? $data['channel_name'] : '') ?></span>

            <p><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','If you do not find a channel. E.g it is a private channel you can put details there.')?></p>
            <div class="row">
                <div class="col-6">
                    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Channel ID')?></label>
                    <input type="text" id="id_channel_id" class="form-control form-control-sm" name="channel_id" value="<?php isset($data['channel_id']) ? print htmlspecialchars($data['channel_id']) :'' ?>" />
                </div>
                <div class="col-6">
                    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Channel name')?></label>
                    <input type="text" id="id_channel_name" class="form-control form-control-sm" name="channel_name" value="<?php isset($data['channel_name']) ? print htmlspecialchars($data['channel_name']) :'' ?>" />
                </div>
            </div>

        </div>

        <hr class="my-2">
        <h4><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','New operators configuration.');?></h4>
        <div>
            <p><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Configure to what groups and departments operators from Mattermost should be assigned. This will happen when operator accepts a chat for the first time.');?> </p>

            <div class="row">
                <div class="col-6">

                    <h6><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Departments.');?></h6>
                    <div class="row">
                        <div class="col-12">
                            <label><input type="checkbox" value="on" name="all_departments" <?php echo (isset($data['all_departments']) && $data['all_departments'] == 1) ? 'checked="checked"' : '' ?> /> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','All departments')?></label>
                        </div>
                        <div class="col-12">
                            <hr class="my-2">
                        </div>
                        <?php foreach (erLhcoreClassModelDepartament::getList(array('limit' => false, 'filter' => array('archive' => 0))) as $departament) : ?>
                            <div class="col-6">
                                <label><input type="checkbox" name="user_departments[]" value="<?php echo $departament->id?>" <?php echo isset($data['user_departments']) && in_array($departament->id,$data['user_departments']) ? 'checked="checked"' : '';?> />&nbsp;<?php echo htmlspecialchars($departament->name)?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php $departmentsGroups = erLhcoreClassModelDepartamentGroup::getList(array('limit' => false)); ?>
                    <?php if (!empty($departmentsGroups)) : ?>
                        <div class="row">
                            <div class="col-12">
                                <h6><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Departments groups')?></h6>
                            </div>
                            <?php foreach ($departmentsGroups as $departamentGroup) : ?>
                                <div class="col-6"><label><input type="checkbox" name="user_departments_groups[]" value="<?php echo $departamentGroup->id?>" <?php echo isset($data['user_departments_groups']) && in_array($departamentGroup->id,$data['user_departments_groups']) ? ' checked="checked" ' : '';?> />&nbsp;<?php echo htmlspecialchars($departamentGroup->name)?></label></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif;?>

                </div>
                <div class="col-6">

                    <h6><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Choose user group operator should be assigned to.')?></h6>
                    <div class="row">
                        <?php echo erLhcoreClassRenderHelper::renderCheckbox( array (
                            'input_name'     => 'user_groups[]',
                            'selected_id'    => (isset($data['user_groups']) && is_array($data['user_groups']) ? $data['user_groups'] : []),
                            'multiple' 		 => true,
                            'css_class'      => 'form-control',
                            'wrap_prepend'   => '<div class="col-6">',
                            'wrap_append'    => '</div>',
                            'list_function'  => 'erLhcoreClassModelGroup::getList',
                            'list_function_params'  => [],
                            'read_only_list' => []
                        )); ?>
                    </div>

                </div>
            </div>
        </div>

        <script>
            $('#channel-search').keyup(function () {
                var args =  {q: $(this).val(), t: $('#id_team_id').val().split('___')[0] };

                <?php if (isset($item) && $item->id > 0) : ?>
                args.i = <?php echo $item->id;?>;
                <?php endif; ?>

                $.post(WWW_DIR_JAVASCRIPT + 'mattermost/searchchannel', args, function (data) {
                    $('#channel-result-search').html(data);
                });
            });
            function setChannelNotifications(data) {
                $('#id_channel_id').val(data.id);
                $('#id_channel_name').val(data.display_name);
                $('#id_channel_name_display').text(data.display_name);
            }
        </script>
    <?php else : ?>

        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($errorMessage)?>
        </div>

    <?php endif; ?>

<?php endif; ?>

<hr class="my-2">
<h4><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Request messages configuration')?></h4>

<p><small>{department}, {time_created_front}, {additional_data}, {id}, {url}, {referrer}, {messages}, {remarks}, {nick}, {email}, {country_code}, {country_name}, {city}, {user_tz_identifier}</small></p>

<div class="row pb-2">

    <div class="col-12">
        <div class="form-group">
            <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Default channel name, you can use replaceable variables also.')?></label>
            <input type="text" class="form-control" name="channel_chat_name" value="<?php echo isset($data['channel_chat_name']) ? htmlspecialchars($data['channel_chat_name']) : ''?>" />
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Header text for the chat channel')?></label>
            <textarea class="form-control" name="intro_header"><?php echo isset($data['intro_header']) ? htmlspecialchars($data['intro_header']) : ''?></textarea>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Intro text join the chat')?></label>
            <textarea class="form-control" name="intro_request"><?php echo isset($data['intro_request']) ? htmlspecialchars($data['intro_request']) : ''?></textarea>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Initial message to the channel')?></label>
            <textarea class="form-control" name="msg_request"><?php echo isset($data['msg_request']) ? htmlspecialchars($data['msg_request']) : ''?></textarea>
        </div>
    </div>
</div>