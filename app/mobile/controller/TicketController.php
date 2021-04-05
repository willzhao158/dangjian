<?php
namespace app\mobile\controller;

use think\DB;

class TicketController extends BaseController
{
    

    public function initialize(){
        parent::initialize();
        // $model = new OrderModel();
        // $model->table= $this->table;
        // $this->model = $model;


    }
    
    

    public function submit_ticket()
    {
        $uid = session('uid');
        $tid = input('tid');

        Db::table('ny_my_join')->where("uid = $uid and id = $tid")->update(array('status'=>3));

        echo 1;exit;
    }

    public function submit_xuanchuan(){
        $uid = session('uid');
        $tid = input('tid');

        Db::table('ny_my_join')->where("uid = $uid and id = $tid")->update(array('status'=>4));

        //我的收益多1*0.88
        $income = 0.88;
        Db::table('ny_mobile_user')->where("id = $uid")->setInc('income',$income);

        //收益log添加
        $income_log = array(
                        'uid'=>$uid,
                        'price'=>$income,
                        'createtime'=>time(),
                        'ad_id'=>$tid,
                        'from'=>8,
                    );
        Db::table('ny_income_log')->insert($income_log);
        echo 1;exit;
    }

    public function cancel_ticket()
    {
        $uid = session('uid');
        $tid = input('tid');

        Db::table('ny_my_join')->where("uid = $uid and id = $tid")->update(array('status'=>2));

        $already_tuihui = Db::table('ny_my_join')->where("uid = $uid and status = 2")->count();
        if($already_tuihui == 3){
            Db::name('my_join')->where("uid = $uid and status != 4")->update(array('status'=>2));
        }
        echo 1;exit;
    }

    
}