<?php

namespace SmartCore\Bundle\TexterBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use SmartCore\Bundle\TexterBundle\Event\FilterTexterEvent;
use SmartCore\Bundle\TexterBundle\Model\TexterInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Routing\RouterInterface;
use SmartCore\Bundle\TexterBundle\SmartTexterEvents;

class TexterService extends AbstractBlogService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var \SmartCore\Bundle\TexterBundle\Repository\TexterRepository
     */
    protected $tetxersRepo;

    /**
     * @param EntityManager $em
     * @param EntityRepository $textersRepo
     * @param EventDispatcherInterface $eventDispatcher
     * @param RouterInterface $router
     * @param int $itemsPerPage
     */
    public function __construct(
        EntityManager $em,
        EntityRepository $textersRepo,
        EventDispatcherInterface $eventDispatcher,
        RouterInterface $router,
        $itemsPerPage = 10)
    {
        $this->textersRepo     = $textersRepo;
        $this->em               = $em;
        $this->eventDispatcher  = $eventDispatcher;
        $this->router           = $router;
        $this->setItemsCountPerPage($itemsPerPage);
    }

    /**
     * @param int $id
     * @return TexterInterface|null
     */
    public function get($id)
    {
        return $this->textersRepo->find($id);
    }

    /**
     * @return TexterInterface[]|null
     * @throws \Exception
     *
     * @todo нормальный выброс исключения.
     */
    public function getAll()
    {
        if (null === $this->textersRepo) {
            throw new \Exception('Необходимо сконфигурировать тэги.');
        }

        return $this->textersRepo->findAll();
    }



    /**
     * @return TexterInterface
     */
    public function create()
    {
        $class = $this->textersRepo->getClassName();

        $texter = new $class('');

        $event = new FilterTexterEvent($texter);
        $this->eventDispatcher->dispatch(SmartTexterEvents::TEXTER_CREATE, $event);

        return $texter;
    }

    /**
     * @param TexterInterface $texter
     */
    public function update(TexterInterface $texter)
    {
        $event = new FilterTexterEvent($texter);
        $this->eventDispatcher->dispatch(SmartTexterEvents::TEXTER_PRE_UPDATE, $event);

        // @todo убрать в мэнеджер.
        $this->em->persist($texter);
        $this->em->flush($texter);

        $event = new FilterTexterEvent($texter);
        $this->eventDispatcher->dispatch(SmartTexterEvents::TEXTER_POST_UPDATE, $event);
    }

    /**
     * @return \Doctrine\ORM\Query
     */
    public function getFindAllQuery()
    {
        return $this->textersRepo->getFindAllQuery();
    }
}
