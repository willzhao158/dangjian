<?php
namespace app\mobile\controller;

use think\DB;

class TaskController extends BaseController
{
    

    public function initialize(){
        //$model = new UserModel();
        // $model->table= $this->table;
        //$this->model = $model;


    }

    //活动结束，未使用的活动彩金券数额返回到商家余额
    public function return_money(){
        $time = time()-60*60*24;
        $all_ads = Db::table('ny_advertisement')->where("end_time < '$time'")->all()->toArray();
        foreach ($all_ads as $key => $value) {
            $ad_id = $value['id'];
            $uid = $value['uid'];

            
            if($value['type'] == 1){

                $is_tuihui = Db::table('ny_yue_log')->where("ad_id = $ad_id and uid = $uid and action='广告宣传券退回'")->find();
                if(!empty($is_tuihui)){
                    continue;
                }

                //计算已经使用
                $used = Db::table('ny_my_join')->where("ad_id = $ad_id and status = 4")->count();
                $tuihui = $value['price'] - $used;

                $yue_log = array(
                            'uid'=>$uid,
                            'ad_id'=>$ad_id,
                            'action'=>'广告宣传券退回',
                            'createtime'=>time(),
                            'change'=>2
                        );

            }else{

                $is_tuihui = Db::table('ny_yue_log')->where("ad_id = $ad_id and uid = $uid and action = '活动彩金券退回'")->find();
                if(!empty($is_tuihui)){
                    continue;
                }
                
                if($value['activity_type'] == 1){
                    $atype = 58;
                }else{
                    $atype = 108;
                }
                $used = Db::table('ny_my_join')->where("ad_id = $ad_id and status = 4")->count();
                $tuihui = $value['price'] - $used*$atype;

                $yue_log = array(
                            'uid'=>$uid,
                            'ad_id'=>$ad_id,
                            'action'=>'活动彩金券退回',
                            'createtime'=>time(),
                            'change'=>2
                        );

            }

            
            
            DB::name('yue_log')->insert($yue_log);
            Db::table('ny_mobile_user')->where("id = {$uid}")->setInc('yue',$tuihui);
        }
    }
    
    //超过3次拉入黑名单接口
    public function count_unconfirm(){
        $all_users = Db::table('ny_mobile_user')->all()->toArray();
        $now = time();
        //活动截止日期之前，如果未提交或者提交未通过累计出现3次，则拉入黑名单
        foreach ($all_users as $key => $value) {
            $uid = $value['id'];
            $overtime = Db::name('my_join')->alias("a")->join('ny_advertisement b ', ' a.ad_id = b.id')->where("a.uid = $uid and b.end_time < $now and (a.status = 1 || a.status = 3) and a.ad_type = 2")->count();
            //var_dump($overtime);
            //Db::name('mobile_user')->where('id', $uid)->update(array('isblack'=>2));
            if($overtime >= 3){
                Db::name('mobile_user')->where('id', $uid)->update(array('isblack'=>2));
            }
        }
        //Db::name('mobile_user')->update(array('isblack'=>2));
    }

}