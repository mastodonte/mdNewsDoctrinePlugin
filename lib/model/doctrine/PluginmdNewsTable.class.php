<?php

abstract class PluginmdNewsTable extends Doctrine_Table
{

	public function createQueryForAdmin($alias = 'n'){
		$q = $this->createQuery($alias);
		$q = $this->addOrderByPublishDescToQuery($q);
		
		return $q;
	}

  public function findByLastQuery()
  {
    $query = $this->createQuery('n')
                ->orderBy('publish DESC');

    return $query;
  }


  public function findByLastWithLimit($limit = 1)
  {
    $query = $this->createQuery('n')
                ->orderBy('publish DESC')
                ->limit($limit);
    return $query->execute();
  }

    public function findByRelevance($relevance = 'primaria', $lang = 'es'){

        $mdFeatureObjects = Doctrine::getTable('mdFeatureObject')->getFeatureObjectsByName('mdNews', $relevance, $lang);
        $collection = array();
        foreach ($mdFeatureObjects as $mdFeatureObject){
            $mdNew = Doctrine::getTable('mdNews')->find($mdFeatureObject->getObjectId());
            array_push($collection,$mdNew);
        }
        return $collection;

    }

    public function findByDate($date_init, $date_end){

        $query = $this->createQuery('n')
                ->where('n.publish >= ?', $date_init)
                ->addWhere('n.publish <= ?', $date_end);
        return $query->execute();

    }


    public function findByText($text) {
        $query = $this->createQuery('n');
        $query->innerJoin('n.Translation t')
			->addWhere('t.body like \'%' . $text . '%\'')
            ->orWhere('t.title like \'%' . $text . '%\'')
            ->orWhere('t.copete like \'%' . $text . '%\'');

        return $query->execute();
    }

    public function findByCategoryAndMonth($category_id, $month, $year){
        $query = $this->getQueryPublishedByCategoryId($category_id);
        $query = $this->addRetrieveByMonth($query, $month, $year);
        
        return $query->execute();

    }

    //metodos para join con mdFeatures
    public function getQueryPublishedByFeatureObjects($mdFeatureObject, $limit = null){
        $ids = array();
        foreach($mdFeatureObject as $mdf){
            $ids[]=$mdf->getObjectId();
        }

        $q = $this->createQuery('n')
                ->orWhereIn('n.id', $ids);

        $q = $this->addPublishedWhereToQuery($q);
            $q = $this->addOrderByPublishDescToQuery($q);
        $q = $this->addLimitToQuery($q, $limit);

        return $q;
    }

    public function findPublishedByFeatureObjects($mdFeatureObject, $limit = null){
        $q = $this->getQueryPublishedByFeatureObjects($mdFeatureObject, $limit);
        return $q->execute();
    }

    public function getQueryPublishedByCategoryId($category_id, $limit = null){
        $q = $this->getJoinCategoryQuery($category_id);
        $q = $this->addPublishedWhereToQuery($q);
		$q = $this->addOrderByPublishDescToQuery($q);
        $q = $this->addLimitToQuery($q, $limit);

        return $q;
    }

    public function findPublishedByCategoryId($category_id, $limit = null){
        $q = $this->getQueryPublishedByCategoryId($category_id, $limit );
        return $q->execute();
    }

    public function getQueryPublishedByFeaturesName($mdFeatureNames, $limit=null){
        $q = $this->createQuery('n');
        $q = doctrine::getTable('mdFeatureObject')->addJoinWithFeaturesByName($q, $mdFeatureNames);
        $q = $this->addPublishedWhereToQuery($q);
        $q = $this->addOrderByPublishDescToQuery($q);
        $q = $this->addLimitToQuery($q, $limit);

        return $q;
    }

    public function findPublishedByFeaturesName($mdFeatureNames, $limit=null){
        $q = $this->getQueryPublishedByFeaturesName($mdFeatureNames, $limit);
        return $q->execute();
    }

    public function getQueryPublishedByCategoryIdAndSonsAndFeaturesName($category_id, $mdFeatureNames, $limit = null){
        return $this->getQueryPublishedByCategoryIdAndFeaturesName($category_id, $mdFeatureNames, $limit, true);
    }

    public function getQueryPublishedByCategoryIdAndFeaturesName($category_id, $mdFeatureNames, $limit = null, $recursive = false){
        $q = $this->getJoinCategoryQuery($category_id, array('recursive'=>$recursive));
        $q = doctrine::getTable('mdFeatureObject')->addJoinWithFeaturesByName($q, $mdFeatureNames);
        $q = $this->addPublishedWhereToQuery($q);
        $q = $this->addOrderByPublishDescToQuery($q);
        $q = $this->addLimitToQuery($q, $limit);

        return $q;
    }

