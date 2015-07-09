<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 09/06/2015
 * Time: 16:47
 */

namespace Album\Form;

use Zend\Form\Form;

class AlbumForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('album');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'title',
            'type' => 'Text',
            'options' => array(
                'label' => 'Title',
            ),
        ));

        $this->add(array(
            'name' => 'artist',
            'type' => 'Text',
            'options' => array(
                'label' => 'Artist',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Text',
            'options' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}