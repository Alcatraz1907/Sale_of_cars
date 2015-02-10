<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 08.02.2015
 * Time: 15:55
 */

namespace  Application\Form;
use Zend\Form\Form;

class BrandsForm extends Form {
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('brands');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Name',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
} 