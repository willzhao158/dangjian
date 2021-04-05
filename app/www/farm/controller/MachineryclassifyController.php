<?php
/**
 * Created by sublime.
 * User: xiaoma
 * Date: 2019/9/19 
 * Time: 上午 9:24
 */
namespace app\farm\controller;
use app\farm\model\MachineryClassifyModel;

class MachineryClassifyController extends FarmbaseController
{
     public function initialize(){
        parent::initialize();
        $this->classify = new MachineryClassifyModel();
     }

     public function index()
     {
        return view();      
     }

     public function add(){
        $this->assign("select_category", parent::machineryClassifyList());
     	return view("Machinery/addclassify");
     }

     public function edit(){
        $id = input('id');
        $data = DB::name('MachineryClassify')->find($id);

        $this->assign('data',$data);
        $this->assign("select_category", parent::machineryClassifyList($data['parent_id']));
        return view();
     }

     public function addaction(){
        $add = $this->classify->addmenu(input());
        if($add){
            return $this->success('添加成功');
        }
        return $this->error('添加失败');
     }

     public function editaction(){
        $edit = $this->classify->editmenu(input());
        if($edit){
            return $this->success('跟新成功');
        }
        return $this->error('更新失败');
     }
        
	 public function all(){
        $checked = input('checked',false);
	    $list = $this->classify->listmenu($checked);
	    return $list;
	 }


     public function delmenu(){
        if($this->classify->delmenu(input('params'))){
            return $this->success('删除成功');
        }
        return $this->error('请先删除子栏目');
     }

}