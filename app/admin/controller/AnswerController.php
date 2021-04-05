<?php
namespace app\admin\controller;
use think\DB;
use think\Session;

class AnswerController extends BaseController
{
	public function initialize(){
        parent::initialize();
        
    }

    public function getQuestion(){
    	$questions = Db::table('ims_jueqi_fkdt_question')->limit(1,10)->select()->toArray();
    	echo json_encode($questions);exit;
    }

    public function history(){
        $uid = session('uid');
        $records = Db::table('ims_jueqi_fkdt_answerrecord')->where("uid = $uid")->order("id desc")->select()->toArray();
        foreach ($records as $key => $value) {
            $records[$key]['order'] = $key + 1;
            $records[$key]['timebj'] = date('Y-m-d',$value['timebj']);
        }
        $this->assign('records',$records);
    	return $this->fetch();
    }

    public function index(){
    	return $this->fetch();
    }

    public function join(){
        $records = Db::table('ims_jueqi_fkdt_user')->field("count(*) as bumen_num,bumen")->order("bumen_num desc")->group('bumen')->select()->toArray();

        $first = 1;
        $last_key = 0;
        foreach ($records as $key => $value) {
            if($key == 0){
                $records[$key]['rank'] = 1;
            }else{
                if($value['bumen_num'] == $records[$key - 1]['bumen_num']){
                    $records[$key]['rank'] = $records[$key - 1]['rank'];
                }else{
                    $records[$key]['rank'] = $records[$key - 1]['rank'] + 1;
                }
            }
        }


        $this->assign('records',$records);
    	return $this->fetch();
    }

    public function question(){

        $questions_danxuan = Db::table('ims_jueqi_fkdt_question')->where("is_danxuan = 1")->limit(0,8)->select()->toArray();
        $questions_duoxuan = Db::table('ims_jueqi_fkdt_question')->where("is_danxuan = 2")->limit(0,2)->select()->toArray();

        $questions = array_merge($questions_danxuan, $questions_duoxuan);

        $this->assign('questions',$questions);

    	return $this->fetch();
    }

    public function ranking(){

        $records = Db::table('ims_jueqi_fkdt_user')->order("totalscore desc")->select()->toArray();

        $first = 1;
        $last_key = 0;
        foreach ($records as $key => $value) {
            if($key == 0){
                $records[$key]['rank'] = 1;
            }else{
                if($value['totalscore'] == $records[$key - 1]['totalscore']){
                    $records[$key]['rank'] = $records[$key - 1]['rank'];
                }else{
                    $records[$key]['rank'] = $records[$key - 1]['rank'] + 1;
                }
            }
        }

        $this->assign('records',$records);

    	return $this->fetch();
    }

    public function storage(){
    	return $this->fetch();
    }
}