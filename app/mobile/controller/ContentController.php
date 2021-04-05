<?php
namespace app\mobile\controller;

use think\DB;

class ContentController extends BaseController
{
    

    public function initialize(){
        //parent::initialize();
    }
    
    public function index()
    {
        $id = $this->request->param("id");
        
        $content = Db::table('ny_content')->where('id', $id)->find();

        if($id == 1){
            $content['tips'] = '操作教程';
        }elseif($id == 2){
            $content['tips'] = '推广规则';
        }elseif($id == 3){
            $content['tips'] = '账户注销';
        }elseif($id == 4){
            $content['tips'] = '用户注册协议';
        }elseif($id == 5){
            $content['tips'] = '隐私政策';
        }elseif($id == 6){
            $content['tips'] = '积分服务条款';
        }elseif($id == 7){
            $content['tips'] = '积分计划细则';
        }

        $this->assign('content',$content);

        return $this->fetch('content/index');
    }

    
}