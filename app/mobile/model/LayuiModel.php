<?php
namespace app\mobile\model;

Class LayuiModel
{
	static function layuiData($data,$count,$msg){
		return [
			"code" 	=> 0,
			"msg"  	=> $msg,
			"count"	=> $count,
			"data"	=> $data
		];
	}
}