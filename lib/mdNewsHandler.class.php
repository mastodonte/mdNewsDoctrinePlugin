<?php

class mdNewsHandler
{
  
  public static function retrieveNew($mdNewsId)
  {
    return Doctrine::getTable('mdNews')->find($mdNewsId);
  }
  
	public static function retrieveByCategoryLabel($label, $limit = null){
		$cat = mdCategoryHandler::retrieveByLabel($label);
    if($cat)
    {
      return doctrine::getTable('mdNews')->findPublishedByCategoryId($cat->getId(), $limit);
    }
    else
    {
      return array();
    }
	}

  public static function retrieveNewsOfCategory($category, $limit = 10, $pager = 1)
  {
    throw new Excepction('TODO', 100);
    $query = Doctrine::getTable('mdNews')->retrieveMdNewsQueryActiveByPublish($limit);
    $news = $query->execute();
    if($page != 1)
    {
      $array_contents = array_chunk($news, $limit);
      if(array_key_exists(($page-1), $array_contents))
      {
        return $array_contents[$page-1];
      }
      else
      {
        return $news;
      }
    }
    
  }

  /**
   * TODO Utilizar el APC
   * Devuelve las las ultimas noticias sin importar la categoria, pudiendole usar con pager. 
   * @limit number of mdNews to return
   * @page number of the page to return
   * @author Rodrigo Santellan
   **/ 
  public static function retrieveNews($limit = null, $page = null)
  {
    $offset = null;
    if($page != null)
    {
      $offset = $limit * $page;
    }
    $query = Doctrine::getTable('mdNews')->retrieveMdNewsQueryActiveByPublish($limit, $offset);
    return $query;
  }
  
  public static function processResult($query, $single = false)
  {
    if($single)
    {
      return $query->fecthOne();
    }
    else
    {
      return $query->execute();
    }
  }
  
  public static function retrieveMdNewsPublishedByFeaturesName($publish_name_array, $limit, $query = false)
  {
    
  }
}
