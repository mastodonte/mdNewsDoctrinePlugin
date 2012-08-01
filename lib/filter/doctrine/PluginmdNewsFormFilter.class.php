<?php

/**
 * mdNews filter form.
 *
 * @package    mdNewsPlugin
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginmdNewsFormFilter extends BasemdNewsFormFilter
{
  public function configure()
  {
  }

  public function setup(){
    parent::setup();

    unset($this['updated_at'], $this['created_at'], $this['source'], $this['is_active']);
		
		if( sfConfig::get( 'sf_plugins_news_category', false ) ){

            $this->widgetSchema['md_category_id'] = new sfWidgetFormChoiceAutocompleteComboBox(array(
                'choices' => Doctrine::getTable('mdCategory')->getAllChoices('mdNews')
            ));
//			$this->widgetSchema['md_category_id'] = new sfWidgetFormChoice(array(
//				'choices' => Doctrine::getTable('mdCategory')->getChoices('mdNews'),
//			));
		}
		if( sfConfig::get( 'sf_plugins_news_feature', false ) ){
			$this->widgetSchema['md_features_id'] = new sfWidgetFormChoice(array(
				'choices' => Doctrine::getTable('mdFeature')->getChoices('mdNews'),
			));
		}
    $this->widgetSchema['publish'] = new sfWidgetFormFilterDate(array(
        'from_date' => new sfWidgetFormInputDatepicker(array('default' => date('Y-m-d'))),
        'to_date' => new sfWidgetFormInputDatepicker(array('default' => date('Y-m-d'))),
        'with_empty' => false,
        'template' => '<table><tr><td>from</td><td>%from_date%</td></tr><tr><td>to</td><td>%to_date%</td></tr></table>'
    ));

    $this->widgetSchema['text_value'] = new sfWidgetFormInput();
    
    $this->validatorSchema['text_value'] = new sfValidatorString(array('required' => false));
		if( sfConfig::get( 'sf_plugins_news_category', false ) ){
			$this->validatorSchema['md_category_id'] = new sfValidatorInteger();
		}
		if( sfConfig::get( 'sf_plugins_news_feature', false ) ){
			$this->validatorSchema['md_features_id'] = new sfValidatorInteger();
		}    
    
    $this->validatorSchema['publish'] = new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false))));
  }

  public function addTextValueColumnQuery(Doctrine_Query $query, $field, $values){
    if($values != ''){
        $query->addFrom($query->getRootAlias() . '.Translation t')
				->addWhere('t.id='.$query->getRootAlias() . '.id')
				->addWhere('t.body like \'%' . $values . '%\'')
        ->orWhere('t.title like \'%' . $values . '%\'')
        ->orWhere('t.copete like \'%' . $values . '%\'');
    }
  }

  public function addMdCategoryIdColumnQuery(Doctrine_Query $query, $field, $values){
    
    if($values != '0'){
        $query = Doctrine::getTable('mdCategoryObject')->addJoinWithCategories($query, $values);
    }
  }

  public function addMdFeaturesIdColumnQuery(Doctrine_Query $query, $field, $values){
    if($values != '0'){
        $query = Doctrine::getTable('mdFeatureObject')->addJoinWithFeatures($query, $values);
    }
  }

  public function getFields(){
    $add_featured_field = array_merge(parent::getFields(), array('md_features_id' => 'Number'));
    $add_category_field = array_merge($add_featured_field, array('md_category_id' => 'Number'));
    return array_merge($add_category_field, array('text_value' => 'Text'));
  }

}
