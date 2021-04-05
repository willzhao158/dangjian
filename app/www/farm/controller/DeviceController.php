<?php
/**
 * Created by sublime.
 * User: xiaoma
 * Date: 2019/9/21
 * Time: 上午 13:50
 */
namespace app\farm\controller;
Class DeviceController extends FarmbaseController
{
    public $table = 'ny_device';
    private $deviceType = [
    	'太阳辐射',
    	'降雨量',
    	'风速',
    	'大气压力',
    	'空气温度',
    	'空气湿度',
    	'光照度',
    	'风向',
    	'水面蒸发',
    	
    	'水位',
    	'土壤pH值',
    	'土壤张力',
    	'土壤湿度',
    	'土壤温度',
    	'溶氧量',

    	'虫害',

    	'视频'
    ];
   	
    
	public function index(){

        $place = $this->Placelist();
        foreach ($place as $key => $value) {
            unset($place[$key]['plotsoil']);
        }
        $this->assign('place',json_encode($place,true));
        $this->assign('deviceType',json_encode($this->deviceType,true));
        $this->assign('device',$this->deviceType);
		return view();
	}

	public function add(){
        $this->assign('deviceType',$this->deviceType);
    	$this->assign('place',$this->Placelist());
		return view();
	}

	public function edit(){
		$this->assign('deviceType',$this->deviceType);
		$data = $this->getdatainfo(input());
        $this->assign('place',$this->Placelist());
		$this->assign('data',$data);
		return view();
	}

	public function report(){
        return view();
    }

    public function reportdata(){
        $this->model->table = 'ny_soil_water';
        //是否需要分页
        $islimit = false;

        $data = $this->model->datalist($islimit);
        // foreach($data as $k=>$v){
        //     $data[$k]['time'] = date('Y-m-d h:i:s',$v['create_time']);
        // }
        return $data;
    }
	

}