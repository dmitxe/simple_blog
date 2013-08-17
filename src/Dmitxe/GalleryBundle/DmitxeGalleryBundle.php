<?php

namespace Dmitxe\GalleryBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DmitxeGalleryBundle extends Bundle
{
    public function getParent()
    {
        return 'SmartGalleryBundle';
    }
}
