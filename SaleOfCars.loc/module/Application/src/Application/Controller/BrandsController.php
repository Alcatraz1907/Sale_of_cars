<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 08.02.2015
 * Time: 13:56
 */

namespace Application\Controller;

use Application\Form\BrandsForm;
use Application\Model\Brands;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BrandsController extends AbstractActionController {

    protected $brandsTable;

    public function getBrandsTable()
    {
        if (!$this->brandsTable) {
            $sm = $this->getServiceLocator();
            $this->brandsTable = $sm->get('Application\Model\BrandsTable');
        }

        return $this->brandsTable;
    }

    public  function indexAction(){

        return new ViewModel(array(
            'brands' => $this->getBrandsTable()->fetchAll(),
        ));
       // return new ViewModel();
    }
    public  function addAction(){

        $form = new BrandsForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if($request->isPost()){
            $brand = new Brands();
            $form->setInputFilter($brand->getInputFilter());
            $form->setData($request->getPost());

            if($form->isValid()){
                $brand->exchangeArray($form->getData());

                $this->getBrandsTable()->saveBrand($brand);

                return $this->redirect()->toRoute('brands');
            }
        }

        return array('form' => $form);
    }

    public  function editAction(){

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album', array(
                'action' => 'add'
            ));
        }

        // Get the Album with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $brand = $this->getBrandsTable()->getBrands($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('brands', array(
                'action' => 'index'
            ));
        }

        $form  = new BrandsForm();
        $form->bind($brand);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($brand->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getBrandsTable()->saveBrand($brand);

                // Redirect to list of albums
                return $this->redirect()->toRoute('brands');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }
    public function deleteAction(){

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('brands');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getBrandsTable()->deleteBrand($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('brands');
        }

        return array(
            'id'    => $id,
            'brands' => $this->getBrandsTable()->getBrands($id)
        );
    }
} 