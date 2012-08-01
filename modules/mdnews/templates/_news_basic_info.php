<?php use_helper('mdAsset') ?>

<input type="hidden" value="<?php echo $form->getObject()->getId() ?>" name="id" />
<div id="md_basic_<?php echo $form->getObject()->getId() ?>" class="md_open_object_top">
    <div class="md_blocks">
        <h2><?php echo __('mdNewsDoctrine_text_Title') ?></h2>
        <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form[$sf_user->getCulture()]['title']->hasError()):?>error_msg<?php endif; ?>">
            <?php echo $form[$sf_user->getCulture()]['title']->render(array('class' => 'md_input_large')); ?>
        </div>
        <div><?php if($form[$sf_user->getCulture()]['title']->hasError()): echo $form[$sf_user->getCulture()]['title']->renderLabelName() .': '. $form[$sf_user->getCulture()]['title']->getError();  endif; ?></div>
    </div>
    <div class="md_blocks">
        <h2><?php echo __('mdNewsDoctrine_text_IsActive') ?></h2>
        <div style="" class="<?php if($form['is_active']->hasError()):?>error_msg<?php endif; ?>">
            <?php echo $form['is_active']->render(); ?>
        </div>
        <div><?php if($form['is_active']->hasError()): echo $form['is_active']->renderLabelName() .': '. $form['is_active']->getError();  endif; ?></div>
    </div>
    <div class="clear"></div>
    <div class="md_blocks">
        <h2><?php echo __('mdNewsDoctrine_text_Copete') ?></h2>
        <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form[$sf_user->getCulture()]['copete']->hasError()):?>error_msg<?php endif; ?>">
            <?php echo $form[$sf_user->getCulture()]['copete']->render(); ?>
        </div>
        <div><?php if($form[$sf_user->getCulture()]['copete']->hasError()): echo $form[$sf_user->getCulture()]['copete']->renderLabelName() .': '. $form[$sf_user->getCulture()]['copete']->getError();  endif; ?></div>
    </div>
    <div class="clear"></div>
    <div class="md_blocks">
        <h2><?php echo __('mdNewsDoctrine_text_Body') ?></h2>
        <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form[$sf_user->getCulture()]['body']->hasError()):?>error_msg<?php endif; ?>">
            <?php echo $form[$sf_user->getCulture()]['body']->render(array('class' => 'with-tiny')); ?>
        </div>
        <div><?php if($form[$sf_user->getCulture()]['body']->hasError()): echo $form[$sf_user->getCulture()]['body']->renderLabelName() .': '. $form[$sf_user->getCulture()]['body']->getError();  endif; ?></div>
    </div>
    <div class="clear"></div>
    <div class="md_blocks">
        <h2><?php echo __('mdNewsDoctrine_text_Source') ?></h2>
        <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['source']->hasError()):?>error_msg<?php endif; ?>">
            <?php echo $form['source']->render(); ?>
        </div>
        <div><?php if($form['source']->hasError()): echo $form['source']->renderLabelName() .': '. $form['source']->getError();  endif; ?></div>
    </div>
    <div class="md_blocks">
        <h2><?php echo __('mdNewsDoctrine_text_Publish') ?></h2>
        <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['publish']->hasError()):?>error_msg<?php endif; ?>">
            <?php echo $form['publish']->render(); ?>
        </div>
        <div><?php if($form['publish']->hasError()): echo $form['publish']->renderLabelName() .': '. $form['publish']->getError();  endif; ?></div>
    </div>
</div>
