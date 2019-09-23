<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Category;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{name}/{page_no<\d+>?1}", name="category")
     */
    public function index(Category $category, int $page_no)
    {
        $category_id = $category->getId();

        $posts = $this->getDoctrine()->getRepository(Post::class)->findByCategoryPage($category_id, $page_no);
        $pageCount = $this->getDoctrine()->getRepository(Post::class)->getCategoryPageCount($category_id);

        return $this->render('category/index.html.twig', [
            'category' => $category->getName(),
            'posts' => $posts,
            'page_count' => $pageCount,
        ]);
    }
}