    public function findPublishedByCategoryIdAndFeaturesName($category_id, $mdFeatureNames, $limit = null){
        $q = $this->getQueryPublishedByCategoryIdAndFeaturesName($category_id, $mdFeatureNames, $limit);
        return $q->execute();
    }

    public function getQueryPublishedByCategoryIdAndSons($category_id, $limit = null){
        $q = $this->getJoinCategoryQuery($category_id, array('recursive'=>true));
        $q = $this->addPublishedWhereToQuery($q);
        $q = $this->addOrderByPublishDescToQuery($q);
        $q = $this->addLimitToQuery($q, $limit);

        return $q;
    }

    public function findPublishedByCategoryIdAndSons($category_id, $limit = null){
        $q = $this->getQueryPublishedByCategoryIdAndSons($category_id, $limit);
        return $q->execute();
    }

    public function getQueryPublishedByCategoryIdExcludingNews($category_id, $news_excluded, $limit = null){
        $q = $this->getJoinCategoryQuery($category_id);
        $q = $this->addExcludedNewsToQuery($q, $news_excluded);
        $q = $this->addPublishedWhereToQuery($q);
        $q = $this->addOrderByPublishDescToQuery($q);
        $q = $this->addLimitToQuery($q, $limit);

        return $q;
    }

    public function findPublishedByCategoryIdExcludingNews($category_id, $news_excluded, $limit = null){
        $q = $this->getQueryPublishedByCategoryIdExcludingNews($category_id, $news_excluded, $limit);
        return $q->execute();
    }

    public function getQueryPublishedByCategoryIdAndSonsExcludingNews($category_id, $news_excluded, $limit=null){
        $q = $this->getJoinCategoryQuery($category_id, array('recursive'=>true));
        $q = $this->addExcludedNewsToQuery($q, $news_excluded);
        $q = $this->addPublishedWhereToQuery($q);
    	$q = $this->addOrderByPublishDescToQuery($q);
        $q = $this->addLimitToQuery($q, $limit);

        return $q;
    }

    public function findPublishedByCategoryIdAndSonsExcludingNews($category_id, $news_excluded, $limit=null){
        $q = $this->getQueryPublishedByCategoryIdAndSonsExcludingNews($category_id, $news_excluded, $limit);
        return $q->execute();
    }

    public function getQueryByCategoryIdMdUserIdExcludingNewsBeforePublish($category_id, $md_user_id, $news_excluded, $publish, $limit=null){
        $q = $this->getJoinCategoryQuery($category_id);
        $q = $this->addMdUserIdWhereToQuery($q, $md_user_id);
        $q = $this->addExcludedNewsToQuery($q, $news_excluded);
        $q = $this->addPublishBeforeWhereToQuery($q, $publish);
        $q = $this->addOrderByPublishDescToQuery($q);
        $q = $this->addLimitToQuery($q, $limit);

        return $q;
    }

    public function findByCategoryIdMdUserIdExcludingNewsBeforePublish($category_id, $md_user_id, $news_excluded, $publish, $limit=null){
        $q = $this->getQueryByCategoryIdMdUserIdExcludingNewsBeforePublish($category_id, $md_user_id, $news_excluded, $publish, $limit);
        return $q->execute();
    }

    public function getQueryByCategoryIdExcludingNewsBeforePublish($category_id, $news_excluded, $publish, $limit=null){
        $q = $this->getJoinCategoryQuery($category_id);
        $q = $this->addExcludedNewsToQuery($q, $news_excluded);
        $q = $this->addPublishBeforeWhereToQuery($q, $publish);
        $q = $this->addOrderByPublishDescToQuery($q);
        $q = $this->addLimitToQuery($q, $limit);

        return $q;
    }

    public function findByCategoryIdExcludingNewsBeforePublish($category_id, $news_excluded, $publish, $limit=null){
        $q = $this->getQueryByCategoryIdExcludingNewsBeforePublish($category_id, $news_excluded, $publish, $limit);
        return $q->execute();
    }

    public function getQueryMostViewedPublishedSinceByCategoryIdAndSonsExcludingNews($since, $category_id, $news_excluded, $limit=null){
        $q = $this->getJoinCategoryQuery($category_id);
        $q = $this->addExcludedNewsToQuery($q, $news_excluded);
        $q = $this->addPublishedSinceWhereToQuery($q, $since);
        $q = $this->addMostViewedToQuery($q);
        $q = $this->addLimitToQuery($q, $limit);

        return $q;
    }

