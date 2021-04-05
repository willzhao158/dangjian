<?php
/**
 * Created by sublime.
 * User: xiaoma
 * Date: 2019/9/21
 * Time: 上午 13:50
 */
namespace app\farm\controller;
use app\farm\model\CollectModel;
use think\Db;
Class CollectController extends FarmbaseController
{
    public $table = 'ny_collect';
    public function initialize(){
    	$this->model = new  CollectModel();
    }

	public function index(){
		return view();
	}

	public function add(){
		return view();
	}

	public function edit(){
		$data = $this->model->getdatainfo(input());
		$this->assign('data',$data[0]);
		$this->assign('detail',json_encode($data[1]));
		return view();
	}

		

	public function editaction(){
		$result = $this->model->editcollect(input());
		if($result){
			$this->success('播种记录修改成功','',$result);
		}
		$this->error('播种记录修改失败','',$result);
	}





	public function addaction(){
        // return input();
		if($this->model->addcollect(input())){
			$this->success('播种记录添加成功');
		}
		$this->error('播种记录添加失败');
	}


	private function handle_data($data){
        $detail = [];	
        foreach($data as $k=>$v){
            if(is_array($v)){
                $detail[$k] = $v;
                unset($data[$k]);
            }
        }
        $array = [];
        $j = 0;
        $keys = array_keys($detail);
        $count = count($detail[$keys[0]]);
        for($i=0;$i<$count;$i++){
            $arr = [];
            foreach($keys as $value){
                $arr[$value] = $detail[$value][$i];
            }
            $array[] = $arr;
        }
        return array(
        	'collect' => $data,
        	'collect_detail' => $array
        );
    }

    public function getcollectDetail(){
    	return $this->model->getcollectDetail(input());
    }
}