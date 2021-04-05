<?php
namespace app\mobile\model;
use think\Model;
use think\DB;

class RuleModel extends Model
{



    //收益提现分成
    static function income_cash($uid,$price){

        $user_info = Db::table('ny_mobile_user')->where("id = $uid")->find();

        
        $reference = $user_info['reference'];
        $top_reference = $user_info['top_reference'];

        // echo $reference;
        // echo $top_reference;exit;
        
        if(empty($reference) && empty($top_reference)){
            return true;
        }

        $reference_info = Db::table('ny_mobile_user')->where("id = $reference")->find();

        $top_reference_info = array();
        if(!empty($top_reference)){
            $top_reference_info = Db::table('ny_mobile_user')->where("id = $top_reference")->find();
        }

        $reference_income = 0;
        $top_reference_income = 0;

        if(empty($top_reference_info)){
            if($reference_info['level'] == 1){
                $reference_income = 0;
                $top_reference_income = 0;
            }elseif($reference_info['level'] == 2){
                if($user_info['level'] == 1){
                    $reference_income = round($price*0.03*0.88,2);
                    $top_reference_income = 0;
                }else{
                    $reference_income = 0;
                    $top_reference_income = 0;
                }
            }elseif($reference_info['level'] == 3){
                if($user_info['level'] == 1){
                    $reference_income = round($price*0.045*0.88,2);
                    $top_reference_income = 0;
                }else{
                    $reference_income = 0;
                    $top_reference_income = 0;
                }
            }
        }else{

            if($top_reference_income['level'] == 1){
                if($user_info['level'] == 1){
                    if($reference_info['level'] == 1){
                        $reference_income = 0;
                        $top_reference_income = 0;
                    }elseif($reference_info['level'] == 2){
                        $reference_income = round($price*0.03*0.88,2);
                        $top_reference_income = 0;
                    }elseif($reference_info['level'] == 3){
                        $reference_income = round($price*0.045*0.88,2);
                        $top_reference_income = 0;
                    }
                }else{
                    $reference_income = 0;
                    $top_reference_income = 0;
                }
            }elseif($top_reference_info['level'] == 2){
                if($reference_info['level'] == 1){
                    if($user_info['level'] == 1){
                        $reference_income = 0;
                        $top_reference_income = round($price*0.03*0.88,2);
                    }elseif($user_info['level'] == 2){
                        $reference_income = 0;
                        $top_reference_income = 0;
                    }elseif($user_info['level'] == 3){
                        $reference_income = 0;
                        $top_reference_income = 0;
                    }
                }elseif($reference_info['level'] == 2){
                    if($user_info['level'] == 1){
                        $reference_income = round($price*0.03*0.88,2);
                        $top_reference_income = 0;
                    }elseif($user_info['level'] == 2){
                        $reference_income = 0;
                        $top_reference_income = 0;
                    }elseif($user_info['level'] == 3){
                        $reference_income = 0;
                        $top_reference_income = 0;
                    }
                }elseif($reference_info['level'] == 3){
                    if($user_info['level'] == 1){
                        $reference_income = round($price*0.045*0.88,2);
                        $top_reference_income = 0;
                    }elseif($user_info['level'] == 2){
                        $reference_income = 0;
                        $top_reference_income = 0;
                    }elseif($user_info['level'] == 3){
                        $reference_income = 0;
                        $top_reference_income = 0;
                    }
                }
            }elseif($top_reference_info['level'] == 3){
                if($reference_info['level'] == 1){
                    if($user_info['level'] == 1){
                        $reference_income = 0;
                        $top_reference_income = round($price*0.045*0.88,2);
                    }elseif($user_info['level'] == 2){
                        $reference_income = 0;
                        $top_reference_income = 0;
                    }elseif($user_info['level'] == 3){
                        $reference_income = 0;
                        $top_reference_income = 0;
                    }
                }elseif($reference_info['level'] == 2){
                    if($user_info['level'] == 1){
                        $reference_income = round($price*0.03*0.88,2);
                        $top_reference_income = round($price*0.015*0.88,2);
                    }elseif($user_info['level'] == 2){
                        $reference_income = 0;
                        $top_reference_income = 0;
                    }elseif($user_info['level'] == 3){
                        $reference_income = 0;
                        $top_reference_income = 0;
                    }
                }elseif($reference_info['level'] == 3){
                    if($user_info['level'] == 1){
                        $reference_income = round($price*0.045*0.88,2);
                        $top_reference_income = 0;
                    }elseif($user_info['level'] == 2){
                        $reference_income = 0;
                        $top_reference_income = 0;
                    }elseif($user_info['level'] == 3){
                        $reference_income = 0;
                        $top_reference_income = 0;
                    }
                }
            }
        }

        if((!empty($reference)) && ($reference_income != 0)){

            if($reference_info['cancel'] == 1 && $reference_info['isblack'] == 1){
                Db::table('ny_mobile_user')->where("id = $reference")->setInc('income',$reference_income);
                //二级积分log
                $reference_income_log = array(
                                        'uid'=>$reference,
                                        'price'=>$reference_income,
                                        'channel'=>$uid,
                                        'createtime'=>time(),
                                        'from'=>1,
                                    );
                Db::table('ny_income_log')->insert($reference_income_log);
            }

            
        }
        


        if(!empty($top_reference) && $top_reference_income != 0){

            if($top_reference_info['cancel'] == 1 && $top_reference_info['isblack'] == 1){
                Db::table('ny_mobile_user')->where("id = $top_reference")->setInc('income',$top_reference_income);
                //三级积分log
                $top_reference_income_log = array(
                                        'uid'=>$top_reference,
                                        'price'=>$top_reference_income,
                                        'channel'=>$uid,
                                        'createtime'=>time(),
                                        'from'=>2,
                                    );
                Db::table('ny_income_log')->insert($top_reference_income_log);
            }
        }
        
        //自己income更改
        
        Db::table('ny_mobile_user')->where("id = $uid")->setDec('income',$price);

        $my_tixian_log = array(
                                'uid'=>$uid,
                                'price'=>$price,
                                'createtime'=>time(),
                                'from'=>1,
                                'status'=>2,
                                'channel'=>'收益提现',
                            );
        Db::table('ny_tixian_log')->insert($my_tixian_log);

        

        return true;

    }


