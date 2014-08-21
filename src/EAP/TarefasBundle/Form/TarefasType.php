<?php

namespace EAP\TarefasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TarefasType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome')
            ->add('descricao')
            ->add('status', 'choice', array(
                'choices'   => array(0 => 'Aguardando', 1 => 'Executando', 2 => 'Finalizado', 3=>'Cancelado'),
                'required'  => true,
                'empty_value' => 'Selecione',
            ))
            ->add('idPai')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EAP\TarefasBundle\Entity\Tarefas',
            'empty_value' => 'Selecione'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'eap_tarefasbundle_tarefas';
    }
}
