<?php

namespace app\www\controller;

use cmf\controller\HomeBaseController;

class BaseController extends HomeBaseController
{

    protected function initialize()
    {
        parent::initialize();


        //TODO module只允许绑定的域名访问 route.php
//        $domain = $this->request->domain();
//        var_dump($domain);
    }

}