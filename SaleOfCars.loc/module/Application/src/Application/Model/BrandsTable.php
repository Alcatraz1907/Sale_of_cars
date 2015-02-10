<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 08.02.2015
 * Time: 13:48
 */

namespace Application\Model;


use Zend\Db\TableGateway\TableGateway;

class BrandsTable {
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getBrands($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveBrand(Brands $brands)
    {
        $data = array(
            'name' => $brands->name,
        );

        $id = (int)$brands->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getBrands($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteBrand($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
} 