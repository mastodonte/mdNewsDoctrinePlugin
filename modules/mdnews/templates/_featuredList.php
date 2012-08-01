<?php if(count($mdFeatures)>0):?>
      <div class="clear"></div>
      <div class="md_blocks">
          <h2 style="float: left;">Destacados</h2>
          <a href="javascript:void(0);" onclick="MdNews.getInstance().addFeaturedBox(<?php echo $form->getObject()->getId() ?>)"><?php echo plugin_image_tag ( 'mdBasicPlugin','edit.jpg', array('alt'=>'agregar o borrar destacados'))?></a>
          <div class="clear"></div>
          <div id="featured_list">
              <?php include_partial('mdnews/featuredList', array('mdNewsFeatures' => $mdNewsFeatures, 'mdUserId' => $form->getObject()->getId())) ?>
          </div>
          <div class="clear"></div>
          <div id="mdFeaturesContainer"></div>
      </div>
  <?php endif;?>
