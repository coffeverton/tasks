<?php

namespace EAP\TarefasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Passos
 *
 * @ORM\Table(name="passos", indexes={@ORM\Index(name="fk_passos_1_idx", columns={"tarefa_id"})})
 * @ORM\Entity
 */
class Passos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime", nullable=false)
     */
    private $data;

    /**
     * @var string
     *
     * @ORM\Column(name="obs", type="string", length=250, nullable=true)
     */
    private $obs;

    /**
     * @var \Tarefas
     *
     * @ORM\ManyToOne(targetEntity="Tarefas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tarefa_id", referencedColumnName="id")
     * })
     */
    private $tarefa;

    /**
     * @param \DateTime $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $obs
     */
    public function setObs($obs)
    {
        $this->obs = $obs;
    }

    /**
     * @return string
     */
    public function getObs()
    {
        return $this->obs;
    }

    /**
     * @param \Tarefas $tarefa
     */
    public function setTarefa($tarefa)
    {
        $this->tarefa = $tarefa;
    }

    /**
     * @return \Tarefas
     */
    public function getTarefa()
    {
        return $this->tarefa;
    }


}
