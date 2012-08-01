<?php use_helper('mdAsset'); use_helper('Date') ?>

<li class="md_height_fixed close <?php if(!$md_new->getIsActive()) echo 'no_active';?>" id="md_object_<?php echo $md_new->getId() ?>">
    <div id="loading_close_<?php echo $md_new->getId() ?>" style="display: none;" class="md_loading_closed_objects"><?php echo plugin_image_tag('mastodontePlugin', 'md-ajax-loader.gif', array('style' => 'margin-top:15px;')) ?></div>
    <ul style="z-index: 900;" class="md_closed_object">
		<?php if( sfConfig::get( 'sf_plugins_news_media', false ) ): ?>
            <li class="md_img">
                <img id="product_<?php echo $md_new->getId()?>" src="<?php echo $md_new->retrieveAvatar(array('width' => 46,'height' => 46)); ?>" width = "46" height = "46" />
            </li>
        <?php endif; ?>
    	<li class="md_object_name">
			<div class="float_left"><?php echo format_date($md_new->getPublish(), 'r', $sf_user->getCulture()) ?></div>
            <div class="md_object_owner">
                <div><?php echo $md_new->getTitle() ?></div>
            </div>
            <div class="md_object_categories">
            <?php if( sfConfig::get( 'sf_plugins_news_category', false ) ): ?>
                <?php $index = 0;?>
                <?php $quantity = count($md_new->getmdCategories());?>
                <?php foreach($md_new->getmdCategories() as $mdCategory):?>
                    <?php echo $mdCategory->getName()?>
                    <?php if($quantity > 1 && ($index <= $quantity -2)) echo ', ' ?>
                    <?php $index++;?>
                <?php endforeach;?>
            <?php endif; ?>

            <?php if( sfConfig::get( 'sf_plugins_news_feature', false ) ): ?>
                <?php $i = 0;?>
                <?php foreach($md_new->getFeatureCollection() as $mdFeature):
                        $i++;
                        if($i==1) echo ' | ';
                        else echo ', ';
                        echo $mdFeature->getLabel();
                    endforeach; ?>
            <?php endif; ?>
            </div>
        </li>
        <li class="md_edit">
            <a id="md_objectbox_<?php echo $md_new->getId()?>" href="<?php echo url_for('mdnews/getNewsDetailAjax') ?>?mdNewsId=<?php echo $md_new->getId() ?>" onclick="mdObjectList.openObject(<?php echo $md_new->getId() ?>,this, event, 'news_edit_form_');"><?php echo __('mdNewsDoctrine_text_backendEdit') ?></a>
        </li>
    </ul>
 </li>
