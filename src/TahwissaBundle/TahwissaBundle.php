<?php

namespace TahwissaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TahwissaBundle extends Bundle
{
    public function getParent(){
        return 'FOSUserBundle';
    }
}
