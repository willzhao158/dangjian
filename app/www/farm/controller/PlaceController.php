<?php
/**
 * Created by sublime.
 * User: xiaoma
 * Date: 2019/9/21
 * Time: 上午 13:50
 */
namespace app\farm\controller;
Class PlaceController extends FarmbaseController
{
    public $table = 'ny_place';
    
    public function index(){
        return view();
    }

    public function add(){
        $park = parent::ParkList();
        $this->assign("park", $park);
        return view();
    }

    public function edit(){
        return view();
    }

}