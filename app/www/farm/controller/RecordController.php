<?php
/**
 * Created by sublime.
 * User: xiaoma
 * Date: 2019/9/21
 * Time: 上午 13:50
 */
namespace app\farm\controller;
Class RecordController extends FarmbaseController
{
    public $table = 'ny_record';
    
	public function index(){

        $place = $this->Placelist();
        foreach ($place as $key => $value) {
            unset($place[$key]['plotsoil']);
        }
        
        $this->assign('place',json_encode($place,true));
		return view();
	}

	public function add(){
    	$this->assign('place',$this->Placelist());
		return view();
	}

	public function edit(){
		$data = $this->getdatainfo(input());
        $this->assign('place',$this->Placelist());
		$this->assign('data',$data);
		return view();
	}


	

}