<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Integration per department');?></h1>

<?php if (isset($items)) : ?>

    <table cellpadding="0" cellspacing="0" class="table" width="100%" ng-non-bindable>
        <thead>
        <tr>
            <th width="1%">ID</th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Department');?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Active');?></th>
            <th width="1%"></th>
        </tr>
        </thead>
        <?php foreach ($items as $item) : ?>
            <tr>
                <td><a href="<?php echo erLhcoreClassDesign::baseurl('mattermost/editoption')?>/<?php echo $item->id?>"><?php echo $item->id?></a></td>
                <td><a href="<?php echo erLhcoreClassDesign::baseurl('mattermost/editoption')?>/<?php echo $item->id?>"><?php echo htmlspecialchars($item->dep)?></a></td>
                <td><?php if ($item->active == 1) : ?>Yes<?php else : ?>No<?php endif;?></td>
                <td nowrap>
                    <div class="btn-group" role="group" aria-label="..." style="width:60px;">
                        <a class="btn btn-secondary btn-xs" href="<?php echo erLhcoreClassDesign::baseurl('mattermost/editoption')?>/<?php echo $item->id?>" ><i class="material-icons mr-0">&#xE254;</i></a>
                        <a class="btn btn-danger btn-xs csfr-required" onclick="return confirm('<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('kernel/messages','Are you sure?');?>')" href="<?php echo erLhcoreClassDesign::baseurl('mattermost/deleteoption')?>/<?php echo $item->id?>" ><i class="material-icons mr-0">&#xE872;</i></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php include(erLhcoreClassDesign::designtpl('lhkernel/secure_links.tpl.php')); ?>

    <?php if (isset($pages)) : ?>
        <?php include(erLhcoreClassDesign::designtpl('lhkernel/paginator.tpl.php')); ?>
    <?php endif;?>

<?php endif;?>

<a href="<?php echo erLhcoreClassDesign::baseurl('mattermost/newoption')?>" class="btn btn-sm btn-secondary"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','New');?></a>