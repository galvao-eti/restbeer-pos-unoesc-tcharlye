<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $beers = $this->getServiceLocator()
                      ->get('Application\Model\BeerTableGateway')
                      ->fetchAll();

        return new ViewModel(['beers' => $beers]);
    }

    public function createAction()
    {
        $form = $this->getServiceLocator()
                     ->get('Application\Form\Beer')
                     ->setAttribute('action', '/insert');

        return new ViewModel(['beerForm' => $form]);
    }

    public function insertAction()
    {
        $form = $this->getServiceLocator()
                     ->get('Application\Form\Beer')
                     ->setAttribute('action', '/insert');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->save($form, $request->getPost());
        }
        $view = new ViewModel(['beerForm' => $form]);
        $view->setTemplate('application/index/create.phtml');

        return $view;
    }

    public function updateAction()
    {
        $form = $this->getServiceLocator()
                     ->get('Application\Form\Beer')
                     ->setAttribute('action', '/update');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $this->save($form, $data);
        }
        if (empty($data->id)) {
            $tableGateway = $this->getServiceLocator()->get('Application\Model\BeerTableGateway');
            $data = (array) $tableGateway->get($this->params()->fromRoute('id'));
        }
        $form->setData($data);
        $view = new ViewModel(['beerForm' => $form]);
        $view->setTemplate('application/index/create.phtml');

        return $view;
    }

    public function deleteAction()
    {
        $tableGateway = $this->getServiceLocator()->get('Application\Model\BeerTableGateway');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $tableGateway->delete($data->id);

            return $this->redirect()->toUrl('/');
        }
        $beer = $tableGateway->get($this->params()->fromRoute('id'));

        return new ViewModel(['beer' => $beer]);
    }

    private function save(\Application\Form\Beer $form, \Zend\Stdlib\Parameters $data)
    {
        $tableGateway = $this->getServiceLocator()->get('Application\Model\BeerTableGateway');
        $beer = new \Application\Model\Beer;
        $form->setInputFilter($beer->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
            /* pega os dados validados e filtrados */
            $data = $form->getData();
            /* preenche os dados do objeto Post com os dados do formulário*/
            $beer->exchangeArray($data);
            /* salva o novo post*/
            $tableGateway->save($beer);
            /* redireciona para a página inicial que mostra todos os posts*/
            return $this->redirect()->toUrl('/');
        }
    }
}