    public function getMonthsWithPublishNewsByCategory($category_id, $limit = null){
        $q = Doctrine_Query::create();
        $q->select('MONTH(n.publish) as pub_month')
        ->from('md_news n');
        $q = $this->getJoinCategoryQuery($category_id);
        $q = $this->addPublishedWhereToQuery($q);
        $q = $this->addOrderByPublishDescToQuery($q);
        $q->addGroupBy('MONTH(n.publish)');

        return $q->execute();
    }

    public function findMostViewedPublishedSinceByCategoryIdAndSonsExcludingNews($since, $category_id, $news_excluded, $limit=null){
        $q = $this->getQueryMostViewedPublishedSinceByCategoryIdAndSonsExcludingNews($since, $category_id, $news_excluded, $limit);
        return $q->execute();
    }

    public function retrieveMdNewsQueryActiveByPublish($limit = null, $offset = null)
    {
      $q = $this->createQuery('n');
      $q = $this->addOrderByPublishDescToQuery($q);
      $q = $this->addLimitToQuery($q, $limit);
      $q = $this->addOffsetToQuery($q, $offset);
      $q = $this->addActiveWhereToQuery($q);
      return $q;
    }

    //metodos auxiliares para armar query
    public function getJoinCategoryQuery($categories, $options = array(),$q = null){
        if($q == null){
            $q = $this->createQuery('n');
        }
        return doctrine::getTable('mdCategoryObject')->addJoinWithCategories($q, $categories, $options);
    }
    
    public function getJoinFeatureQuery($features, $options = array()){
        $q = $this->createQuery('n');
        return Doctrine::getTable('mdFeatureObject')->addJoinWithFeatures($q, $features, $options);
    }

    public function getJoinCategoryAndFeatureQuery($categories, $features, $options = array()){
        $q = $this->createQuery('n');
        $q = Doctrine::getTable('mdCategoryObject')->addJoinWithCategories($q, $categories, $options);
        $q = Doctrine::getTable('mdFeatureObject')->addJoinWithFeatures($q, $features, $options);
        return $q;
    }

    public function addPublishedWhereToQuery($query){
        $query->addWhere('publish < ?', date('Y-m-d H:i:s',time()));
        return $query;
    }
		
    public function addPublishedSinceWhereToQuery($query, $since){
        $query = $this->addPublishedWhereToQuery($query);
        $query->addWhere('publish >= ?', date('Y-m-d H:i:s',$since));

        return $query;
    }

    public function addPublishBeforeWhereToQuery($query, $publish){
        $query->addWhere('publish < ?', date('Y-m-d H:i:s',mdBasicFunction::convert_datetime($publish)));
        return $query;
    }

    public function addOrderByPublishDescToQuery($q){
        $q->orderBy('publish DESC');
        return $q;
    }

    public function addMostViewedToQuery($query){
        return 	$query->orderBy('views_count DESC');
    }

    public function addActiveWhereToQuery($query){
        $query->addWhere('is_active = 1');
        return $query;
    }
    /**
     * TODO
     * Cuando lo intente usar el $this->getRootAlias() no funciono lo tuve
     * que cambiar por $query->getRootAlias()
     *
     * @param <type> $query
     * @param <type> $md_user_id
     * @return <type>
     */
    public function addMdUserIdWhereToQuery($query, $md_user_id){
        $query->addFrom('mdContent mdCont')
            ->addWhere('mdCont.object_id = ' . $query->getRootAlias() . '.id')
            ->addWhere('mdCont.object_class = ?', 'mdNews')
            ->addWhere('mdCont.md_user_id = ?' , $md_user_id);

        return $query;
    }

    public function addLimitToQuery($q, $limit = null){
        if($limit!==null){
            $q->limit($limit);
        }
        return $q;
    }

    public function addOffsetToQuery($q, $offset = null){
        if($offset!==null){
            $q->offset($offset);
        }
        return $q;
    }

    private function addExcludedNewsToQuery($q, array $excluded_ids){
        $q->andwhereNotIn('n.id', $excluded_ids);
        return $q;
    }

    public function addRetrieveByMonth($query, $month, $year){
        if($query == null){
            $query = $this->createQuery('n');
        }
        $query->addWhere('Month(publish) = ?', $month);
        $query->addWhere('Year(publish) = ?', $year);
        return $query;
    }

}
