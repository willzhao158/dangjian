<?php
/**
 * Created by sublime.
 * User: xiaoma
 * Date: 2019/9/21
 * Time: 上午 13:50
 */
namespace app\farm\controller;

use app\farm\model\FarmbaseModel;
use think\Session;
use tree\Tree;
use think\Db;
use think\Upload;

Class FarmbaseController extends AdminBaseController
{
    //数据表名
    public $table = 'ny_warehouse';
    //实例化数据模型
    public function initialize(){
        $model = new FarmbaseModel();
        $model->table= $this->table;
        $this->model = $model;
    }
    //返回一定类型的数据
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

    public function editaction(){
        $edit = $this->model->editfielddata(input());
        if($edit[0]){
            return $this->success('更新成功');
        }
        return $this->error('更新失败');
    }

    public function editallaction(){
        $edit = $this->model->editdata(input());
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

    //获得农机分类
    public function machineryClassifyList($parentId=0){
        $tree     = new Tree();
        $result   = Db::name('MachineryClassify')->order(["list_order" => "ASC"])->select();
        $array    = [];
        foreach ($result as $r) {
            $r['selected'] = $r['id'] == $parentId ? 'selected' : '';
            $array[]       = $r;
        }
        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
        $tree->init($array);
        return $tree->getTree(0, $str);
    }


    //获得作物分类
    public function cropList($parentId=0){
        $tree     = new Tree();
        $result   = Db::name('crop')->order(["id" => "ASC"])->select();
        $array    = [];
        foreach ($result as $r) {
            $r['selected'] = $r['id'] == $parentId ? 'selected' : '';
            $array[]       = $r;
        }
        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
        $tree->init($array);
        return $tree->getTree(0, $str);
    }


    //获得园地
    public function ParkList(){
        $result   = Db::name('park')->select()->toArray();
        return $result;
    }


    //获得地块
    public function PlaceList(){
        $result   = Db::name('place')->field('id,plotname')->select()->toArray();
        return $result;
    }

    
    public function uploadfile($dir='device'){
       // 允许上传的图片后缀
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);     // 获取文件后缀名
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
                    return false;
                }
                else
                {
                    @mkdir($path);
                    // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
                    $filename = date('Ymdhis.').$extension;
                    move_uploaded_file($_FILES["file"]["tmp_name"], $path . $filename);
                    return ($path . $filename);
                }
            }
        }
        else
        {
            return false;
        }
    }

    public function upload($dir='device'){
        $file = $this->uploadfile($dir);
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




    public function getdatainfo($params){
        return $this->model->getdatainfo($params);
    }

    //获取配置文件中的信息
    protected function getDataConfig($dataType){
        return Config()[$dataType];
    }
    //将配置文件写入到app.php中
    protected function addDataConfig($dataType,$array=[]){
        $dir = __DIR__.'/../config/';
        $filename = $dataType.'.php';
        $code = $this->create_php_code($dataType,$array);
        file_put_contents(__DIR__.'/../config/'.$dataType.'.php', $code);
    }
    private function create_php_code($dataType,$array){
        $code = "<?php\n";
        $code .= ' return '.var_export($array,true);
        $code .= "?>\n";
        return $code;
    }

    //指定配置文件写入
    protected function addfarmWorkType($index,$value){
        $config = Config()[$index];
        $config[] = $value;
        $this->addDataConfig($index,$config);
    }

    //修改农事类型
    public function saveFarmWorkType(){
        $request = input('params');
        $index = 'farmworktype';
        $this->addDataConfig($index,$request);
    }

}



//巡园管理
//播种管理
//施肥管理 -> 施肥汇报
//施药管理 -> 施药汇报
//作业管理 -> 拍照汇报
//采集管理 -> 采集汇报
//工作管理 -> 农事汇报
//           病虫害汇报
//           问题反馈