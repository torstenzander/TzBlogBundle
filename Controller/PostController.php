<?php

namespace Tz\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tz\BlogBundle\Entity\Comment;
use Tz\BlogBundle\Form\CommentType;
use Tz\BlogBundle\Entity\Post;
use Tz\BlogBundle\Form\PostType;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Post controller.
 *
 * @Route("/")
 */
class PostController extends Controller
{
    /**
     * Lists all Post entities.
     *
     * @Route("/", name="posts")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $isSuperAdmin = false;
        if ($this->getUser()) {
            $isSuperAdmin = $this->getUser()->isSuperAdmin();
        }
        /* @var \Knp\Component\Pager\Paginator $paginator */
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $this->getDoctrine()->getRepository('TzBlogBundle:Post')->findOrderedPosts(),
            $this->get('request')->query->get('page', 1),
            $this->container->getParameter('articles_per_page')
        );
        return array(
            'isSuperAdmin' => $isSuperAdmin,
            'pagination' => $pagination,
            'location' => 'blog'
        );
    }

    /**
     * Lists all Post entities.
     *
     * @Route("/tag/{slug}", name="posts_by_tag")
     * @Template()
     */
    public function listAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = $this->getDoctrine()->getRepository('TzBlogBundle:Tag')->findOneBySlug($slug);
        /* @var \Knp\Component\Pager\Paginator $paginator */
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $tag->getPosts(),
            $this->get('request')->query->get('page', 1),
            $this->container->getParameter('articles_per_page')
        );
        return array(
            'pagination' => $pagination,
            'location' => 'blog'
        );
    }
    /**
     * Finds and displays a Post entity.
     *
     * @Route("/show/{slug}", name="post_show"))
     * @Template()
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * @var $postEntity \Tz\BlogBundle\Entity\Post
         */
        $postEntity = $em->getRepository('TzBlogBundle:Post')->findOneBySlug($slug);

        if (!$postEntity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $deleteForm = $this->createDeleteForm($slug);

        $commentEntity = new Comment();
        $commentEntity->setPost($postEntity);
        $form = $this->createForm(new CommentType(), $commentEntity);
        $isSuperAdmin = false;
        if ($this->getUser()) {
            $isSuperAdmin = $this->getUser()->isSuperAdmin();
        }

        return array(
            'isSuperAdmin' => $isSuperAdmin,
            'entity' => $commentEntity,
            'form' => $form->createView(),
            'postEntity' => $postEntity,
            'comments' => $postEntity->getComments(),
            'delete_form' => $deleteForm->createView(),
            'location' => 'blog'
        );
    }

    /**
     * Displays a form to create a new Post entity.
     *
     * @Route("/post/new", name="post_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Post();
        $form = $this->createForm(new PostType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'location' => 'blog'
        );
    }

    /**
     * Creates a new Post entity.
     *
     * @Route("/post/create", name="post_create")
     * @Method("POST")
     * @Template("TzBlogBundle:Post:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Post();
        $form = $this->createForm(new PostType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('post_show', array('slug' => $entity->getSlug())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'location' => 'blog'
        );
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @Route("/post/{id}/edit", name="post_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TzBlogBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $editForm = $this->createForm(new PostType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'location' => 'blog'
        );
    }

    /**
     * Edits an existing Post entity.
     *
     * @Route("/{id}/update", name="post_update")
     * @Method("POST")
     * @Template("TzBlogBundle:Post:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TzBlogBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PostType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('post_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Post entity.
     *
     * @Route("/{id}/delete", name="post_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TzBlogBundle:Post')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Post entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('post'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();
    }
}
