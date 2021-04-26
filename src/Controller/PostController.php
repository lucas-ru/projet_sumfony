<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PostController extends AbstractController
{
    #[Route('/post', name: 'post')]
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Post::class);
        $posts = $repo->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/post/create', name: 'post_create')]
    public function create(Request $request, Security $security): Response
    {
        $post = new Post();
        $this->denyAccessUnlessGranted('create', $post);
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $post->setCreateAt(new \DateTime());
            $post->setIsPublished(true);
            $post->setIsDeleted(false);
            $post->setAuthor($security->getUser());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($post);
            $manager->flush();

            return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
        }

        return $this->render('post/create.html.twig', [
            'formPost' => $form->createView(),
        ]);
    }

    #[Route('/post/answer{id_post}{id_author}', name: 'post_validate')]
    public function validate(int $id_post,int $id_author): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $repoPost = $this->getDoctrine()->getRepository(Post::class);
        $post = $repoPost->find($id_post);

        if (!$post) {
            throw $this->createNotFoundException(
                'No post found for id '.$id_post
            );
        }

        $repoComment = $this->getDoctrine()->getRepository(Comment::class);
        $form = $repoComment->find($id_author);

        if (!$form) {
            throw $this->createNotFoundException(
                'No comment found for id '.$id_author
            );
        }

        $post->setIspublished(false);
        $manager->flush();

        return $this->render('post/answer.html.twig', [
            'post' => $post,
            'commentAuthor' => $form
        ]);
    }

    #[Route('/post/{id}', name: 'post_show')]
    public function show(int $id, Request $request, Security $security): Response
    {


        $repo = $this->getDoctrine()->getRepository(Post::class);
        $post = $repo->find($id);

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $comment->setIsDeleted(false);
            $comment->setPost($post);
            $comment->setCreatedAt(new \DateTime());
            $comment->setAuthor($security->getUser());
            $reward = $security->getUser()->getLevelReward();
            $security->getUser()->setLevelReward($reward + 1);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
        }

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'formComment' => $form->createView(),
            'security' => $security->getUser()
        ]);
    }


}
