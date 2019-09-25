<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends AbstractController
{
    /**
     * @Route("/search/{query}/{page_no<\d+>?1}", name="search")
     */
    public function index(string $query, int $page_no)
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)
            ->findByLike($query)
            ->page($page_no);
        $pageCount = $this->getDoctrine()->getRepository(Post::class)
            ->getLikePageCount($query);

        return $this->render('index.html.twig', [
            'posts' => $posts,
            'page_count' => $pageCount,
        ]);
    }

    /**
     * @Route("/json-search/{query}", name="json_search")
     */
    public function json_search($query)
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)
            ->findByLike($query)
            ->getQuery()
            ->getResult();

        $postArr = array();
        foreach($posts as $post) {
            $arr = array(
                "id" => $post->getID(),
                "name" => $post->getTitle(),
                "href" => $this->generateURL("post_show", ["slug" => $post->getSlug()]),
                "category" => $post->getCategory()->getName(),
            );
            array_push($postArr, $arr);
        }

        $json = json_encode($postArr);

        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
