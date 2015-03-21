<?php

namespace Crm\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CrmUserBundle extends Bundle
{
	public function getParent()
    {
        return 'FOSUserBundle';
    }
}
