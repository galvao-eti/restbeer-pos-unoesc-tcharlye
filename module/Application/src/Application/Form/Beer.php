<?php

namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class Beer extends Form
{
    public function __construct()
    {
        parent::__construct();

        $this->add([
            'name' => 'name',
            'options' => [
                'label' => 'Beer name',
            ],
            'type'  => 'Text',
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);
        $this->add([
            'name' => 'style',
            'options' => [
                'label' => 'Beer style',
            ],
            'type'  => 'Text',
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);

         $this->add([
            'name' => 'img',
            'options' => [
                'label' => 'Beer image',
            ],
            'type'  => 'Text',
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);

        $this->add([
            'name' => 'id',
            'type'  => 'Hidden',
        ]);

        $this->add([
            'name' => 'cancel',
            'type'  => 'Button',
            'options' => [
                'label' => 'Cancelar',
            ],
            'attributes' => [
                'value' => 'Cancelar',
                'class' => 'btn btn-default',
            ],
        ]);

        $this->add([
            'name' => 'send',
            'type'  => 'Submit',
            'attributes' => [
                'value' => 'Salvar',
                'class' => 'btn btn-primary',
            ],
        ]);

        $this->setAttribute('action', '/save');
        $this->setAttribute('method', 'post');
    }
}
