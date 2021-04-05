<?php
namespace app\admin\controller;
use think\DB;

class ConfigController extends BaseController
{
    private $pagecount;
    //数据表名
    public $userinfo = '';

    public function initialize(){
        parent::initialize();
        
    }

    public function index(){

        $id = $this->request->param("id");

        $content = Db::table('ny_content')->where('id', $id)->find();

        return $this->fetch('content/index');
    }

}