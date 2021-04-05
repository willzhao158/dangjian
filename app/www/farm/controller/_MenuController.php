<?php
/**
 * Created by sublime.
 * User: xiaoma
 * Date: 2019/9/19 
 * Time: 上午 9:24
 */
namespace app\farm\controller;

use cmf\controller\AdminBaseController;
use think\Db;
use app\farm\model\AdminMenuModel;
use tree\Tree;


class MenuController extends AdminBaseController
{
     public function initialize(){
        parent::initialize();
        $this->menu = new AdminMenuModel();
     }

     public function index()
     {
         $list = $this->menu->listmenu();
        return view();      
     }

     public function add(){
        $tree     = new Tree();
        $parentId = $this->request->param("id", 0, 'intval');
        $result   = Db::name('AdminMenu')->order(["list_order" => "ASC"])->select();
        $array    = [];
        foreach ($result as $r) {
            $r['selected'] = $r['id'] == $parentId ? 'selected' : '';
            $array[]       = $r;
        }
        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
        $tree->init($array);
        $selectCategory = $tree->getTree(0, $str);
        $this->assign("select_category", $selectCategory);
     	return view();
     }

     public function edit(){
        $id = input('id');
        $data = DB::name('AdminMenu')->find($id);
        $this->assign('data',$data);
        $parentId = $data['parent_id'];
        $tree     = new Tree();
        $result   = Db::name('AdminMenu')->order(["list_order" => "ASC"])->select();
        $array    = [];
        foreach ($result as $r) {
            $r['selected'] = $r['id'] == $parentId ? 'selected' : '';
            $array[]       = $r;
        }
        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
        $tree->init($array);
        $selectCategory = $tree->getTree(0, $str);
        $this->assign("select_category", $selectCategory);
        return view();
     }

     public function addaction(){
        $add = $this->menu->addmenu(input());
        if($add){
            return $this->success('添加成功');
        }
        return $this->error('添加失败');
     }

     public function editaction(){
        $add = $this->menu->editmenu(input());
        if($add){
            return $this->success('更新成功');
        }
        return $this->error('更新失败');
     }
        
	 public function all(){
        $checked = input('checked',false);
	    $list = $this->menu->listmenu($checked);
	    return $list;
	 }


     public function delmenu(){
        $del = $this->menu->delmenu(input('params'));
        if($del){
            return $this->success('删除成功');
        }
        return $this->error($del);
     }

}