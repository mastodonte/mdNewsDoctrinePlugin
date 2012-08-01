<?php
foreach ($pictures as $md_media_image){ ?>
    <img src="<?php echo mdWebImage::getUrl($md_media_image->getFilename(), array('width'=>70, 'height'=>70, 'crop'=>true)); ?>"/>
<?php } ?>
