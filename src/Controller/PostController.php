<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Chat;
use App\Entity\MessageChat;
use App\Form\CommentType;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PostController extends AbstractController
{
    #[Route('/post', name: 'post')]
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Post::class);
        $posts = $repo->findAll();

        $repoChat = $this->getDoctrine()->getRepository(Chat::class);
        $chats = $repoChat->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
            'chats' => $chats
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

    #[Route('/post/answer{id_post}{id_author}', name: 'post_answer')]
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
        $comment = $repoComment->find($id_author);

        if (!$comment) {
            throw $this->createNotFoundException(
                'No comment found for id '.$id_author
            );
        }


        if ($this->getUser()->getId() == $post->getAuthor()->getId() || $this->getUser()->getId() == $comment->getAuthor()->getId()) {

          $name_chat = '#Chat'.strval($id_post).strval($id_author);
          $repoChat = $this->getDoctrine()->getRepository(Chat::class);
          $chat = $repoChat->findBy(["name"=>$name_chat]);
          if ($chat == null) {

            $chat = new Chat();
            $chat->setName($name_chat);
            $chat->setIdPostAuthor($post->getAuthor()->getId());
            $chat->setIdCommentAuthor($comment->getAuthor()->getId());
            $chat->setIdPost($id_post);
            $chat->setIdComment($id_author);
            $manager->persist($chat);
          } else {
            $chat = $chat[0];
          }

          $post->setIspublished(false);
          $manager->flush();

          return $this->render('post/answer.html.twig', [
            'post' => $post,
            'ws_url' => 'localhost:8080',
            'name_chat' => $name_chat,
            'chat' => $chat,
            'commentAuthor' => $comment
          ]);
        } else {
          return $this->redirectToRoute('post');
        }

    }

    #[Route('/post/sendmsg', name: 'post_sendmsg')]
    public function sendmsg(Request $request): Response
    {
      $data = json_decode($request->getContent());

      $manager = $this->getDoctrine()->getManager();

      $msgChat = new MessageChat();
      $msgChat->setContent($request->request->get('content'));
      $msgChat->setAuthorMsg($request->request->get('authorMsg'));
      $msgChat->setCreatedAt(new \DateTime());

      $repoChat = $this->getDoctrine()->getRepository(Chat::class);
      $chat = $repoChat->findBy(["name"=>$request->request->get('chatName')]);
      $msgChat->setChat($chat[0]);

      $manager->persist($msgChat);
      $manager->flush();

      // dump($request->request);

      return new JsonResponse("msg saved");
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
