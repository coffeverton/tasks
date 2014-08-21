<?php

namespace EAP\TarefasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PassosType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tarefa')
            ->add('obs')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EAP\TarefasBundle\Entity\Passos',
            'empty_value' => 'Selecione'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'eap_tarefasbundle_passos';
    }
}
