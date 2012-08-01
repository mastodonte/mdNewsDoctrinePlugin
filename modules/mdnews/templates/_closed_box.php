<div style="height: 51px; margin: 4px;" ajax-url="<?php echo url_for("mdnews/openBox")."?id=".$object->getId() ?>">
    <ul class="md_closed_object">
        <li class="md_height_fixed close <?php if(!$object->getIsActive()) echo 'no_active';?>" id="md_object_<?php echo $object->getId() ?>">
           <ul style="z-index: 900;" class="md_closed_object">
                <?php if( sfConfig::get( 'sf_plugins_news_media', false ) ): ?>
                    <li class="md_img">
                        <img id="md_news_<?php echo $object->getId()?>" src="<?php echo $object->retrieveAvatar(array(mdWebOptions::WIDTH => 46, mdWebOptions::HEIGHT => 46, mdWebOptions::CODE => mdWebCodes::RESIZECROP)); ?>"  />
                    </li>
                <?php endif; ?>
                <li class="md_object_name">
                    <div class="float_left"><?php echo format_date($object->getPublish(), 'r', $sf_user->getCulture()) ?></div>
                    <div class="md_object_owner">
                        <div><?php echo $object->getTitle() ?></div>
                    </div>
                    <div class="md_object_categories">
                    <?php if( sfConfig::get( 'sf_plugins_news_category', false ) ): ?>
                        <?php $index = 0;?>
                        <?php $quantity = count($object->getmdCategories());?>
                        <?php foreach($object->getmdCategories() as $mdCategory):?>
                            <?php echo $mdCategory->getName()?>
                            <?php if($quantity > 1 && ($index <= $quantity -2)) echo ', ' ?>
                            <?php $index++;?>
                        <?php endforeach;?>
                    <?php endif; ?>

                    <?php if( sfConfig::get( 'sf_plugins_news_feature', false ) ): ?>
                        <?php $i = 0;?>
                        <?php foreach($object->getFeatureCollection() as $mdFeature):
                                $i++;
                                if($i==1) echo ' | ';
                                else echo ', ';
                                echo $mdFeature->getLabel();
                            endforeach; ?>
                    <?php endif; ?>
                    </div>
                </li>

            </ul>
         </li>
    </ul>
</div>