<?php
namespace app\mobile\model;

use think\Model;
use think\Db;

Class CityModel extends Model
{
	static function getAll(){
        $res = array();
		$sheng = Db::table('ny_city')->where('level', 1)->all()->toArray();
        foreach ($sheng as $key => $value) {
            $res[$key]['value'] = $value['value'];
            $res[$key]['label'] = $value['label'];

            $shi = Db::table('ny_city')->where(["level" => "2", "parent" => $value['value']])->all()->toArray();

            foreach ($shi as $a => $b) {
                $res[$key]['children'][$a]['value'] = $b['value'];
                $res[$key]['children'][$a]['label'] = $b['label'];

                $qu = Db::table('ny_city')->where(["level" => "3", "parent" => $b['value']])->all()->toArray();

                foreach ($qu as $c => $d) {
                    $res[$key]['children'][$a]['children'][$c]['value'] = $d['value'];
                    $res[$key]['children'][$a]['children'][$c]['label'] = $d['label'];
                }
            }
        }

        return $res;
	}
}