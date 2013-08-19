<?php
// src/SmartCore/Bundle/TexterBundle/Twig/TexterExtension.php
namespace SmartCore\Bundle\TexterBundle\Twig;

class TexterExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('texter', 'generate_texter'),
        );

    }

    public function generate_texter()
    {
        return "Пробный текст";
    }

    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$'.$price;

        return $price;
    }

    public function getName()
    {
        return 'texter_extension';
    }
}