    //升级收益分成
    static function update_income($uid){

        $user_info = Db::table('ny_mobile_user')->where("id = $uid")->find();
        if($user_info['level'] == 1){
            return true;
        }
        $reference = $user_info['reference'];
        $top_reference = $user_info['top_reference'];
        
        if(empty($reference) && empty($top_reference)){
            return true;
        }

        $reference_info = Db::table('ny_mobile_user')->where("id = $reference")->find();

        $top_reference_info = array();
        if(!empty($top_reference)){
            $top_reference_info = Db::table('ny_mobile_user')->where("id = $top_reference")->find();
        }

        $reference_income = 0;
        $top_reference_income = 0;

        //先设置直推上级用户获取积分，如果是合作商，那么是12积分，其他为10，分为顶级为合作商或者不是的情况
        if(empty($top_reference_info)){
            if($reference_info['level'] == 1){
                
            }elseif($reference_info['level'] == 2){
                if($user_info['level'] == 2){
                    $reference_income = 660*0.4*0.88;
                }elseif($user_info['level'] == 3){
                    $reference_income = 10000*0.2*0.88;
                }
            }elseif($reference_info['level'] == 3){
                if($user_info['level'] == 2){
                    $reference_income = 660*0.6*0.88;
                }elseif($user_info['level'] == 3){
                    $reference_income = 10000*0.3*0.88;
                }
            }
        }else{
            if($top_reference_info['level'] == 1){
                if($reference_info['level'] == 1){
                
                }elseif($reference_info['level'] == 2){
                    if($user_info['level'] == 2){
                        $reference_income = 660*0.4*0.88;
                    }elseif($user_info['level'] == 3){
                        $reference_income = 10000*0.2*0.88;
                    }
                }elseif($reference_info['level'] == 3){
                    if($user_info['level'] == 2){
                        $reference_income = 660*0.6*0.88;
                    }elseif($user_info['level'] == 3){
                        $reference_income = 10000*0.3*0.88;
                    }
                }
            }elseif($top_reference_info['level'] == 2){
                if($reference_info['level'] == 1){
                    if($user_info['level'] == 2){
                        $reference_income = 0;
                        $top_reference_income = 660*0.4*0.88;
                    }elseif($user_info['level'] == 3){
                        $reference_income = 0;
                        $top_reference_income = 10000*0.2*0.88;
                    }
                }elseif($reference_info['level'] == 2){
                    if($user_info['level'] == 2){
                        $reference_income = 660*0.4*0.88;
                        $top_reference_income = 0;
                    }elseif($user_info['level'] == 3){
                        $reference_income = 10000*0.2*0.88;
                        $top_reference_income = 0;
                    }
                }elseif($reference_info['level'] == 3){
                    if($user_info['level'] == 2){
                        $reference_income = 660*0.6*0.88;
                        $top_reference_income = 0;
                    }elseif($user_info['level'] == 3){
                        $reference_income = 10000*0.3*0.88;
                        $top_reference_income = 0;
                    }
                }
            }elseif($top_reference_info['level'] == 3){
                if($reference_info['level'] == 1){
                    if($user_info['level'] == 2){
                        $reference_income = 0;
                        $top_reference_income = 660*0.6*0.88;
                    }elseif($user_info['level'] == 3){
                        $reference_income = 0;
                        $top_reference_income = 10000*0.3*0.88;
                    }
                }elseif($reference_info['level'] == 2){
                    if($user_info['level'] == 2){
                        $reference_income = 660*0.4*0.88;
                        $top_reference_income = 660*0.2*0.88;
                    }elseif($user_info['level'] == 3){
                        $reference_income = 10000*0.2*0.88;
                        $top_reference_income = 10000*0.1*0.88;
                    }
                }elseif($reference_info['level'] == 3){
                    if($user_info['level'] == 2){
                        $reference_income = 660*0.6*0.88;
                        $top_reference_income = 0;
                    }elseif($user_info['level'] == 3){
                        $reference_income = 10000*0.3*0.88;
                        $top_reference_income = 0;
                    }
                }
            }
        }
        // var_dump($reference);
        // echo $reference_income;exit;
        if((!empty($reference)) && ($reference_income != 0)){

            if($reference_info['cancel'] == 1 && $reference_info['isblack'] == 1){
                Db::table('ny_mobile_user')->where("id = $reference")->setInc('income',$reference_income);
                //二级积分log
                if($user_info['level'] == 2){
                    $from = 3;
                }elseif($user_info['level'] == 3){
                    $from = 5;
                }
                $reference_income_log = array(
                                        'uid'=>$reference,
                                        'price'=>$reference_income,
                                        'channel'=>$uid,
                                        'createtime'=>time(),
                                        'from'=>$from,
                                    );
                Db::table('ny_income_log')->insert($reference_income_log);
            }

            
        }
        


        if(!empty($top_reference) && $top_reference_income != 0){

            if($top_reference_info['cancel'] == 1 && $top_reference_info['isblack'] == 1){
                Db::table('ny_mobile_user')->where("id = $top_reference")->setInc('income',$top_reference_income);

                if($user_info['level'] == 2){
                    $from = 4;
                }elseif($user_info['level'] == 3){
                    $from = 6;
                }
                //三级积分log
                $top_reference_income_log = array(
                                        'uid'=>$top_reference,
                                        'price'=>$top_reference_income,
                                        'channel'=>$uid,
                                        'createtime'=>time(),
                                        'from'=>$from,
                                    );
                Db::table('ny_income_log')->insert($top_reference_income_log);
            }
        }
        
        
        

        return true;

    }



