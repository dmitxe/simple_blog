<?php

namespace Dmitxe\FixturesBundle\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAware;
use Dmitxe\BlogBundle\Entity\Article;
use Dmitxe\BlogBundle\Entity\Category;
use Dmitxe\BlogBundle\Entity\Tag;

class LoadBlogData extends ContainerAware implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $user = $em->getRepository('DmitxeUserBundle:User')->findOneBy([], ['id' => 'ASC']);

        $category_prog = new Category();
        $category_prog
            ->setTitle('Программирование')
            ->setSlug('programing')
        ;

        $category_php = new Category();
        $category_php
            ->setTitle('PHP')
            ->setSlug('php')
            ->setParent($category_prog)
        ;

        $category_yii = new Category();
        $category_yii
            ->setTitle('Yii')
            ->setSlug('yii')
            ->setParent($category_php)
        ;

        $category_symfony2 = new Category();
        $category_symfony2
            ->setTitle('Symfony 2')
            ->setSlug('symfony2')
            ->setParent($category_php)
        ;

        $category_js = new Category();
        $category_js
            ->setTitle('JavaScript')
            ->setSlug('js')
            ->setParent($category_prog)
        ;

        $category_jquery = new Category();
        $category_jquery
            ->setTitle('jQuery')
            ->setSlug('jquery')
            ->setParent($category_js)
        ;

        $category_cpp = new Category();
        $category_cpp
            ->setTitle('C++')
            ->setSlug('cpp')
            ->setParent($category_prog)
        ;

        $category_imposition = new Category();
        $category_imposition
            ->setTitle('Верстка')
            ->setSlug('imposition')
        ;

        $category_css = new Category();
        $category_css
            ->setTitle('CSS')
            ->setSlug('css')
            ->setParent($category_imposition)
        ;

        $category_twitter_bootstrap = new Category();
        $category_twitter_bootstrap
            ->setTitle('Twitter Bootstrap')
            ->setSlug('twitter_bootstrap')
            ->setParent($category_css)
        ;

        $category_html = new Category();
        $category_html
            ->setTitle('HTML')
            ->setSlug('html')
            ->setParent($category_imposition)
        ;

        $category_os = new Category();
        $category_os
            ->setTitle('Операционные системы')
            ->setSlug('os')
        ;

        $category_soft = new Category();
        $category_soft
            ->setTitle('Программы (софт)')
            ->setSlug('soft')
        ;

        $category_other = new Category();
        $category_other
            ->setTitle('Другое')
            ->setSlug('other')
        ;

        $tag1 = new Tag('PHP');
        $tag2 = new Tag('Symfony2');
        $tag3 = new Tag('jQuery');
        $tag4 = new Tag('Linux');
        $tag5 = new Tag('Breadcrumbs');
        $tag6 = new Tag('Yii');
        $tag7 = new Tag('Консольные команды');
        $tag7->setSlug('commands');

        $article = new Article();
        $article->setTitle('Хлебные крошки в Yii')
            //->setEnabled(false)
            ->setSlug('breadcrumbs_yii')
            ->setAnnotation('Хлебные крошки (Breadcrumbs) - это строка навигации до текущей страницы, сделанная из ссылок на родительские элементы. В Yii есть удобное средство для работы с хлебными крошками &ndash; виджет zii&nbsp; CBreadcrumbs http://www.yiiframework.com/doc/api/1.1/CBreadcrumbs<br />
	Хочу описать, как подключить CBreadcrumbs.')
            ->setText('<p>
	Хлебные крошки (Breadcrumbs) &ndash; это строка навигации до текущей страницы, сделанная из ссылок на родительские элементы. В Yii есть удобное средство для работы с хлебными крошками &ndash; виджет zii&nbsp; CBreadcrumbs http://www.yiiframework.com/doc/api/1.1/CBreadcrumbs<br />
	Хочу описать, как подключить CBreadcrumbs.</p>
<hr id="readmore" />
<p>
	В контроллере определяем общедоступную переменную-массив хлебных крошек. public $breadcrumbs=array();<br />
	В layout view вставляем</p>
<div class="highlight">
	<pre class="brush:php">
	&lt;?php if(isset($this-&gt;breadcrumbs)):?&gt;
		&lt;?php $this-&gt;widget(&#39;zii.widgets.CBreadcrumbs&#39;, array(
			&#39;links&#39;=&gt;$this-&gt;breadcrumbs,
                        &#39;homeLink&#39;=&gt;CHtml::link(&#39;Главная&#39;,&#39;/&#39; ),
		)); ?&gt;&lt;!-- breadcrumbs --&gt;
	&lt;?php endif?&gt;</pre>
</div>
<p>
	Здесь links &ndash; массив ссылок навигации, мы берём его из текущего контроллера.<br />
	homeLink &ndash; ссылка на главную страницу.<br />
	Теперь во view не забываем определить массив:</p>
<div class="highlight">
	<pre class="brush:php">
$this-&gt;breadcrumbs=array(
	&#39;Записи&#39;=&gt;array(&#39;index&#39;),
	$model-&gt;title,
);</pre>
</div>
<p>
	Вот и всё.</p>
')
            ->setAuthor($user)
            ->setCategory($category_yii)
            ->addTag($tag5)
            ->addTag($tag6)
        ;
        $manager->persist($article);



        $article = new Article();
        $article->setTitle('Symfony 2: справочник команд')
            ->setSlug('symfony_2_spravochnik_komand')
            ->setSlug('s2_sik_knd')
            ->setAnnotation('В этой статье буду писать самые часто используемые команды Симфони. Как ни странно, но на Симфони без командной строки ну никак. Полгода-год назад помнил многие команды наизусть, а сейчас, особенно после работы с Магенто, в голове чистый лист.')
            ->setText('<p>
	В этой статье буду писать самые часто используемые команды Симфони. Как ни странно, но на Симфони без командной строки ну никак. Полгода-год назад помнил многие команды наизусть, а сейчас, особенно после работы с Магенто, в голове чистый лист.</p>
<hr id="readmore" />
<p>
	Инсталляция проекта:</p>
<pre class="brush: php; toolbar: true;">
 composer install --prefer-dist</pre>
<p>
	Обновление проекта:</p>
<pre class="brush: php; toolbar: true;">
 composer update --prefer-dist</pre>
<p>
	Обновление бандла:</p>
<pre class="brush: php; toolbar: true;">
 composer update friendsofsymfony/user-bundle</pre>
<p>
	Создание базы:</p>
<pre class="brush: php; toolbar: true;">
php app/console doctrine:database:create</pre>
<p>
	Создание таблиц:</p>
<pre class="brush: php; toolbar: true;">
php app/console doctrine:schema:create</pre>
<p>
	Загрузка фикстур:</p>
<pre class="brush: php; toolbar: true;">
php app/console doctrine:fixtures:load</pre>
<p>
	Создание бандла:</p>
<pre class="brush: php; toolbar: true;">
php app/console generate:bundle --namespace=Acme/HelloBundle --format=yml</pre>
<p>
	Очистка кэша:</p>
<pre class="brush: php; toolbar: true;">
php app/console cache:clear --env=prod --no-debug</pre>
<p>
	Отладка роутеров:</p>
<pre class="brush: php; toolbar: true;">
php app/console router:debug</pre>
<p>
	Показать все сервисы и классы связанные с сервисом:</p>
<pre class="brush: php; toolbar: true;">
php app/console container:debug</pre>
<p>
	Показать приватные сервисы :</p>
<pre class="brush: php; toolbar: true;">
php app/console container:debug --show-private</pre>
<p>
	Показать сервис по его id :</p>
<pre class="brush: php; toolbar: true;">
php app/console container:debug my_mailer</pre>
<p>
	Обновить ассеты :</p>
<pre class="brush: php; toolbar: true;">
1. php app/console assetic:dump
2. php app/console assets:install
</pre>
<p>
	Примечание. Иногда бывает нужно явно указать --env=prod</p>
')
            ->setAuthor($user)
            ->setCategory($category_symfony2)
            ->addTag($tag2)
            ->addTag($tag7)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Первая статья')
            ->setSlug('art1')
            ->setAnnotation('Аннотация для первой статьи.')
            ->setText('Опросная анкета упорядочивает из ряда вон выходящий портрет потребителя, учитывая результат предыдущих медиа-кампаний. Спонсорство, в рамках сегодняшних воззрений, однородно стабилизирует принцип восприятия, используя опыт предыдущих кампаний. Узнавание бренда осмысленно переворачивает повторный контакт, признавая определенные рыночные тенденции. Стимулирование сбыта амбивалентно.')
            ->setCategory($category_cpp)
            ->addTag($tag1)
            ->addTag($tag3)
            ->setAuthor($user)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Вторая статья')
            ->setSlug('art2')
            ->setAnnotation('Аннотация для второй статьи.')
            ->setText('Опросная анкета упорядочивает из ряда вон выходящий портрет потребителя, учитывая результат предыдущих медиа-кампаний. Спонсорство, в рамках сегодняшних воззрений, однородно стабилизирует принцип восприятия, используя опыт предыдущих кампаний. Узнавание бренда осмысленно переворачивает повторный контакт, признавая определенные рыночные тенденции. Стимулирование сбыта амбивалентно.')
            ->setCategory($category_js)
            ->addTag($tag1)
            ->addTag($tag3)
            ->setAuthor($user)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Третья статья')
            ->setSlug('third')
            ->setAnnotation('Аннотация для третьей статьи.')
            ->setText('Опросная анкета упорядочивает из ряда вон выходящий портрет потребителя, учитывая результат предыдущих медиа-кампаний. Спонсорство, в рамках сегодняшних воззрений, однородно стабилизирует принцип восприятия, используя опыт предыдущих кампаний. Узнавание бренда осмысленно переворачивает повторный контакт, признавая определенные рыночные тенденции. Стимулирование сбыта амбивалентно.')
            ->setCategory($category_jquery)
            ->setAuthor($user)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Четвертая статья')
            ->setSlug('fourth')
            ->setAnnotation('Аннотация для четвертой статьи.')
            ->setText('Взаимодействие корпорации и клиента амбивалентно. Агентская комиссия специфицирует мониторинг активности, используя опыт предыдущих кампаний. Ассортиментная политика предприятия развивает стратегический маркетинг, используя опыт предыдущих кампаний. Более того, взаимодействие корпорации и клиента искажает бренд, расширяя долю рынка.')
            ->setAuthor($user)
            ->setCategory($category_os)
            ->addTag($tag2)
            ->addTag($tag4)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Пятая статья')
            ->setSlug('fifth')
            ->setAnnotation('Аннотация для пятой статьи.')
            ->setText('Взаимодействие корпорации и клиента амбивалентно. Агентская комиссия специфицирует мониторинг активности, используя опыт предыдущих кампаний. Ассортиментная политика предприятия развивает стратегический маркетинг, используя опыт предыдущих кампаний. Более того, взаимодействие корпорации и клиента искажает бренд, расширяя долю рынка.')
            ->setAuthor($user)
            ->setCategory($category_php)
            ->addTag($tag2)
            ->addTag($tag4)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Шестая статья')
            ->setSlug('sixth')
            ->setAnnotation('Аннотация для шестой статьи.')
            ->setText('Взаимодействие корпорации и клиента амбивалентно. Агентская комиссия специфицирует мониторинг активности, используя опыт предыдущих кампаний. Ассортиментная политика предприятия развивает стратегический маркетинг, используя опыт предыдущих кампаний. Более того, взаимодействие корпорации и клиента искажает бренд, расширяя долю рынка.')
            ->setCategory($category_html)
            ->setAuthor($user)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Седьмая статья')
            ->setSlug('art7')
            ->setAnnotation('Аннотация для шестой статьи.')
            ->setText('Взаимодействие корпорации и клиента амбивалентно. Агентская комиссия специфицирует мониторинг активности, используя опыт предыдущих кампаний. Ассортиментная политика предприятия развивает стратегический маркетинг, используя опыт предыдущих кампаний. Более того, взаимодействие корпорации и клиента искажает бренд, расширяя долю рынка.')
            ->setCategory($category_css)
            ->setAuthor($user)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Twitter')
            ->setSlug('art8')
            ->setAnnotation('Аннотация для шестой статьи.')
            ->setText('Взаимодействие корпорации и клиента амбивалентно. Агентская комиссия специфицирует мониторинг активности, используя опыт предыдущих кампаний. Ассортиментная политика предприятия развивает стратегический маркетинг, используя опыт предыдущих кампаний. Более того, взаимодействие корпорации и клиента искажает бренд, расширяя долю рынка.')
            ->setCategory($category_twitter_bootstrap)
            ->setAuthor($user)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Soft')
            ->setSlug('art9')
            ->setAnnotation('Аннотация для шестой статьи.')
            ->setText('Взаимодействие корпорации и клиента амбивалентно. Агентская комиссия специфицирует мониторинг активности, используя опыт предыдущих кампаний. Ассортиментная политика предприятия развивает стратегический маркетинг, используя опыт предыдущих кампаний. Более того, взаимодействие корпорации и клиента искажает бренд, расширяя долю рынка.')
            ->setCategory($category_soft)
            ->setAuthor($user)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Other')
            ->setSlug('art10')
            ->setAnnotation('Аннотация для шестой статьи.')
            ->setText('Взаимодействие корпорации и клиента амбивалентно. Агентская комиссия специфицирует мониторинг активности, используя опыт предыдущих кампаний. Ассортиментная политика предприятия развивает стратегический маркетинг, используя опыт предыдущих кампаний. Более того, взаимодействие корпорации и клиента искажает бренд, расширяя долю рынка.')
            ->setCategory($category_other)
            ->setAuthor($user)
        ;
        $manager->persist($article);

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}
