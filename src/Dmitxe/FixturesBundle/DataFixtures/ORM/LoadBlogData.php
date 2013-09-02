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
            ->setTitle('Symfony2')
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

        $category_debian = new Category();
        $category_debian
            ->setTitle('Debian')
            ->setSlug('debian')
            ->setParent($category_os)
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
        $tag8 = new Tag('Фреймворк');
        $tag8->setSlug('framework');
        $tag9 = new Tag('CMS');
        $tag10 = new Tag('Выбор');
        $tag10->setSlug('select');
        $tag11 = new Tag('Ckeditor');
        $tag12 = new Tag('Подключение');
        $tag12->setSlug('connect');
        $tag13 = new Tag('Форматирование');
        $tag13->setSlug('formatting');
        $tag14 = new Tag('Дата и время');
        $tag14->setSlug('date_and_time');
        $tag15 = new Tag('Редактор');
        $tag15->setSlug('editor');
        $tag16 = new Tag('Кодировка');
        $tag16->setSlug('encoding');
        $tag17 = new Tag('CSS');
        $tag18 = new Tag('Линейный градиент');
        $tag18->setSlug('linear_gradient');
        $tag19 = new Tag('Подсветка кода');
        $tag19->setSlug('code_illumination');
        $tag20 = new Tag('Twitter Bootstrap');
        $tag20->setSlug('twitter_bootstrap');
        $tag21 = new Tag('Формы');
        $tag21->setSlug('forms');
        $tag22 = new Tag('Visual Studio 2012 C++');
        $tag22->setSlug('visual_sStudio_2012_cpp');
        $tag23 = new Tag('phpStorm');
        $tag24 = new Tag('Memcached');
        $tag25 = new Tag('Debian');

        $article = new Article();
        $article->setTitle('Хлебные крошки в Yii')
            //->setEnabled(false)
            ->setSlug('breadcrumbs_yii')
            ->setAnnotation('Хлебные крошки (Breadcrumbs) - это строка навигации до текущей страницы, сделанная из ссылок на родительские элементы. В Yii есть удобное средство для работы с хлебными крошками - виджет zii CBreadcrumbs http://www.yiiframework.com/doc/api/1.1/CBreadcrumbs<br />
	Хочу описать, как подключить CBreadcrumbs.')
            ->setText('<p></p>
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
            ->setDescription('Как создать хлебные крошки в Yii')
            ->setKeywords('Yii, хлебные крошки')
            ->setCreatedAt(new \DateTime('2011-11-26 10:06:15'))
            ->addTag($tag5)
            ->addTag($tag6)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Как подключить Ckeditor к фреймворку Yii')
            //->setEnabled(false)
            ->setSlug('how_to_connect_ckeditor_to_framework_yii')
            ->setAnnotation('Часто возникает необходимость использовать визуальный редактор на сайте. Есть несколько весьма популярных WYSIWYNG-редакторов. Один из них - Ckeditor. Сегодня я расскажу, как подключить Ckeditor к Yii.')
            ->setText('<p></p>
<hr id="readmore" />
<p>
	Шаг первый: скачиваем сам редактор с официального сайта: <a href="http://ckeditor.com/download" target="_blank">http://ckeditor.com/download</a><br />
	Распаковываем архив в корень сайта.<br />
	Шаг второй: скачиваем расширение Yii ckeditor-integration <a href="http://www.yiiframework.com/extension/ckeditor-integration/">отсюда</a>.<br />
	Распаковываем в папку protected/extensions.<br />
	Шаг третий: подключаем к форме наш редактор:</p>
<div class="highlight">
	<pre class="brush: php">
&lt;?php
$this-&gt;widget(&#39;ext.ckeditor.CKEditorWidget&#39;,array(
  &quot;model&quot;=&gt;$model,                 # Модель данных
  &quot;attribute&quot;=&gt;&#39;content&#39;,          # Аттрибут в модели
  &quot;defaultValue&quot;=&gt;$model-&gt;content, #Значение по умолчанию

  &quot;config&quot; =&gt; array(
      &quot;height&quot;=&gt;&quot;400px&quot;,
      &quot;width&quot;=&gt;&quot;100%&quot;,
      &quot;toolbar&quot;=&gt;&quot;Full&quot;, #панель инструментов
      &quot;defaultLanguage&quot;=&gt;&quot;ru&quot;, # Язык по умолчанию
      ),
   &quot;ckEditor&quot;=&gt;Yii::app()-&gt;basePath.&quot;/../ckeditor/ckeditor.php&quot;,
                                  # Путь к ckeditor.php
  &quot;ckBasePath&quot;=&gt;Yii::app()-&gt;baseUrl.&quot;/ckeditor/&quot;,
                                  # адрес к редактору
  ) ); ?&gt;</pre>
</div>
<div class="code">
	Все параметры конфига редактора смотрим <a href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">здесь</a></div>
')
            ->setAuthor($user)
            ->setDescription('В статье рассказывается о том, как быстро и правильно подключить Ckeditor к Yii')
            ->setKeywords('Yii, Ckeditor, подключение')
            ->setCategory($category_yii)
            ->setCreatedAt(new \DateTime('2011-11-23 13:20:50'))
            ->addTag($tag6)
            ->addTag($tag11)
            ->addTag($tag12)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Форматирование даты и времени в Yii')
            //->setEnabled(false)
            ->setSlug('formatting_of_date_and_time_in_yii')
            ->setAnnotation('Передо мной встала такая задача: как в Yii вывести дату, отформатированную в родном, русском формате. Оказывается, очень просто. Во-первых, надо установить русский язык в конфигурационном файле приложения, и, во-вторых, воспользоваться методом компонента&nbsp; приложения CDateFormatter-&gt;format().')
            ->setText('<p></p>
<hr id="readmore" />
<p>
	Итак, приступим. В конфигурационном файле пропишем две строчки, которые установят русификацию для сайта:</p>
<div class="highlight">
	<pre class="brush: php">
   &#39;sourceLanguage&#39; =&gt; &#39;en&#39;,
    &#39;language&#39; =&gt; &#39;ru&#39;,</pre>
</div>
<p>
	Здесь sourceLanguage &ndash; язык, на котором написан сам сайт. У меня он, естественно, английский. Ну а текущий язык &ndash; language &ndash; русский.<br />
	Теперь в том месте, где хотим вывести отформатированную дату, добавим такой код:</p>
<div class="highlight">
	<pre class="brush: php">
	echo Yii::app()-&gt;dateFormatter-&gt;format(&quot;dd MMMM y, HH:mm&quot;, $vardatetime);</pre>
</div>
<p>
	Выведет дату и время в таком формате:&nbsp; 29 ноября 2011, 16:41<br />
	Метод format принимает два параметра: первый &ndash; шаблон времени в стандарте Юникода, второй &ndash; время в unix timestamp или Mysql DATETIME. Вот и всё.<br />
	Более подробно о CDateFormatter смотрите <a href="http://www.yiiframework.com/doc/api/1.1/CDateFormatter" target="_blank">здесь</a><br />
	&nbsp;</p>
<p>
	&nbsp;</p>
')
            ->setAuthor($user)
            ->setDescription('Как правильно и грамотно отформатировать дату и время в Yii')
            ->setKeywords('Yii, формат, дата')
            ->setCategory($category_yii)
            ->setCreatedAt(new \DateTime('2012-02-25 15:28:38'))
            ->addTag($tag6)
            ->addTag($tag13)
            ->addTag($tag14)
        ;
        $manager->persist($article);


        $article = new Article();
        $article->setTitle('Symfony2: справочник команд')
            ->setSlug('symfony2_spravochnik_komand')
            ->setSlug('s2_sik_knd')
            ->setAnnotation('В этой статье буду писать самые часто используемые команды Симфони. Как ни странно, но на Симфони без командной строки ну никак. Полгода-год назад помнил многие команды наизусть, а сейчас, особенно после работы с Магенто, в голове чистый лист.')
            ->setText('<p></p>
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
            ->setDescription('Самые часто используемые команды  Symfony2')
            ->setKeywords('Symfony, команды')
            ->setCategory($category_symfony2)
            ->setCreatedAt(new \DateTime('2013-08-07 17:19:21'))
            ->addTag($tag2)
            ->addTag($tag7)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Подсвечиваем код на сайте')
            ->setSlug('highlight_code_on_site')
            ->setAnnotation('Давно мечтал о нормальной подсветке кода php, html и css. Наконец-то у меня выдалось время и я посветил этому вопросу несколько часов. Итак, небольшой обзор существующих способов подсветки показал, что её (подсветку) можно делать или не стороне клиента, или на стороне сервера. Для себя я сразу решил, что свой сервер грузить лишней работой не стоит. В общем, решил искать реализацию на JavaScript. Конечно, при отключённом js мои посетители не увидят подсветки, но таких, надеюсь, будет мало))')
            ->setText('<p></p>
<hr id="readmore" />
<p>
	После гугления наткнулся на симпатичную статью. В ней описывался компактный скрипт highlight: <a href="http://softwaremaniacs.org/soft/highlight/">http://softwaremaniacs.org/soft/highlight/</a></p>
<p>
	Увы, после подключения подсветки кода я не увидел. Зато мой &laquo;любимый&raquo; IE подсветил ошибку на JavaScript. Мол, объект не поддерживает какое-то там свойство. Как Вы наверное понимаете, копаться в чужом коде и искать ошибку я не стал. Не подключается &ndash; и ладно, ищем другой скрипт.</p>
<p>
	Кандидатом номер два стал SyntaxHighlighter от Alex Gorbatchev. Особенность скрипта &ndash; что он не требует jQuery (хотя я не считаю это преимуществом) и можно указать только те языки, которые нужны. &nbsp;После скачивания и настройки подсветка кода тут же заработала, что очень и очень меня порадовало!</p>
<p>
	Архив качаем отсюда: <a href="http://alexgorbatchev.com/SyntaxHighlighter/download/">http://alexgorbatchev.com/SyntaxHighlighter/download/</a></p>
<p>
	Расскажу о некоторых особенностях настройки. Извлеките из скаченного архива и подключите следующие файлы:</p>
<ol>
	<li>
		shCore.js</li>
	<li>
		shCore.css</li>
	<li>
		shThemeDefault.css</li>
</ol>
<p>
	Далее определитесь с языками, подсветка коих Вам нужна. Так, я выбрал себе css, html и php. Чтобы они заработали, надо подключить следующие файлы:&nbsp; shBrushCss.js,&nbsp; shBrushXml.js, shBrushPhp.js.</p>
<p>
	И последний шаг &ndash; инициализация скрипта. Добавьте скрипт со строчкой</p>
<pre class="brush: js; toolbar: true;">
SyntaxHighlighter.all();</pre>
<p>
	- и подсветка заработает.</p>
<p>
	&nbsp;</p>
<p>
	На этом собственно все. Заключительный штрих &ndash; у себя я отключил боковую панельку (полоса прокрутки+ссылка на сайт автора) командой SyntaxHighlighter.defaults[&#39;toolbar&#39;] = false;</p>
<p>
	Как пользоваться подсветкой? Используйте тег &lt;pre&gt;с классом brush:[язык подсветки]. Т.е. для php это будет выглядеть так:</p>
<p>
	&nbsp;</p>
<pre class="brush: js; toolbar: true;">
	&lt;pre class=&quot;brush: php; toolbar: true;&quot;&gt;echo &quot;Привет, мир!&quot;; &lt;/pre&gt;</pre>
<p>
	&nbsp;</p>
<p>
	Скриптом я доволен.</p>
')
            ->setCategory($category_js)
            ->setDescription('Как подсветить код на сайте: используем highlight')
            ->setKeywords('подсветка кода, highlight')
            ->setCreatedAt(new \DateTime('2013-01-29 17:28:47'))
            ->addTag($tag19)
            ->setAuthor($user)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Настройка Symfony2 в PhpStorm')
            ->setSlug('adjustment_symfony2_in_phpstorm')
            ->setAnnotation('По горячим следам, пока помню, напишу об интеграции поддержки Symfony2 в phpStorm.')
            ->setText('<p></p>
<hr id="readmore" />
<p>
	Нам потребуется плагин: <a href="http://plugins.jetbrains.com/plugin/7219?pr=phpStorm">http://plugins.jetbrains.com/plugin/7219?pr=phpStorm</a></p>
<p>
	Устанавливаем его (File-&gt;Settings-&gt;Plugins, кнопка Install From Disk)</p>
<p>
	Перезапуcкаем PhpStorm. Идем в File-&gt;Settings-&gt;Symfony2 Plugin, ставим галку на Enable Plugin, проверяем пути (у меня var/cache/dev/appDevUrlGenerator.php и var/cache/dev/translations), в Container добавляем путь.</p>
<p>
	Ввводим команду php bin/warmup_cache</p>')
            ->setCategory($category_symfony2)
            ->setDescription('Интеграции поддержки Symfony2 в phpStorm')
            ->setKeywords('phpStorm, Symfony2')
            ->setCreatedAt(new \DateTime('2013-08-10 10:14:05'))
            ->addTag($tag2)
            ->addTag($tag23)
            ->setAuthor($user)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Ссылки на Symfony2')
            ->setSlug('fourth')
            ->setAnnotation('Ссылки на полезную литературу по Symfony2')
            ->setText('<p></p>
<hr id="readmore" /><p>Работа с контейнером сервисов: <a href="http://symfony.com/doc/current/book/service_container.html" target="_blank">http://symfony.com/doc/current/book/service_container.html</a></p>
<p>Поиск бандлов для Symfony2: на сайте <a href="http://knpbundles.com/" target="_blank">KnpBundles</a></p>')
            ->setAuthor($user)
            ->setCategory($category_symfony2)
            ->setCreatedAt(new \DateTime('2013-08-10 10:14:05'))
            ->addTag($tag2)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Установка Memcached на Windows 7 x64 (php 5.4.17)')
            ->setSlug('installation_memcached_on_windows7_x64_php_5_4_17')
            ->setAnnotation('Встала задача поставить себе memcached. В интернете есть много мануалов, но они в основном под 32-разрядные версии. Т.к. у меня 64-разрядный php, то возникли определенные трудности…')
            ->setText('<p></p>
<hr id="readmore" />
<p>
	Начать с того, что 64-раздяную версию самого &nbsp;memcache найти не так-то просто. На официальном сайт лежат сырые исходники: <a href="http://code.google.com/p/memcached/downloads/list">http://code.google.com/p/memcached/downloads/list</a></p>
<p>
	Компилировать их показалось задачей сложной и страшной. После интенсивного поиска в гугле нашел вот <a href="http://s3.amazonaws.com/downloads.northscale.com/memcached-win64-1.4.4-14.zip">тут</a> файлы версии 1.4.4-14 под Windows x64. Версия устаревшая, но выхода у меня не было (гугл показывал еще более старые версия), скачал себе эту.</p>
<p>
	Создал на диске себе папку <strong>memcached</strong> &nbsp;и распаковал туда архив. Далее запустил командную строку (от имени Администратора!) и выполнил</p>
<pre class="brush: php; toolbar: true;">
	C:\memcached\memcached.exe -d install</pre>
<p>
	Пошел смотреть в Службы, как встал memcached (Панель управления-&gt;Администрирование-&gt;Службы) &ndash; служба с таким именем появилась. Запустил её, в свойствах прописал автоматический запуск.</p>
<p>
	Осталось только подключиться к php. После поисков нашел тут: <a href="http://www.mediafire.com/download/8d3vd26z3fg6bf1/php_memcache-svn20120301-5.4-VC9-x64.zip">http://www.mediafire.com/download/8d3vd26z3fg6bf1/php_memcache-svn20120301-5.4-VC9-x64.zip</a> - похожее на нужную версию.</p>
<p>
	Однако при копировании вдруг обнаружил, что расширение (у меня php 5.4.17) php_memcache.dll уже есть&hellip; Решил, что &laquo;из коробки&raquo; будет надежнее.</p>
<p>
	Прописал в php.ini в разделе с расширениями</p>
<pre class="brush: php; toolbar: true;">
	[PHP_MEMCACHED]
	extension = php_memcache.dll</pre>
<p>
	Перезапустил апач, убедился, что php_info() вывел memcache</p>
<p>
	Запустил тестовый файлик, ничего не сломалось.&nbsp; Ну посмотрим, как дальше себя поведет php&hellip;</p>
<p>
	P.S. Так файлы на просторах интернета имеет тенденцию теряться (сколько я нерабочих ссылок сегодня нашел!), то прикладываю свой архивчик: <a href="/media/memcached.zip">скачать</a></p>
')
            ->setAuthor($user)
            ->setCategory($category_php)
            ->setDescription('Как установить поддержку Memcached php 5.4 на Windows 7 x64')
            ->setKeywords('php 5.4, Memcached, Windows 7 x64')
            ->setCreatedAt(new \DateTime('2013-08-27 19:38:21'))
            ->addTag($tag1)
            ->addTag($tag24)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Debain7 – горячие команды сервера')
            ->setSlug('debain7_hot_commands_of_the_server')
            ->setAnnotation('Тут собрал команды, которые все время приходится использовать на сервере (ОС – Debain7)')
            ->setText('<hr id="readmore" />
<p>Запуск apache:</p>
<div class="highlight">	<pre class="brush: cpp">/etc/init.d/apache2 start</pre></div>
<p>Остановка apache:</p>
<div class="highlight">	<pre class="brush: cpp">/etc/init.d/apache2 stop</pre></div>
<p>Перезапуск apache:</p>
<div class="highlight">	<pre class="brush: cpp"> /etc/init.d/apache2 restart</pre></div>
')
            ->setCategory($category_debian)
            ->setDescription('Часто используемые команды в Debain7')
            ->setKeywords('Debain7, команды')
            ->setCreatedAt(new \DateTime('2013-08-29 22:09:51'))
            ->addTag($tag7)
            ->addTag($tag25)
            ->setAuthor($user)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('CSS – линейный градиент фона')
            ->setSlug('css_linear_gradient_of_background')
            ->setAnnotation('Как сделать градиент фону, не прибегая к помощи фоновых рисунков? Современные браузеры поддерживают градиентную заливку с помощью CSS.')
            ->setText('<p></p>
<hr id="readmore" />
<div class="highlight">
	<pre class="brush: css">
background:#EFEFEF; /*цвет фона кнопки для браузеров без поддержки CSS3*/
background: -webkit-gradient(linear, left top, left bottom, from(#3437CD), to(#538BFF)); /* для Webkit браузеров */
background: -moz-linear-gradient(top,  #3437CD, #538BFF); /* для Firefox */
background-image: -o-linear-gradient(top,  #3437CD,  #538BFF); /* для Opera 11 */
filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr=&#39;#3437CD&#39;, endColorstr=&#39;#538BFF&#39;); /* фильтр для IE */

</pre>
</div>
<p>
	Чтобы сохранить&nbsp; кроссбраузерность, приходиться писать под каждый интернет-браузер отдельное правило CSS. Особо обрабатывается IE.&nbsp; В каждом правиле участвует два цвета &ndash; начальный и конечный.</p>
')
            ->setCategory($category_css)
            ->setDescription('Создание градиента без помощи фоновых рисунков')
            ->setKeywords('градиент фона, css')
            ->setCreatedAt(new \DateTime('2012-02-25 17:03:11'))
            ->addTag($tag17)
            ->addTag($tag18)
            ->setAuthor($user)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Подключаем Twitter Bootstrap к Yii')
            ->setSlug('connect_twitter_bootstrap_to_yii')
            ->setAnnotation('Совсем недавно мне рассказали о такой классной вещи, как фреймворк css от Твиттера - Twitter Bootstrap. Раньше, максимум, что я использовал - это "reset css". Все остальное писал ручками. Каждый раз - одно и то же. Что, понятно, отрицательно сказывалось на производительности. Немного поработав с этим фреймворком (оформление админки на Симфони 2) - пришел к выводу, что вещь это безусловно полезная. Реально ускоряет работу в разы. И вот я решил перевести и свой блог на Yii к этому же виду.')
            ->setText('<p></p>
<hr id="readmore" />
<p>
	Перво-наперво скачал сам Twitter Bootstrap с гитхаба: <a href="https://github.com/twitter/bootstrap">https://github.com/twitter/bootstrap</a>. Т.е я качал вместе с исходниками на языку less, т.к. планировал самостоятельно компилировать из них css. Вы же может скачать уже скомпилированные файлы, например, отсюда: <a href="http://bootstrap.veliovgroup.com/">http://bootstrap.veliovgroup.com/</a> Но в этом случае уже нельзя будет изменять расцветку ну и вообще вносить изменения&hellip; В общем, я остановился на сырых исходниках.</p>
<p>
	Компилировать исходники less я решил с помощью расширения Yii-less: <a href="http://www.yiiframework.com/extension/yii-less/">http://www.yiiframework.com/extension/yii-less/</a></p>
<p>
	Скачиваем данное расширение, ложем его в папку protected/extensions. В конфиге регистрируем новый&nbsp; behaviors:</p>
<pre class="brush: php; toolbar: true;">
	&#39;behaviors&#39;=&gt;array(
	    &#39;ext.yii-less.components.LessCompilationBehavior&#39;,
	)
</pre>
<p>
	Регистрируем расширение как компонент:</p>
<pre class="brush: php; toolbar: true;">
&#39;components&#39;=&gt;array(
  &#39;lessCompiler&#39;=&gt;array(
    &#39;class&#39;=&gt;&#39;ext.yii-less.components.LessCompiler&#39;,
    &#39;paths&#39;=&gt;array(
      // you can access to the compiled file on this path
      &#39;/css/bootstrap.css&#39; =&gt; array(
        &#39;precompile&#39; =&gt; true, // whether you want to cache the generation
        &#39;paths&#39; =&gt; array(&#39;/less/bootstrap.less&#39;) //paths of less files. you can specify multiple files.
      ),
    ),
  ),
),
</pre>
<p>
	&nbsp;</p>
<p>
	И в лайоте пишем Yii::app()-&gt;clientScript-&gt;registerCssFile(&#39;/css/bootstrap.css&#39;)</p>
<p>
	Все, теперь при первом запуске в нашем ассете будет новый файл. Как альтернатива &ndash; можно компилировать файлы на стороне клиента (<a href="https://github.com/cloudhead/less.js">https://github.com/cloudhead/less.js</a>)&nbsp; &ndash; но, на мой взгляд, это сильно скажется на производительности&hellip;.</p>
<p>
	Одной проблемой меньше. Остался вопрос с подсветкой кода на less. Мой редактор (NetBeans) по умолчанию не распознает less. Исправляем это с помощь плагина scss-editor <a href="http://code.google.com/p/scss-editor/">http://code.google.com/p/scss-editor/</a></p>
<ol>
	<li>
		Качаем плагин, ставим его в NetBeans</li>
	<li>
		Ассоциируем с ним файлы Less &ndash; Сервис -&gt;Параметры -&gt;Файлы,&nbsp; создаем новое расширение less и в списке &laquo;Связанный тип файлов&raquo; задаем ему &laquo;text/x-scss&raquo;</li>
</ol>
<p style="margin-left:18.0pt;">
	Перезапускаем NetBeans &ndash; и подсветка появилась!</p>
<p style="margin-left:18.0pt;">
	Напоследок замечу, что для Yii есть готовое решение в виде расширения yii-bootstrap: <a href="http://www.cniska.net/yii-bootstrap/" target="_blank">http://www.cniska.net/yii-bootstrap/</a> - но я его не пробовал. Лень разбираться&hellip;</p>
	<p><b>UPD</b> На Symfony2 этот же дизайн встал без проблем</p>
')
            ->setCategory($category_twitter_bootstrap)
            ->setDescription('Как подключить Twitter Bootstrap к Yii')
            ->setKeywords('yii, twitter bootstap, подключение')
            ->setCreatedAt(new \DateTime('2013-01-29 17:42:26'))
            ->addTag($tag6)
            ->addTag($tag12)
            ->addTag($tag20)
            ->setAuthor($user)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Создаем формы в Visual Studio 2012')
            ->setSlug('create_forms_in_visual_sStudio_2012')
            ->setAnnotation('Сегодня решил повозиться с Microsoft Visual Studio 2012 C++ - попробовать создать свою форму. Начал искать компоненты (как в Delphi) - но нигде их не нашел!')
            ->setText('<p></p>
<hr id="readmore" />
<p>
	Погуглил и понял, что именно в 2012 версии, именно для языка C++ разработчики решили убрать поддержку Windows Forms Application. На просторах буржуйского интернета нашел замечательное решение. Нужно скачать шаблон <a href="http://dmitxe.ru/media/VS2012CPPWinForms.zip">http://dmitxe.ru/media/VS2012CPPWinForms.zip</a> и скопировать его в C:\Program Files (x86)\Microsoft Visual Studio 11.0\VC\vcprojects\vcNET\ - при этом лучше на всякий случай сделать бэкап файла &quot;vcNET.vsdir&quot;. Использование: Файл-&gt;Проект-&gt;Шаблоны-&gt;Visual C++ -&gt; CLR-&gt;MC++ WinApp</p>
<p>
	Источник:&nbsp; <a href="http://www.t-hart.org/vs2012/">http://www.t-hart.org/vs2012/</a></p>
')
            ->setCategory($category_cpp)
            ->setDescription('Как создать приложение Windows Forms Application в Visual Studio 2012 C++')
            ->setKeywords('форма, Visual Studio 2012 C++')
            ->setCreatedAt(new \DateTime('2013-06-06 20:31:23'))
            ->addTag($tag21)
            ->addTag($tag22)
            ->setAuthor($user)
        ;
        $manager->persist($article);


        $article = new Article();
        $article->setTitle('NotePad++')
            ->setSlug('notepad_plus_plus')
            ->setAnnotation('Часто возникает необходимость быстрой перекодировки файла (например, из ansi в utf8, или наоборот). Есть замечательный (и притом бесплатный) редактор - NotePad++. С помощью него можно легко перекодировать файл из одной кодировки в другую. В этом редакторе есть даже подсветка кода. Конечно, я предпочитаю работать где-нибудь в Adobe Dreamweaver, NuSphere PHPED или в NetBeans. Но эти монстры подолгу грузятся, а иногда хочется быстро подправить код и тут же закрыть файл. Для этого как раз подойдёт NotePad++')
            ->setText('<p></p>
<hr id="readmore" />
<p>
	Есть одна особенность перекодирования в utf8. Для преобразования кодировки&nbsp; файла выбираем в меню &laquo;Кодировки&raquo;-&gt; &laquo;Преобразовать в utf8&nbsp; без BOM&raquo;. Если выбрать просто &laquo;Преобразовать в utf8&raquo;, тогда случиться трагедия &ndash; страница перестанет правильно отображаться в браузере. Преобразование в ANSI таких проблем не имеет &ndash; есть только одно действие.<br />
	Программа качается <a href="http://notepad-plus-plus.org/download/" target="_blank">отсюда</a>.<br />
	&nbsp;</p>
')
            ->setCategory($category_soft)
            ->setDescription('Как перекодировать файл с помощью NotePad++')
            ->setKeywords('редактор, кодировка')
            ->setCreatedAt(new \DateTime('2012-02-25 15:34:43'))
            ->addTag($tag15)
            ->addTag($tag16)
            ->setAuthor($user)
        ;
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Что выбрать: фреймворк или CMS')
            ->setSlug('framework_vs_cms')
            ->setAnnotation('Свое знакомство с сайтостроением я начал с написания простейшего кода на HTML. Сайт получился, естественно, статическим. Следующий проект делал уже на PHP. Времени на написание ушло много, в результате у меня начала создаваться собственная CMS. К сожалению, данный факт осмыслил не сразу. А как только понял, что приду к CMS, решил не изобретать велосипед, освоил Joomla и WordPress.')
            ->setText('<p></p>
<hr id="readmore" />
<p>
	&nbsp;Разработка стандартных сайтов (блогов, форумов и т.д.) пошла на ура. Но вся проблема оказалась в том, что многим заказчикам нужна некая особая, нестандартная функциональность. Реализовать которую в рамках данной CMS оказывается совсем непросто. Приходиться писать новые расширения или модифицировать существующий код. Времени такая работа занимает много, к тому же из-за взаимодействия с ядром CMS код не оптимальный. В общем, встал вопрос &ndash; что же проще &ndash; писать свою CMS или мучиться с существующими.</p>
<p>
	И тут я вспомнил о фреймворках. &nbsp;Фреймворк &ndash; это каркас для веб-приложения, а CMS &ndash; готовая система управления контентом. Наверное, можно фреймворк можно сравнить с кирпичами, из которых можно построить самые причудливые строения, а CMS &ndash; это стандартный дом.</p>
<p>
	После обзора самых популярных фреймворков я остановил свой выбор на Yii. Понравился достаточно строгий подход, относительная простота изучения (конечно, CodeIgniter осваивается легче, но возможности Yii богаче).</p>
<p>
	Теперь написать собственную, уникальную CMS стало гораздо проще. Конечно, стандартные проекты быстрее реализовать на готовой CMS, но многие проекты имею тенденцию превращаться из стандартных в нестандартные.</p>
<p>
	Этот блог я написал на Yii. А вот другой мой блог &ndash; netopus.ru написан CMS WordPress. Использовалась одна из бесплатных тем для WordPress.</p>
<p><b>UPD</b> В сентябре 2013 года блог перешел на Symfony2 (движок SmartCore)</p>
')
            ->setCategory($category_other)
            ->setDescription('Преимущества и недостатки фреймворка над CMS')
            ->setKeywords('фреймворк, CMS, выбор')
            ->setCreatedAt(new \DateTime('2011-11-23 13:15:19'))
            ->addTag($tag8)
            ->addTag($tag9)
            ->addTag($tag10)
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
