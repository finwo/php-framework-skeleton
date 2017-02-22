<?php

namespace Acme\AcmeBundle\Controller;

class DefaultController
{
    public function defaultAction()
    {
        return array(
            "status" => 200,
            "result" => "Raw data returning by controllers is supported"
        );
    }
}
