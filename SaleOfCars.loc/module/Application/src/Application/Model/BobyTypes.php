<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 08.02.2015
 * Time: 19:43
 */

namespace Application\Model;


class BobyTypes {
    public $id;
    public $name;
   // public $inputFilter;
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;

    }
} 