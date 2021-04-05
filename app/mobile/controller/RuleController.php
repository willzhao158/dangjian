<?php
namespace app\mobile\controller;

use think\DB;
use app\mobile\model\RuleModel;

class RuleController extends BaseController
{
    
    public function test(){
        RuleModel::update_income();
    }
    
}