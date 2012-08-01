<?php

/**
 * mdNews form.
 *
 * @package    mdNewsPlugin
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginmdNewsForm extends BasemdNewsForm
{  
  public function setup()
  {
    parent::setup();

    $langs = array($this->getObject()->getDefaultCulture());

    $this->embedI18n($langs);

    //$this->widgetSchema['publish'] = new sfExtraWidgetFormInputDatepickerTime(array('default' => date('Y-m-d H:i:s')));
    $this->widgetSchema['publish'] = new sfWidgetFormInputDatepicker(array('default' => date('Y-m-d H:i:s'), 'useTimeWidget' => true));
    $this->validatorSchema['publish'] = new sfExtraValidatorDatepickerTime();

    unset( $this['created_at'], $this['updated_at'], $this['id'] );
  }

  public function configure()
  {
  }

}
