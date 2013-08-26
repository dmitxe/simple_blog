<?php

namespace Dmitxe\ContactBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DmitxeContactBundle extends Bundle
{
    public function getParent()
    {
        return 'MremiContactBundle';
    }
}
