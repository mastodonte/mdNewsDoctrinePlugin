MdNews = function(options){
	this._initialize();
}

MdNews.instance = null;
MdNews.getInstance = function (){
	if(MdNews.instance == null)
		MdNews.instance = new MdNews();
	return MdNews.instance;
}

MdNews.prototype = {
    _initialize : function(){

    },

    saveNews: function(url){
        try {
            tinyMCE.execCommand("mceRemoveControl", true, $('textarea.with-tiny')[0].id);
            tinyMCE.execCommand("mceAddControl", true, $('textarea.with-tiny')[0].id);
            tinyMCE.triggerSave();
            tinyMCE.execCommand("mceRemoveControl", true, $('textarea.with-tiny')[0].id);
        } catch (e) { }

        $.ajax({
            url: $('#news_new_form_').attr('action'),
            data: $('#news_new_form_').serialize(),
            dataType: 'json',
            type: 'post',
            success: function(json){
                if(json.result == 1){
                    mastodontePlugin.UI.BackendBasic.getInstance().onNewBoxError(json.body);
                }else{
                    mastodontePlugin.UI.BackendBasic.getInstance().onNewBoxAdded(url + '?id='+json.id);

                }
            }

        });

        return false;

    },

    saveEditedNews: function(form){
        try {
            tinyMCE.execCommand("mceRemoveControl", true, $('textarea.with-tiny')[0].id);
            tinyMCE.execCommand("mceAddControl", true, $('textarea.with-tiny')[0].id);
            tinyMCE.triggerSave();
            tinyMCE.execCommand("mceRemoveControl", true, $('textarea.with-tiny')[0].id);
        } catch (e) { }

        $.ajax({
            url: $(form).attr('action'),
            data: $(form).serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){
               if(json.result == 1){
                   mastodontePlugin.UI.BackendBasic.getInstance().close();
               } else {
                   mastodontePlugin.UI.BackendBasic.getInstance()
                       .getActivatedContent().html(json.body);
               }
            }
        });
    },

    deleteNewsWithConfirmation: function(text, id, element){
        if(confirm(text)){
            $.ajax({
                url: $(element).attr('href'),
                dataType: 'json',
                success: function(json){
                    if(json.response == 'OK'){
                        mastodontePlugin.UI.BackendBasic.getInstance().removeActiveBox();
                    }
                }
            });
        }
        return false;
    },

    changeNewsVisibility: function(newsId, obj){
        var url = 'mdnews/changeNewsVisibility';

        $.ajax({
           url: url,
           type: 'post',
           dataType: 'json',
           data: {'mdNewsId': newsId},
           success: function(json){
                if(json.response == "OK"){
                    $(obj.id).html(json.isActive);
                }
           }
        });
    },


    searchNews: function(){
        $.ajax({
            url: $('#md_news_filter').attr('action'),
            data: $('#md_news_filter').serialize(),
            dataType: 'json',
            success: function(json){
                if(json.response == "OK"){
                    $('#md_objects_container').html(json.news);
                }
            }
        });

    },

    saveNewCategory: function(form, event){

        $.ajax({
           url: $(form).attr('action'),
           type: 'post',
           data: $(form).serialize(),
           dataType: 'json',
           success: function(json){
               if(json.response == 'OK'){
                    try{
                        //ver migracion a jquery de estos objetos
                        mdContentList.hideContentBox('right_menu', event);
                        mdCategoryObjectBox.closeEditCategoryObjectBox();
                    }catch(e){}

                } else {
                    $('#addCategoryErrors').replaceWith(json.error);
                }
           }
        });
    }
}

mastodontePlugin.UI.BackendBasic.getInstance().afterOpen = function(json){
    if(typeof initializeLightBox == 'function'){
        initializeLightBox(json.id, json.className);
    }
}
