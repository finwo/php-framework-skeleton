<?php

namespace Acme\AcmeBundle\Controller;

use Finwo\Framework\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function defaultAction()
    {
        return array(
            "status" => 200,
            "result" => "Raw data returning by controllers is supported"
        );
    }
}
