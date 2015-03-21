<?php

namespace Crm\MessageBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CrmMessageBundle extends Bundle
{
	public function getParent()
    {
        return 'FOSMessageBundle';
    }
}
