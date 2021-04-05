<?php
namespace app\mobile\controller;

use think\DB;

class ContentController extends BaseController
{
    

    public function initialize(){
        parent::initialize();
    }
    
    public function index()
    {
        $id = $this->request->param("id");
        
        $content = Db::table('ny_content')->where('id', $id)->find();

        $this->assign('content',$content);

        return $this->fetch('content/index');
    }

    
}