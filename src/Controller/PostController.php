<?php
// src/controller/PostController.php
namespace App\Controller;

use App\Entity\Post;
use App\Form\Type\DeleteType;
use App\Form\Type\PostType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractController
{
    /**
     * @Route("/{page_no<\d+>?1}", name="post")
     */
    public function index(int $page_no)
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll()
            ->page($page_no);

        $pageCount = $this->getDoctrine()->getRepository(Post::class)->getPageCount();

        return $this->render('index.html.twig', [
            'posts' => $posts,
            'page_count' => $pageCount,
        ]);
    }

    /**
     * @Route("/post/{slug}", name="post_show")
     */
    public function show(Post $post)
    {
        $categoryURL = $this->generateUrl('category',
            ['name' => $post->getCategory()->getName()]);

        $postArr = array(
            'title' => $post->getTitle(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'category' => $post->getCategory()->getName(),
            'created' => $post->getCreated()->format('Y-m-d H:i:s')
        );

        return $this->render('post/post.html.twig', [
            'post' => $postArr,
            'category_url' => $categoryURL,
        ]);
    }

    /**
     * @Route("/create/{slug?}", name="post_create")
     */
    public function create(Post $post = null, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if (is_null($post)) {
            $post = new Post();
        }
        $post->setCreated(new \DateTime());

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post_show', ['slug' => $post->getSlug()]);
        }

        return $this->render('post/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{slug}", name="post_delete")
     */
    public function delete(Post $post, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $form = $this->createForm(DeleteType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $this->addFlash(
                'success',
                "Post '{$post->getTitle()}' was deleted!"
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();

            return $this->redirectToRoute('post');
        }

        return $this->render('post/delete.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
