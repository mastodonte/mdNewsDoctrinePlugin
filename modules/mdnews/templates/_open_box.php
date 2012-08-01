<div ajax-url="<?php echo url_for('mdnews/closedBox?id='.$form->getObject()->getId()) ?>">
    <ul class="md_objects" >
        <li class="md_objects open" id='md_object_<?php echo $form->getObject()->getId() ?>'>
            <div id="show_error"></div>
            <form action='<?php echo url_for('mdnews/processMdNewsFormAjax'); ?>' method="post" id='news_edit_form_<?php echo $form->getObject()->getId() ?>' onsubmit="MdNews.getInstance().saveEditedNews($(this)); return false;">
                <?php echo $form->renderHiddenFields(); ?>
                <?php include_partial('news_basic_info', array('form' => $form)); ?>
                <?php if( sfConfig::get( 'sf_plugins_news_feature', false ) ):  ?>
                    <?php include_component('mdFeaturesBox','loadFeatureBox', array('object_id'=> $form->getObject()->getId(),'object_class' => $form->getObject()->getObjectClass()));?>
                <?php endif; ?>
                <div class="clear"></div>

                <div id="news_extra_info">
                    <?php if( sfConfig::get( 'sf_plugins_news_category', false ) ):  ?>
                        <?php include_component('mdCategoryObject', 'objectRelationBox', array('mdObject'=>$form->getObject()));?>
                    <?php endif;?>
            </form>
                    <?php if( sfConfig::get( 'sf_plugins_news_media', false ) ):  ?>
                        <div id="user_images" class="md_object_images">
                            <?php include_component('mdMediaContentAdmin', 'showAlbums', array('object' => $form->getObject())) ?>
                        </div>
                    <?php endif;?>
                </div>
                <div style="float: right">
                    <input type="button" value="<?php echo __('mdNewsDoctrine_text_save') ?>" onclick="MdNews.getInstance().saveEditedNews($('#news_edit_form_<?php echo $form->getObject()->getId() ?>')); return false;"/>
                    <a class="" href="javascript:void(0);" onclick="mastodontePlugin.UI.BackendBasic.getInstance().close();"><?php echo __('mdNewsDoctrine_text_cancel') ?></a>
                </div>
            

            <?php echo $form->renderGlobalErrors();?>
                <div class="float_left">
                    <a id="md__delete_objectbox_<?php echo $form->getObject()->getId()?>" href="<?php echo url_for('mdnews/deleteNewsAjax') ?>?id=<?php echo $form->getObject()->getId() ?>" onclick="return MdNews.getInstance().deleteNewsWithConfirmation('<?php __("mdNewsDoctrine_text_confirmRemove")?>', <?php echo $form->getObject()->getId() ?>,this);"><?php echo __('mdNewsDoctrine_text_deleteNew') ?></a>
                </div>

            <div class="clear"></div>
        </li>
    </ul>
</div>
<script type="text/javascript">
    $(function() {
		$( "input:submit", "#news_edit_form_<?php echo $form->getObject()->getId() ?>" ).button();
    });
</script>
