<form action='<?php echo url_for('mdnews/createNews'); ?>' method="post" onsubmit="MdNews.getInstance().saveNews('<?php echo url_for('mdnews/closedBox')?>'); return false;" id='news_new_form_'>
    <?php echo $form->renderHiddenFields()?>

    <?php include_partial('news_basic_info', array('form' => $form)); ?>

    <div id="new_product_extra" style="display: none;"></div>

    <div style="float: right">
        <input type="submit" value="<?php echo __('mdNewsDoctrine_text_save') ?>" />
        <a onclick="mastodontePlugin.UI.BackendBasic.getInstance().removeNew();"><?php echo __('mdNewsDoctrine_text_cancel') ?></a>

    </div>
    <div class="clear"></div>
</form>
<script type="text/javascript">
    $(function() {
		$( "input:submit", "#news_new_form_" ).button();
    });
</script>