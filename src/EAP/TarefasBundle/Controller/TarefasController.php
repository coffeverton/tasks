<?php

namespace EAP\TarefasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use EAP\TarefasBundle\Entity\Tarefas;
use EAP\TarefasBundle\Form\TarefasType;

/**
 * Tarefas controller.
 *
 * @Route("/")
 */
class TarefasController extends Controller
{

    /**
     * Lists all Tarefas entities.
     *
     * @Route("/", name="tarefas")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TarefasBundle:Tarefas')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all active or waiting Tarefas entities.
     *
     * @Route("/ativas", name="ativas")
     * @Method("GET")
     * @Template("TarefasBundle:Tarefas:index.html.twig")
     */
    public function tarefasAtivasAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TarefasBundle:Tarefas')->findAllActive();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Tarefas entity.
     *
     * @Route("/", name="tarefas_create")
     * @Method("POST")
     * @Template("TarefasBundle:Tarefas:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Tarefas();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setData(new \DateTime);
            $em->persist($entity);
            $em->flush();

//            return $this->redirect($this->generateUrl('tarefas_show', array('id' => $entity->getId())));
            return $this->redirect($this->generateUrl('passos_agora'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Tarefas entity.
     *
     * @param Tarefas $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Tarefas $entity)
    {
        $form = $this->createForm(new TarefasType(), $entity, array(
            'action' => $this->generateUrl('tarefas_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Tarefas entity.
     *
     * @Route("/new", name="tarefas_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Tarefas();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Tarefas entity.
     *
     * @Route("/{id}", name="tarefas_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TarefasBundle:Tarefas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tarefas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Tarefas entity.
     *
     * @Route("/{id}/edit", name="tarefas_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TarefasBundle:Tarefas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tarefas entity.');
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
    * Creates a form to edit a Tarefas entity.
    *
    * @param Tarefas $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Tarefas $entity)
    {
        $form = $this->createForm(new TarefasType(), $entity, array(
            'action' => $this->generateUrl('tarefas_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Tarefas entity.
     *
     * @Route("/{id}", name="tarefas_update")
     * @Method("PUT")
     * @Template("TarefasBundle:Tarefas:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TarefasBundle:Tarefas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tarefas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setAtualizado(new \DateTime);
            $em->flush();

            return $this->redirect($this->generateUrl('tarefas_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Tarefas entity.
     *
     * @Route("/{id}", name="tarefas_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TarefasBundle:Tarefas')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tarefas entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

//        return $this->redirect($this->generateUrl('tarefas'));
        $this->goBack();
    }

    /**
     * Creates a form to delete a Tarefas entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tarefas_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Altera o status de uma tarefa.
     *
     * @Route("/change_status/{id}/{status}", name="change_status")
     */
    public function changeStatusTarefa($id, $status){

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('TarefasBundle:Tarefas')->find($id);

        $entity->setStatus($status);
        
        switch($status){
            case '2':
                $entity->setConcluido(new \DateTime);
                break;
        }

        $em->persist($entity);
        $em->flush();
        return $this->goBack();
    }

    /**
     * Redireciona o usuario para a pagina referer.
     *
     */
    private function goBack(){
        $request = Request::createFromGlobals();
        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }
}
