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

    public function saveAnswer(){
        $answers = input('answer');

        $log_data = [];
        $log_data['uid'] = session('uid');
        $log_data['add_time'] = time();

        Db::name("jueqi_fkdt_quesctlog")->insert($log_data);

        $yes_num = 0;
        //已答题id
        $answered_qid = [];
        foreach ($answers as $key => $value) {
            if($value['isOk'] == 1){
                $yes_num++;
            }
            $answered_qid[] = $value['id'];
        }

        $answer_record = [];
        $answer_record['rid'] = 28;
        $answer_record['uid'] = session('uid');
        $answer_record['yes_num'] = $yes_num;
        $answer_record['score'] = $yes_num;
        $answer_record['total_num'] = 10;
        $answer_record['timebj'] = time();

        Db::name("jueqi_fkdt_answerrecord")->insert($answer_record);

        //更新user表已答字段
        $answered_str = implode(',', $answered_qid);
        $uinfo = Db::name("jueqi_fkdt_user")->where("id=".session('uid'))->find();
        $answered = $uinfo['answered'];
        if(empty($answered)){
            $answered = $answered_str;
        }else{
            $answered = $answered.','.$answered_str;
        }
        Db::name("jueqi_fkdt_user")->where("id=".session('uid'))->update(['answered'=>$answered]);

        $res = [];
        $res['code'] = 1;
        $res['msg'] = '提交成功';
        echo json_encode($res);
        exit;
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

        $questions_danxuan = Db::table('ims_jueqi_fkdt_question')->order("id asc")->where("is_danxuan = 1")->limit(0,8)->select()->toArray();
        var_dump($questions_danxuan);exit;
        $questions_duoxuan = Db::table('ims_jueqi_fkdt_question')->order("id asc")->where("is_danxuan = 2")->limit(0,2)->select()->toArray();

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