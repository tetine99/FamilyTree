<?php

namespace DL\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DLUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
