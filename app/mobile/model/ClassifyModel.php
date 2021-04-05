<?php
namespace app\mobile\model;

use think\Model;
use think\Db;

Class ClassifyModel extends Model
{
	static function getAll(){
		$all_classify = Db::table('ny_classify')->where('parent', 0)->all()->toArray();
        $res = array();
        foreach ($all_classify as $key => $value) {
            $res[$key]['value'] = $value['id'];
            $res[$key]['label'] = $value['name'];

            $children = Db::table('ny_classify')->where('parent', $value['id'])->all()->toArray();
            foreach ($children as $a => $b) {
                $res[$key]['children'][$a]['value'] = $b['id'];
                $res[$key]['children'][$a]['label'] = $b['name'];
            }
        }
        return $res;
	}
}