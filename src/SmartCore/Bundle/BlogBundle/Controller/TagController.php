<?php

namespace SmartCore\Bundle\BlogBundle\Controller;

use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\Pagerfanta;
use SmartCore\Bundle\BlogBundle\Pagerfanta\SimpleDoctrineORMAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TagController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @todo сделать в сущности тэга weight, который будет автоматически инкрементироваться и декрементироваться при измнениях в статьях.
     */
    public function indexAction()
    {
        $tagService = $this->get('smart_blog.tag');

        $cloud = [];
        $tags = $tagService->getCloud();

        foreach ($tags as $tag) {
            $cloud[] = [
                'count' => $tagService->getArticlesCountByTag($tag),
                'tag'   => $tag,
            ];
        }

        return $this->render('SmartBlogBundle::tags.html.twig', [
            'cloud' => $cloud,
        ]);
    }

    /**
     * @param Request $requst
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function showArticlesAction(Request $requst, $slug)
    {
        $tagService = $this->get('smart_blog.tag');

        $tag = $tagService->getBySlug($slug);

        $pagerfanta = new Pagerfanta(new SimpleDoctrineORMAdapter($tagService->getFindByTagQuery($tag)));
        $pagerfanta->setMaxPerPage($tagService->getItemsCountPerPage());

        try {
            $pagerfanta->setCurrentPage($requst->query->get('page', 1));
        } catch (NotValidCurrentPageException $e) {
            return $this->redirect($this->generateUrl('smart_blog_tag_index'));
        }
        return $this->render('SmartBlogBundle::articles_by_tag.html.twig', [
            'tag'        => $tag,
            'pagerfanta' => $pagerfanta,
        ]);
    }
}