    //注册积分分成
    static function login_rule($uid,$reference,$top_reference)
    {
        if(empty($reference) && empty($top_reference)){
            return true;
        }

        $reference_info = Db::table('ny_mobile_user')->where("id = $reference")->find();
        if(!empty($top_reference)){
            $top_reference_info = Db::table('ny_mobile_user')->where("id = $top_reference")->find();
        }
        

        $reference_jifen = 0;
        $top_reference_jifen = 0;


        //先设置直推上级用户获取积分，如果是合作商，那么是12积分，其他为10，分为顶级为合作商或者不是的情况
        if(empty($top_reference_info)){
              //顶级没有用户的情况，只有2级
              if($reference_info['level'] == 1){
                $reference_jifen = 10;
                $top_reference_jifen = 0;
              }elseif($reference_info['level'] == 2){
                $reference_jifen = 10;
                $top_reference_jifen = 0;
              }elseif($reference_info['level'] == 3){
                $reference_jifen = 12;
                $top_reference_jifen = 0;
              }
        }else{
            //3级的情况；
            if($top_reference_info['level'] == 3){
                //顶级合作商的情况
                if($reference_info['level'] == 3){
                    //顶级合作商，二级合作商的特殊情况
                    $reference_jifen = 12;
                    $top_reference_jifen = 0;
                }else{
                    $reference_jifen = 10;
                    $top_reference_jifen = 2;
                }
            }else{
                if($reference_info['level'] == 1){
                    $reference_jifen = 10;
                    $top_reference_jifen = 0;
                }elseif($reference_info['level'] == 2){
                    $reference_jifen = 10;
                    $top_reference_jifen = 0;
                }elseif($reference_info['level'] == 3){
                    $reference_jifen = 12;
                    $top_reference_jifen = 0;
                } 
            }
        }

        if(!empty($reference_info)){
            Db::table('ny_mobile_user')->where("id = $reference")->setInc('jifen',$reference_jifen);
            //二级积分log
            $reference_jifen_log = array(
                                    'uid'=>$reference,
                                    'number'=>$reference_jifen,
                                    'channel'=>$uid,
                                    'createtime'=>time(),
                                    'from'=>1,
                                );
            Db::table('ny_jifen_log')->insert($reference_jifen_log);
        }

        if(!empty($top_reference_info)){
            Db::table('ny_mobile_user')->where("id = $top_reference")->setInc('jifen',$top_reference_jifen);
        
            //三级积分log
            $top_reference_jifen_log = array(
                                    'uid'=>$top_reference,
                                    'number'=>$top_reference_jifen,
                                    'channel'=>$uid,
                                    'createtime'=>time(),
                                    'from'=>2,
                                );
            Db::table('ny_jifen_log')->insert($top_reference_jifen_log);
        }

        
        

        return true;
    }
    
}