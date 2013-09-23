<?php

namespace Dmitxe\BlogBundle\Controller;

use SmartCore\Bundle\BlogBundle\Controller\WidgetController as BaseWidgetController;

class WidgetController extends BaseWidgetController
{
    /**
     * @param string $url
     * @param string $title
     * @param string $description
     * @param string $image
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @todo убрать в SmartSocialBundle
     */
    public function buttonsLikeAction($url = '', $title = '', $description = '',  $image = '')
    {
        return $this->render($this->bundleName . ':Widget:buttonsLike.html.twig', [
            'title'       => $title,
            'description' => $description,
            'image'       => $image,
            'url'         => $url,
        ]);
    }
}
