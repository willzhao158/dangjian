<?php
namespace app\farm\model;

use think\Model;
use think\Db;

Class MachineryClassifyModel extends Model
{

	public function addmenu($data){
		$save = $this->allowField(true)->save($data);
		if(!$save){
			return [false,$data];
		}
		return [true,$save];
	}

	public function editmenu($data){
		$save = $this->allowField(true)->update($data);
		if(!$save){
			return [false,$data];
		}
		return [true,$save];
	}


	public function listmenu($checked=true){
    	$list = $this->getauthaccess(input('role_id',7));
		return $this->getTree($this->getMenu(),0,$list,$checked);
	}


	public function getMenu(){
		return $this->field('id,parent_id as pid,name as title,app')->select()->toArray();
	}

	private function getauthaccess($role=7){
		return DB::name('auth_access')->where(['role_id'=>$role])->column('rule_name');
	}


	private function _isChecked($menu, $privData)
    {
        $app    = $menu['app'];
        $model  = $menu['controller'];
        $action = $menu['action'];
        $name   = strtolower("$app/$model/$action");
        if ($privData) {
            if (in_array($name, $privData)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }



	//菜单数组分级
	public function getTree($list, $pid = 0,$rulename='',$checked=false)
	  {
	      $tree = [];
	      if (!empty($list)) {
	          $newList = [];
	          foreach ($list as $k => $v) {
	          	  if($rulename){
	          	  	$checked = $this->_isChecked($v,$rulename);
		            if($checked){
		             	$v['checked'] = true;
		            }
	          	  }
	          	  $v['spread'] = true;
	              
	              $newList[$v['id']] = $v;
	          }
	          foreach ($newList as $value ) {
	              if ($pid == $value['pid']) {
	                $tree[] = &$newList[$value['id']];
	              } elseif (isset($newList[$value['pid']]))
	              {
	                  $newList[$value['pid']]['children'][] = &$newList[$value['id']];
	              }
	          }
	          // 如果顶级分类下没有一个下级，删除此分类，此步骤可以省略
	          // foreach ($tree as $k=>$v)
	          // {
	          //     if(!isset($v['children']) && ($pid<1))
	          //         unset($tree[$k]);
	          // }
	      }
	      return $tree;
	  }

	 public function layuiReturn($data,$count,$msg){

	 }

	 private function checkchild($id){
	 	return $this->where(['parent_id'=>$id])->find();
	 }

	 public function delmenu($params){
	 	if(!is_array($params)){
	 		$params = explode(',', $params);
	 	}
	 	foreach($params as $v){
	 		if($this->checkchild($v)){
	 			return false;
	 		}
	 	}
	 	return $this->where(['id'=>['in',implode(',', $params)]])->delete();
	 }

}