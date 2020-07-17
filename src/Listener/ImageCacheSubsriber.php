<?php

namespace App\Listener;

use App\Entity\Document;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Events;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSusbriber implements EventSubscriber
{
    /**
     * @var CacheManager
     */
    private $cache;

    /**
     * @var UploaderHelper
     */
    private $helper;

    public function __construct(CacheManager $cache, UploaderHelper $helper)
    {
        $this->cache = $cache;
        $this->helper = $helper;
    }

    public function getSubscribedEvents()
    {
        return
            [

                Events::postUpdate,

            ];
    }



    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity=$args->getEntity();
        if(!$entity instanceof Document)
        {
            return;
        }
        if($entity->getImageFile() instanceof UploadedFile )
        {
            $this->cache->remove($this->helper->asset($entity,'imageFile'));
        }

      /*  $entity = $args->getObject();
        $entityManager = $args->getObjectManager();

        if (!$entity instanceof Document) {
            return;
        }
        if ($entity->getImageFile() instanceof UploadedFile) {
            $this->cache->remove($this->helper->asset($entity, 'imageFile'));
        }*/
    }
}
