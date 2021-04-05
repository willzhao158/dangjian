<?php
/**
 * Created by sublime.
 * User: xiaoma
 * Date: 2019/9/20
 * Time: 上午 14:01
 */
namespace app\farm\controller;

use cmf\controller\AdminBaseController;
use app\farm\model\RoleModel;
use app\farm\model\AdminMenuModel;
use think\Db;
Class RoleController extends AdminBaseController
{
	public function initialize(){
        parent::initialize();
        
        $this->role = new roleModel();
		$this->menu = new AdminMenuModel();
	}

	public function index(){
    
		return view();
	}

	public function rolelist(){
		return $this->role->rolelist();
	}

	public function add(){
		return view();
	}

	public function edit(){
		return view();
	}

	public function auth(){
		$this->assign('roleId',input('roleId'));
		return view();
	}

	public function addaction(){
        $add = $this->role->addrole(input());
        if($add){
            return $this->success('添加成功');
        }
        return $this->error('添加失败');
     }

    public function editaction(){
        $add = $this->role->editrole(input());
        if($add){
            return $this->success('更新成功');
        }
        return $this->error('更新失败');
    }

    public function delaction(){
    	if($this->role->delrole(input())){
    		return $this->success('删除成功');
    	}
    	return $this->error('删除失败');
    }


    public function authorizePost()
    {
        if ($this->request->isPost()) {
            $roleId = $this->request->param("roleId", 0, 'intval');
            if (!$roleId) {
                $this->error("需要授权的角色不存在！");
            }
            if (is_array($this->request->param('menuId/a')) && count($this->request->param('menuId/a')) > 0) {

                Db::name("authAccess")->where(["role_id" => $roleId, 'type' => 'admin_url'])->delete();
                foreach ($_POST['menuId'] as $menuId) {
                    $menu = Db::name("adminMenu")->where(["id" => $menuId])->field("app,controller,action")->find();
                    if ($menu) {
                        $app    = $menu['app'];
                        $model  = $menu['controller'];
                        $action = $menu['action'];
                        $name   = strtolower("$app/$model/$action");
                        Db::name("authAccess")->insert(["role_id" => $roleId, "rule_name" => $name, 'type' => 'admin_url']);
                    }
                }

                cache(null, 'admin_menus');// 删除后台菜单缓存

                $this->success("授权成功！");
            } else {
                //当没有数据时，清除当前角色授权
                Db::name("authAccess")->where(["role_id" => $roleId])->delete();
                $this->error("没有接收到数据，执行清除授权成功！");
            }
        }
    }


    
        
}