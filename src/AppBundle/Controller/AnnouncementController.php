<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Photo;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Announcement;
use AppBundle\Form\AnnouncementType;
use Symfony\Component\HttpFoundation\Response;
use DateTime;

/**
 * Announcement controller.
 *
 * @Route("/announcement")
 */
class AnnouncementController extends Controller
{

    /**
     * Lists all Announcement entities.
     *
     * @Route("/", name="announcement")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

//        $entities = $em->getRepository('AppBundle:Announcement')->findAll();
        $entities = $em->getRepository('AppBundle:Announcement')->findActuall();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all Announcement entities.
     *
     * @Route("/page/{page}", name="announcementpage")
     * @Method("GET")
     * @Template("AppBundle:Announcement:index.html.twig")
     */
    public function pageAction($page)
    {
        $em = $this->getDoctrine()->getManager();

//        $entities = $em->getRepository('AppBundle:Announcement')->findAll();
        $entities = $em->getRepository('AppBundle:Announcement')->findActuall($page);

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all Announcement entities.
     *
     * @Route("/user", name="showByUser")
     * @Method("GET")
     * @Template("AppBundle:Announcement:index.html.twig")
     */
    public function showByUserAction()
    {
        $em = $this->getDoctrine()->getManager();

//        $entities = $em->getRepository('AppBundle:Announcement')->findAll();
        $entities = $em->getRepository('AppBundle:Announcement')->findBy(['user'=> $this->getUser()]);

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Announcement entity.
     *
     * @Route("/", name="announcement_create")
     * @Method("POST")
     * @Template("AppBundle:Announcement:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Announcement();
        $entity->setUser($this->getUser());

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();


            $uploaded = $form->get('uploaded_file');

            $em->persist($entity);


            $photo = new Photo();
            $photo->setAltText($form->get('alt_text')->getName());


            $file = $uploaded
                ->getData();

            if($file) {

                $em->persist($photo);
                $em->flush();

                $newName = uniqid() . '_' . $entity->getId();
                $file->move("/vagrant/LocalAnnouncementApp/web/images", $newName);

                $photo->setAnnouncement($entity);
                $photo->setPathToFile('/images/' . $newName);
                $entity->addPhoto($photo);

            }
            $em->flush();

            return $this->redirect($this->generateUrl('announcement_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Announcement entity.
     *
     * @param Announcement $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Announcement $entity)
    {
        $form = $this->createForm(new AnnouncementType(), $entity, array(
            'action' => $this->generateUrl('announcement_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Announcement entity.
     *
     * @Route("/new", name="announcement_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Announcement();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Announcement entity.
     *
     * @Route("/{id}", name="announcement_show")
     * @Method("GET")
     * Template("AppBundle:Announcement:title.html.twig")
     * @Template()
     */
    public function showAction($id)
    {
        // @Template("AppBundle:Announcement:title.html.twig")
        $date = new DateTime();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Announcement')->find($id);


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Announcement entity.');
        }

        $user = $this->getUser();
        if($user) {
            if (!($user->getId() === $entity->getUser()->getId())) {
                if ($entity->getExpirationTime() < $date) {
                    return $this->redirect($this->generateUrl('announcement'));
                }
            }
        } else if ($entity->getExpirationTime() < $date) {
            return $this->redirect($this->generateUrl('announcement'));
        }

//        var_dump(gettype($entity->getExpirationTime()));
//        var_dump(gettype( new DateTime() ));
//        var_dump(gettype(date('c')));

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Announcement entity.
     *
     * @Route("/{id}/edit", name="announcement_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Announcement')->find($id);



        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Announcement entity.');
        }

        $user = $this->getUser();
        if(!($user->getId() === $entity->getUser()->getId())){
            return $this->redirect($this->generateUrl('announcement_show', array('id' => $id)));
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
    * Creates a form to edit a Announcement entity.
    *
    * @param Announcement $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Announcement $entity)
    {
        $form = $this->createForm(new AnnouncementType(), $entity, array(
            'action' => $this->generateUrl('announcement_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Announcement entity.
     *
     * @Route("/{id}", name="announcement_update")
     * @Method("PUT")
     * @Template("AppBundle:Announcement:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Announcement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Announcement entity.');
        }

        $user = $this->getUser();
        if(!($user->getId() === $entity->getUser()->getId())){
            return $this->redirect($this->generateUrl('announcement_show', array('id' => $id)));
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();











            $uploaded = $editForm->get('uploaded_file');



            $photo = new Photo();
            $photo->setAltText($editForm->get('alt_text')->getName());


            $file = $uploaded
                ->getData();

            if($file) {


                    $em->persist($photo);
                $em->flush();

                $newName = uniqid() . '_' . $entity->getId();
                $file->move("/vagrant/LocalAnnouncementApp/web/images", $newName);

                $photo->setAnnouncement($entity);
                $photo->setPathToFile('/images/' . $newName);
                $entity->addPhoto($photo);

                $em->flush();

            }















            return $this->redirect($this->generateUrl('announcement_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Announcement entity.
     *
     * @Route("/{id}", name="announcement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Announcement')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Announcement entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('announcement'));
    }

    /**
     * Creates a form to delete a Announcement entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('announcement_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
