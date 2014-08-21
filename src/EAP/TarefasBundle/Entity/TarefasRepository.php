<?php
/**
 * Created by PhpStorm.
 * User: everton
 * Date: 27/06/14
 * Time: 12:01
 */

namespace EAP\TarefasBundle\Entity;
use Doctrine\ORM\EntityRepository;


class TarefasRepository extends EntityRepository{
    public function findAll()
    {
        return $this->findBy(array(), array('id' => 'DESC'));
    }

        public function findAllActive()
    {
        return $this->findBy(
            array('status'=>array(0,1)),
            array('id' => 'DESC')
        );
    }
} 