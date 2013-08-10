<?php

namespace SmartCore\Bundle\MediaBundle\Service;

use SmartCore\Bundle\MediaBundle\Entity\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CollectionService
{
    public function __construct()
    {
        // @todo
    }

    /**
     * @param UploadedFile $file
     * @return int - ID файла в коллекции.
     */
    public function createFile(UploadedFile $file)
    {
        // @todo
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteFile($id)
    {
        // @todo
    }

    /**
     * @param int|null $categoryId
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return File[]|null
     */
    public function getFilesList($categoryId = null, array $orderBy = null, $limit = null, $offset = null)
    {
        // @todo
    }

    /**
     * @param int $id
     * @param array|null $params
     * @return string
     */
    public function getUriByFileId($id, array $params = null)
    {
        // @todo
    }

    /**
     * @param int|null $categoryId
     */
    public function getCategories($categoryId = null)
    {
        // @todo подумать как лучше получать список категорий.
    }
}
