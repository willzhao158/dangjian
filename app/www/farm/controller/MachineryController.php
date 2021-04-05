<?php
/**
 * Created by sublime.
 * User: xiaoma
 * Date: 2019/9/21
 * Time: 上午 13:50
 */
namespace app\farm\controller;


use app\farm\model\MachineryModel;


Class MachineryController extends FarmbaseController
{
	public function initialize(){
        parent::initialize();
        $this->table = '';
		$this->machinery = new MachineryModel();
	}

	public function index(){
		return view();
	}

    public function addclassify(){
        $this->assign("select_category", parent::machineryClassifyList(input('id')));
        return view();
    } 

	public function machinerylist(){
		return $this->machinery->machinerylist();
	}

	public function add(){
        $this->assign("select_category", parent::machineryClassifyList(input('id')));
		return view();
	}

	public function edit(){
		return view();
	}

	public function addaction(){
        $add = $this->machinery->addmachinery(input());
        if($add){
            return $this->success('添加成功');
        }
        return $this->error('添加失败');
     }

    public function editaction(){
        $edit = $this->machinery->editmachinery(input());
        if($edit){
            return $this->success('更新成功');
        }
        return $this->error('更新失败');
    }

    public function delaction(){
    	if($this->machinery->delmachinery(input())){
    		return $this->success('删除成功');
    	}
    	return $this->error('删除失败');
    }

    public function changeclassify(){
        $this->assign("select_category", parent::machineryClassifyList());
        return view();
    }
    
    public function changemachineryclassify(){
        $this->machinery->changemachineryclassify(input());
        return $this->success('农机类型修改成功');
    }
}