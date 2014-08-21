<?php

namespace EAP\TarefasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tarefas
 *
 * @ORM\Table(name="tarefas", indexes={@ORM\Index(name="fk_tarefa_pai", columns={"id_pai"})})
 * @ORM\Entity(repositoryClass="EAP\TarefasBundle\Entity\TarefasRepository")
 */
class Tarefas
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
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text", nullable=false)
     */
    private $descricao;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status = 0;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime", nullable=false)
     */
    private $data;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="atualizado", type="datetime", nullable=true)
     */
    private $atualizado;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="concluido", type="datetime", nullable=true)
     */
    private $concluido;

    private $statusLabel = array(0 => 'Aguardando', 1 => 'Executando', 2 => 'Finalizado', 3=>'Cancelado');

    /**
     * @ORM\OneToMany(targetEntity="Passos", mappedBy="tarefa")
     */
    protected $passos;

    /**
     * @param string $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
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
     * @param \Tarefas $idPai
     */
    public function setIdPai($idPai)
    {
        $this->idPai = $idPai;
    }

    /**
     * @return \Tarefas
     */
    public function getIdPai()
    {
        return $this->idPai;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get status label
     *
     * @return string
     */
    public function getStatusLabel()
    {
        return array_key_exists($this->getStatus(), $this->statusLabel)
            ?  $this->statusLabel[$this->getStatus()]
            : '';
    }

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
     * @param \DateTime $atualizado
     */
    public function setAtualizado($atualizado)
    {
        $this->atualizado = $atualizado;
    }

    /**
     * @return \DateTime
     */
    public function getAtualizado()
    {
        return $this->atualizado;
    }
    
    /**
     * @param \DateTime $concluido
     */
    public function setConcluido($concluido)
    {
        $this->concluido = $concluido;
    }

    /**
     * @return \DateTime
     */
    public function getConcluido()
    {
        return $this->concluido;
    }
    
    /**
     * @var \Tarefas
     *
     * @ORM\ManyToOne(targetEntity="Tarefas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pai", referencedColumnName="id")
     * })
     */
    private $idPai;


    public function __toString(){
        return $this->nome;
    }

    /**
     * Get idPai as integer
     *
     * @return \EAP\TarefasBundle\Entity\Tarefas
     */
    public function getIdPaiAsInt()
    {
        if($this->idPai){
            return $this->idPai->getId();
        }else{
            return false;
        }
    }

    public function getAllPassos(){
        return $this->passos;
    }

}
