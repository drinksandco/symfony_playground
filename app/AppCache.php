<?php

use Symfony\Bundle\FrameworkBundle\HttpCache\HttpCache;

class AppCache extends HttpCache
{
    protected function getOptions()
    {
        return array(
            'default_ttl'      => 20,
            'allow_reload'     => true,
            'allow_revalidate' => true
        );
    }
}
