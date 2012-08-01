<?php
slot('mdNews', '');
use_helper('mdAsset');
use_plugin_javascript('mdNewsDoctrinePlugin','Modules/mdNews.js','last');

if( sfConfig::get( 'sf_plugins_news_category', false ) ):
    use_plugin_javascript('mdCategoryDoctrinePlugin','mdCategoryObjectBox.js','last');
endif;

if( sfConfig::get( 'sf_plugins_news_media', false ) ):
    include_partial('mdMediaContentAdmin/javascriptInclude');
    use_plugin_javascript('mastodontePlugin', 'jyoutube.js', 'last');  
    use_plugin_javascript('mdMediaDoctrinePlugin', 'manageVideos.js', 'last');    
endif;

use_javascript('tiny_mce/tiny_mce.js', 'last');

if( sfConfig::get( 'sf_plugins_news_feature', false ) ){
  use_plugin_javascript('mdFeatureDoctrinePlugin','mdFeatureBox.js','last');
}
?>

<script type="text/javascript">
    <?php if( sfConfig::get( 'sf_plugins_news_category', false ) ):  ?>
    var mdCategoryObjectBox = new MdCategoryObjectBox({'object_class':'mdNews'});
    <?php endif; ?>
</script>

<?php
include_component('backendBasic', 'backendTemplate', array(
    'module' => 'mdnews',
    'objects' => $pager,
    'formFilter' => $formFilter
));
