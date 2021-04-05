<?php

namespace app\admin\controller;

use app\common\controller\AdminBaseController;
use cmf\controller\BaseController as cmfBaseController;
use think\Db;
use think\Upload;
use app\admin\model\OrderModel;
use think\Session;

class BaseController extends cmfBaseController
{

    protected function initialize()
    {
        parent::initialize();

        //vue index.html不做验证.
        if($this->request->controller() == 'index' &&  $this->request->action() == 'index'){
            return ;
        }

        $sessionAdminId = session('ADMIN_ID');
        if (!empty($sessionAdminId)) {
            $user = Db::name('user')->where('id', $sessionAdminId)->find();

            if (!$this->checkAccess($sessionAdminId)) {
                $url = 'http://'.$_SERVER['HTTP_HOST']."/login/login";
                Header("Location:$url"); 
                exit;
                $this->apierror(['code' => -1, 'msg' => '您没有访问权限']);
            }
            $this->assign("admin", $user);
        } else {
            $url = 'http://'.$_SERVER['HTTP_HOST']."/login/login";
            Header("Location:$url"); 
            exit;
            $this->apierror(['code' => -2, 'msg'=>'您还没有登录']);
        }
        
    }
    protected function apisuccess($msg = '', $data = '', array $header = [])
    {
        $code   = 1;
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
        ];
        echo json_encode($result);die();
    }
      protected function apierror($msg = '', $data = '', array $header = [])
    {
        $code = 0;
        if (is_array($msg)) {
            $code = $msg['code'];
            $msg  = $msg['msg'];
        }
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
        ];
        echo json_encode($result);die();
}

    public function _initializeView()
    {
        $cmfAdminThemePath    = config('template.cmf_admin_theme_path');
        $cmfAdminDefaultTheme = cmf_get_current_admin_theme();

        $themePath = "{$cmfAdminThemePath}{$cmfAdminDefaultTheme}";

        $root = cmf_get_root();

        //使cdn设置生效
        $cdnSettings = cmf_get_option('cdn_settings');
        if (empty($cdnSettings['cdn_static_root'])) {
            $viewReplaceStr = [
                '__ROOT__'     => $root,
                '__TMPL__'     => "{$root}/{$themePath}",
                '__STATIC__'   => "{$root}/static",
                '__WEB_ROOT__' => $root,
            ];
        } else {
            $cdnStaticRoot  = rtrim($cdnSettings['cdn_static_root'], '/');
            $viewReplaceStr = [
                '__ROOT__'     => $root,
                '__TMPL__'     => "{$cdnStaticRoot}/{$themePath}",
                '__STATIC__'   => "{$cdnStaticRoot}/static",
                '__WEB_ROOT__' => $cdnStaticRoot,
            ];
        }

        config('template.view_base', WEB_ROOT . "$themePath/");
        config('template.tpl_replace_string', $viewReplaceStr);
    }

    /**
     *  检查后台用户访问权限
     * @param int $userId 后台用户id
     * @return boolean 检查通过返回true
     */
    protected function checkAccess($userId)
    {
        // 如果用户id是1，则无需判断
        if ($userId == 1) {
            return true;
        }

        $module     = $this->request->module();
        $controller = $this->request->controller();
        $action     = $this->request->action();
        $rule       = $module . $controller . $action;

        $notRequire = ["adminIndexindex", "adminMainindex"];
        if (!in_array($rule, $notRequire)) {
            return nongye_auth_check($userId);
        } else {
            return true;
        }
    }

    public function editaction(){
        $edit = $this->model->editfielddata(input());
        if($edit[0]){
            return $this->success('更新成功');
        }
        return $this->error('更新失败');
    }

    public function delaction(){
        if($this->model->deldata(input())){
            return $this->success('删除成功');
        }
        return $this->error('删除失败');
    }

    public function datalist($islimit = true){
        return $this->model->datalist($islimit);
    }

    public function addaction(){
        $add = $this->model->adddata(input());
        if($add[0]){
            return $this->success('添加成功');
        }
        return $this->error('添加失败');
    }

    public function uploadfile($dir='device'){
       // 允许上传的图片后缀
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);     // 获取文件后缀名
        //var_dump($_FILES);exit;
        if ((($_FILES["file"]["type"] == "image/gif")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/jpg")
        || ($_FILES["file"]["type"] == "image/pjpeg")
        || ($_FILES["file"]["type"] == "image/x-png")
        || ($_FILES["file"]["type"] == "image/png"))
        && ($_FILES["file"]["size"] < 1204800)   // 小于 200 kb
        && in_array($extension, $allowedExts))
        {
            if ($_FILES["file"]["error"] > 0)
            {
                $error = "错误：: " . $_FILES["file"]["error"] . "<br>";
                return false;
            }
            else
            {
                $path = "upload/$dir/";
                // 判断当期目录下的 upload 目录是否存在该文件
                // 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
                if (file_exists($path . $_FILES["file"]["name"]))
                {
                    //echo 111;exit;
                    return ($path . $_FILES["file"]["name"]);
                }
                else
                {
                    //var_dump($_FILES);
                    @mkdir($path);
                    // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
                    $rand = rand(1,999);
                    $filename = date('Ymdhis').$rand.'.'.$extension;
                    $res = move_uploaded_file($_FILES["file"]["tmp_name"], $path . $filename);
                    //echo $path . $filename;
                    return ($path . $filename);
                }

                // @mkdir($path);
                // // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
                // $filename = date('Ymdhis.').$extension;
                // move_uploaded_file($_FILES["file"]["tmp_name"], $path . $filename);
                // return ($path . $filename);

            }
        }
        else
        {
            return false;
        }
    }

    public function upload(){
        $dir = $this->request->param("dir");
        $file = $this->uploadfile($dir);
        //var_dump($file);exit;
        if($file){
            $this->success($file);
        }
        $this->error('上传失败');
    }

    public function uploadEdit(){
        $uploadimg = $this->upload('crop');
        if($uploadimg){
            return array(
                'code' => 0,
                'msg'  => '',
                'data' => array(
                    'src' => $uploadimg,
                    'title' => '图片'
                )
            );

        }
        return false;
    }

}