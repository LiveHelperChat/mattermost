<?php include(erLhcoreClassDesign::designtpl('lhmattermost/mattermost_enabled_pre.tpl.php')); ?>
<?php if (erLhcoreClassUser::instance()->hasAccessTo('lhmattermost','manage') && $mattermost_module_enabled_pre == true) : ?>
<li class="nav-item"><a class="nav-link" href="<?php echo erLhcoreClassDesign::baseurl('mattermost/index')?>"><i class="material-icons">comment</i><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('pagelayout/pagelayout','Mattermost');?></a></li>
<?php endif;?>
