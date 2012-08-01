<?php

/**
 * mdnews actions.
 *
 * @package    News
 * @subpackage mdnews
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdnewsActions extends sfActions
{
	
	public function preExecute() {
		//Testeo de idioma
		//$this->getUser()->setCulture('es');
		
		//Si el usuario tiene permisos
			if( sfConfig::get( 'sf_plugins_user_groups_permissions', false ) ){
        if (!$this->getUser()->hasPermission('Admin')) {
            $this->getUser()->setFlash('noPermission', 'noPermission');
            $this->redirect($this->getRequest()->getReferer());
        }
        if (!$this->getUser()->hasPermission('Backend News Show List')) {
            $this->getUser()->setFlash('noPermission', 'noPermission');
            $this->redirect($this->getRequest()->getReferer());
        }
      }
	}
    
  public function executeIndex(sfWebRequest $request)
  {
    $this->pager = new sfDoctrinePager ( 'mdNews', sfConfig::get ( 'app_max_shown_news',10 ) );

    $this->pager->setQuery ( Doctrine::getTable ( 'mdNews' )->createQueryForAdmin('n') );

    $this->pager->setPage ( $request->getParameter ( 'page', 1 ) );

    $this->pager->init ();


    $this->formFilter = new mdNewsFormFilter();
  }
  
  public function executeCreateNews(sfWebRequest $request){
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    
    $form = new mdNewsForm();

    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		$mdFeatures =  array();
		if( sfConfig::get( 'sf_plugins_news_feature', false ) ){
			$mdFeatures =  Doctrine::getTable('mdFeature')->findBy('object_class_name', 'mdNews');
		}
		
    if ($form->isValid())
    {
        //Obtenemos el usuario logueado
        $mdUserId = $this->getUser()->getMdUserId();

        $form->getObject()->setMdUserIdTmp($mdUserId);

        $md_new = $form->save();

        $salida['result'] = 0;
        $salida['id'] = $form->getObject()->getId();
        $this->clearCache($form->getObject()->getId());
        $salida['className'] = 'mdNews';
        return $this->renderText(json_encode($salida));
        
    } else {
        $salida['result'] = 1;
        $salida['body'] = $this->getPartial('add_box', array('form' => $form));
        $salida['id'] = $form->getObject()->getId();
        $salida['className'] = 'mdNews';
        return $this->renderText(json_encode($salida));
    }
  }  

  public function executeProcessMdNewsFormAjax(sfWebRequest $request){
    $this->forward404Unless($md_new = Doctrine::getTable('mdNews')->find(array($request->getParameter('id'))), sprintf('Object md_new does not exist (%s).', $request->getParameter('id')));
    $form = new mdNewsForm($md_new);

    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    
    if ($form->isValid())
    {
        //Obtenemos el usuario logueado
        $mdUserId = $this->getUser()->getMdUserId();

        $form->getObject()->setMdUserIdTmp($mdUserId);

        $md_new = $form->save();

        $salida['result'] = 1;
        $salida['mdNews_id'] = $form->getObject()->getId();
        $this->clearCache($form->getObject()->getId());
        return $this->renderText(json_encode($salida));
    } else {
        $body2 = $this->getPartial('open_box', array ('form'=> $form));
        $salida['result'] = 0;
        $salida['body'] = $body2;
        $salida['mdNews_id'] = $form->getObject()->getId();
        return $this->renderText(json_encode($salida));
    }
  }

  public function executeDeleteNewsAjax(sfWebRequest $request)
  {
    $salida = array();
    try{

        $md_news = Doctrine::getTable('mdNews')->find(array($request->getParameter('id')));
        $md_news->delete();

        $salida['response'] = 'OK';
        return $this->renderText(json_encode($salida));

    }catch(Exception $e){

        $salida['response'] = 'ERROR' . $e->getMessage();
        return $this->renderText(json_encode($salida));

    }
  }
  
  public function executeSearchNews(sfWebRequest $request){
    $this->formFilter = new mdNewsFormFilter();

    $this->formFilter->bind($request->getParameter('md_news_filters'));
    
    if ($this->formFilter->isValid()){
        $this->search = $this->formFilter->buildQuery($this->formFilter->getValues());
    } else {
        //echo 'no valido ' . $this->formFilter->getErrorSchema() ;
    }

    
    
    $this->pager = new sfDoctrinePager ( 'mdNews', sfConfig::get ( 'app_max_shown_news', 10 ) );
    $this->pager->setQuery ( $this->search );
    $this->pager->setPage ( $request->getParameter ( 'page', 1 ) );
    $this->pager->init();



    $this->setTemplate('index');
  }

    /**
     * Funciones Open, closed y add, controlan el contenido
     * que se ve en el accordion
     *
     */
    public function executeOpenBox(sfWebRequest $request){
        $mdNews = mdNewsHandler::retrieveNew($request->getParameter('id'));

        return $this->renderText(json_encode(array(
            'content' => $this->getPartial('open_box', array(
                'form'=> new mdNewsForm($mdNews))),

            'id' => $mdNews->getId(),
            'className' => $mdNews->getObjectClass()
        )));
   }

    public function executeClosedBox(sfWebRequest $request){
        $mdnews = Doctrine::getTable('mdNews')->find(array($request->getParameter('id')));

        return $this->renderText(json_encode(array(
            'content' => $this->getPartial('closed_box', array('object'=> $mdnews))
        )));
    }

    public function executeAddBox(sfWebRequest $request){
        return $this->renderText(json_encode(array(
            'content' => $this->getPartial('add_box', array('form'=> new mdNewsForm()))
        )));
    }
    
    private function clearCache($id)
    {
      $cacheManager = $this->getContext()->getViewCacheManager();
      if($cacheManager)
      {
        $cacheManager->remove('@sf_cache_partial?module=mdnews&action=__closed_box&sf_cache_key=mdnews_'.$id);
      }
    }
    
}
