<?php $mattermost_module_enabled_pre = true;?>

<?php if ($mattermost_module_enabled_pre === false) : $errors[] = 'Module not supported'; ?>
<?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
<?php return; endif; ?>

<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Settings')?></h1>

<?php if (isset($errors)) : ?>
	<?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
<?php endif; ?>

<?php if (isset($updated) && $updated == true) : $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Settings updated'); ?>
	<?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
<?php endif; ?>

<form action="" method="post" ng-non-bindable autocomplete="off">

    <?php include(erLhcoreClassDesign::designtpl('lhmattermost/form/form.tpl.php'));?>

    <div class="btn-group" role="group" aria-label="...">
        <input type="submit" name="Update" class="btn btn-primary" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost','Save settings');?>">
    </div>


</form>
