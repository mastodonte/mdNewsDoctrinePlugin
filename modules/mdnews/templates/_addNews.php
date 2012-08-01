<form action='<?php echo url_for('mdnews/createNews'); ?>' method="post" id='news_new_form_'>
    <?php echo $form->renderHiddenFields()?>
    
    <?php include_partial('news_basic_info', array('form' => $form)); ?>

    <div id="new_product_extra" style="display: none;"></div>

    <a class="md_object_cancel_button" onclick="hideAddNews();"><?php echo __('mdNewsDoctrine_text_cancel') ?></a>
    <div class="md_object_save">
        <a href="javascript:void(0)" onclick="saveNews();"><?php echo __('mdNewsDoctrine_text_save') ?></a>
    </div>
    <div class="clear"></div>
</form>
<?php //Effect.SlideUp('new_md_news_', { duration: 1.0 });?>
