<form id="md_news_filter" action="<?php echo url_for('mdnews/searchNews') ?>" method="post">
    <?php echo $formFilter->renderHiddenFields() ?>
    <div style="float: left;">
        <h2><?php echo __('mdNewsDoctrine_text_backendFilterTextValue') ?></h2>
        <ul class="filter">
            <li><?php echo $formFilter['text_value']->render(array(), array('class' => 'largeInput')) ?></li>
        </ul>
    </div>
    <div class="clear"></div>
    <hr>
    <div style="float: left;">
        <h2><?php echo __('mdNewsDoctrine_text_backendFilterPublish') ?></h2>
        <ul class="filter">
            <li><?php echo $formFilter['publish']->render() ?></li>
        </ul>
    </div>
    <div class="clear"></div>
    <?php if( sfConfig::get( 'sf_plugins_news_feature', false ) ||  sfConfig::get( 'sf_plugins_news_category', false ) ):  ?>
        <hr>
        <?php if( sfConfig::get( 'sf_plugins_news_category', false ) ):  ?>
            <div style="float: left;">
                    <h2><?php echo $formFilter['md_category_id']->renderLabel() ?></h2>
                    <ul class="filter">
                            <li><?php echo $formFilter['md_category_id']->render(array('style' => 'width:210px')) ?></li>
                    </ul>
            </div>
        <?php endif;?>
        <?php if( sfConfig::get( 'sf_plugins_news_feature', false ) ):  ?>
            <?php if(count($formFilter['md_features_id']->getWidget()->getChoices())>1):?>
                <div class="clear"></div>
                <hr>
                <div style="float: left;">
                        <h2><?php echo $formFilter['md_features_id']->renderLabel() ?></h2>
                        <ul class="filter">
                                <li><?php echo $formFilter['md_features_id']->render() ?></li>
                        </ul>
                </div>
            <?php else: ?>
                    <input type="hidden" value="0" name="md_news_filters[md_features_id]" />
            <?php endif;?>
        <?php endif;?>
        <div class="clear"></div>
    <?php endif; ?>
    <input type="hidden" value="1" name="page" id="page_filter_id"/>
    <hr>
    <input id="md_object_submit_button" type="submit" value="<?php echo __('mdNewsDoctrine_text_backendFilterSearch') ?>" />
</form>
<script type="text/javascript">
    $(function() {
		$( "input:submit", "#md_news_filter" ).button();
    });
</script>
