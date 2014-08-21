<?php

namespace EAP\TarefasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use EAP\TarefasBundle\Entity\Passos;
use EAP\TarefasBundle\Form\PassosType;

/**
 * Passos controller.
 *
 * @Route("/passos")
 */
class PassosController extends Controller
{

    /**
     * Lists all Passos entities.
     *
     * @Route("/", name="passos")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TarefasBundle:Passos')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Passos entity.
     *
     * @Route("/", name="passos_create")
     * @Method("POST")
     * @Template("TarefasBundle:Passos:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Passos();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $entity->setData(new \DateTime);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

//            return $this->redirect($this->generateUrl('passos_show', array('id' => $entity->getId())));
            return $this->redirect($this->generateUrl('ativas'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Passos entity.
     *
     * @param Passos $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Passos $entity)
    {
        $form = $this->createForm(new PassosType(), $entity, array(
            'action' => $this->generateUrl('passos_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Passos entity.
     *
     * @Route("/agora", name="passos_agora")
     * @Method("GET")
     * @Template("TarefasBundle:Passos:now.html.twig")
     */
    public function nowAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ultimo = $em->getRepository('TarefasBundle:Passos')->findBy(
            array(),
            array('id' => 'DESC'),
            1
        );
        $entity = new Passos();
        $entity->setTarefa($ultimo[0]->getTarefa());
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Passos entity.
     *
     * @Route("/new/{id_tarefa}", name="passos_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($id_tarefa)
    {
        $em = $this->getDoctrine()->getManager();

        $tarefa = $em->getRepository('TarefasBundle:Tarefas')->find($id_tarefa);

        $entity = new Passos();
        $entity->setTarefa($tarefa);
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Passos entity.
     *
     * @Route("/{id}", name="passos_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TarefasBundle:Passos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Passos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Passos entity.
     *
     * @Route("/{id}/edit", name="passos_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TarefasBundle:Passos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Passos entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Passos entity.
    *
    * @param Passos $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Passos $entity)
    {
        $form = $this->createForm(new PassosType(), $entity, array(
            'action' => $this->generateUrl('passos_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Passos entity.
     *
     * @Route("/{id}", name="passos_update")
     * @Method("PUT")
     * @Template("TarefasBundle:Passos:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TarefasBundle:Passos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Passos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('passos_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Passos entity.
     *
     * @Route("/{id}", name="passos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TarefasBundle:Passos')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Passos entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('passos'));
    }

    /**
     * Creates a form to delete a Passos entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('passos_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
