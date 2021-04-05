<?php
namespace app\admin\controller;
use think\DB;

class ContentController extends BaseController
{
    private $pagecount;
    //数据表名
    public $table = 'ny_banner';

    public $userinfo = '';

    public function initialize(){
        parent::initialize();
        
    }

    public function index(){

        $id = $this->request->param("id");

        $content = Db::table('ny_content')->where('id', $id)->find();

        $this->assign('id',$id);

        $this->assign('content',$content);

        return $this->fetch('content/index');
    }

    public function edit(){
        $id = $this->request->param("c_id");
        $content = $this->request->param("content");
        Db::table('ny_content')->where('id', $id)->update(['content' => htmlspecialchars($content)]);
        return $this->success('成功');
        var_dump($content);
    }

}