<?php
namespace app\order\controller;

use app\order\model\OrderModel;

class IndexController extends BaseController
{
    private $pagecount;
    //数据表名
    public $table = 'ny_order';

    public $userinfo = '';

    public function initialize(){
        parent::initialize();
        $model = new OrderModel();
        $model->table= $this->table;
        $this->model = $model;


    }
    public function getadvbycom(){
        $data = input();
        $res = $this->model->getadvbycom($data['company']);
        return $res;
    }
    public function index()
    {
        $uid = cmf_get_current_admin_id();
        $user = $this->model->getUserById();
        $this->assign("user", $user);
        return $this->fetch('index/index');
    }

    public function test(){
        return $this->fetch('index/test');
    }

    public function main(){
        $products = $this->model->getalldata('ny_product');
        $advisers = $this->model->getadviser();
        $interest_ways = $this->model->getalldata('ny_interest_way');
        $inv_terms = $this->model->getalldata('ny_inv_term');
        $id_types = $this->model->getalldata('ny_id_type');
        $companys = $this->model->getcompany();

        $uid = cmf_get_current_admin_id();
        $user = $this->model->getUserById();
        //var_dump($user);exit;
        $this->assign("user", $user);
        $this->assign("products", $products);
        $this->assign("advisers", $advisers);
        $this->assign("interest_ways", $interest_ways);
        $this->assign("inv_terms", $inv_terms);
        $this->assign("id_types", $id_types);
        $this->assign("companys", $companys);
        return $this->fetch('index/main');
    }
    public function company(){
        $companys = $this->model->getcompany();
        $this->assign("companys", $companys);
        return $this->fetch('index/company');
    }
    public function baobiao(){
        
        return $this->fetch('index/baobiao');
    }
    public function product(){
        return $this->fetch('index/product');
    }
    public function getproduct($islimit = true){
        $this->model->table = 'ny_product';
        $res = $this->model->datalist($islimit);
        return $res;
    }
    public function adviser(){
        $companys = $this->model->getcompany();
        $this->assign("companys", $companys);
        return $this->fetch('index/adviser');
    }
    public function getadviser($islimit = true){
        $this->model->table = 'ny_adviser';
        $res = $this->model->adviserlist($islimit);
        return $res;
    }
    public function interest_way(){
        return $this->fetch('index/interest_way');
    }
    public function getinterestway($islimit = true){
        $this->model->table = 'ny_interest_way';
        $res = $this->model->datalist($islimit);
        return $res;
    }
    public function getcompany($islimit = true){
        $this->model->table = 'ny_newcompany';
        $res = $this->model->datalist($islimit);
        return $res;
    }
    public function inv_term(){
        return $this->fetch('index/inv_term');
    }
    public function getinvterm($islimit = true){
        $this->model->table = 'ny_inv_term';
        $res = $this->model->datalist($islimit);
        return $res;
    }
    public function id_type(){
        return $this->fetch('index/id_type');
    }
    public function getidtype($islimit = true){
        $this->model->table = 'ny_id_type';
        $res = $this->model->datalist($islimit);
        return $res;
    }
    

    public function orderExcel(){
        REQUIRE_ONCE($_SERVER['DOCUMENT_ROOT']."/../vendor/PHPExcel.php");
        REQUIRE_ONCE($_SERVER['DOCUMENT_ROOT']."/../vendor/PHPExcel/IOFactory.php");

        $back_time = input('back_time','');

        $fileName = "订单统计报表";
        $fileType = "xlsx";

        $obj = new \PHPExcel();

        // 设置当前sheet
        $obj->setActiveSheetIndex(0);

        // 设置当前sheet的名称

        $obj->getActiveSheet()->setCellValue('A1', '合同编号');
        $obj->getActiveSheet()->setCellValue('B1', '产品名称');
        $obj->getActiveSheet()->setCellValue('C1', '投资人');
        $obj->getActiveSheet()->setCellValue('D1', '投资金额');
        $obj->getActiveSheet()->setCellValue('E1', '年化收益');
        $obj->getActiveSheet()->setCellValue('F1', '签订日期');
        $obj->getActiveSheet()->setCellValue('G1', '投资期限');
        $obj->getActiveSheet()->setCellValue('H1', '到期时间');
        $obj->getActiveSheet()->setCellValue('I1', '支付时间');
        $obj->getActiveSheet()->setCellValue('J1', '投资顾问');
        $obj->getActiveSheet()->setCellValue('K1', '付息方式');
        $obj->getActiveSheet()->setCellValue('L1', '证件类型');
        $obj->getActiveSheet()->setCellValue('M1', '证件号码');
        $obj->getActiveSheet()->setCellValue('N1', '手机号码');
        $obj->getActiveSheet()->setCellValue('O1', '汇入银行');
        $obj->getActiveSheet()->setCellValue('P1', '银行账号');
        $obj->getActiveSheet()->setCellValue('Q1', '开户银行');
        $obj->getActiveSheet()->setCellValue('R1', '支付方式');
        $obj->getActiveSheet()->setCellValue('S1', '参考号');
        $obj->getActiveSheet()->setCellValue('T1', '金额');
        $obj->getActiveSheet()->setCellValue('U1', '审核状态');
        $obj->getActiveSheet()->setCellValue('V1', '通讯地址');
        $obj->getActiveSheet()->setCellValue('W1', '备注信息');
        $obj->getActiveSheet()->setCellValue('X1', '是否到期');

        $obj->getActiveSheet()->getStyle("A1:Z1")->getFont()->setBold(true); 
        
        $orders = $this->model->salelist();
        $row = 2;
        foreach ($orders as $key => $value) {
            $obj->getActiveSheet()->setCellValue('A'.$row, $value['contra_num']);
            $obj->getActiveSheet()->setCellValue('B'.$row, $value['pro_name']);
            $obj->getActiveSheet()->setCellValue('C'.$row, $value['investor']);
            $obj->getActiveSheet()->setCellValue('D'.$row, $value['inv_price']);
            $obj->getActiveSheet()->setCellValue('E'.$row, $value['annu_return']);
            $obj->getActiveSheet()->setCellValue('F'.$row, $value['sign_date']);
            $obj->getActiveSheet()->setCellValue('G'.$row, $value['inv_term']);
            $obj->getActiveSheet()->setCellValue('H'.$row, $value['deadline']);
            $obj->getActiveSheet()->setCellValue('I'.$row, $value['pay_time']);

            $obj->getActiveSheet()->setCellValue('J'.$row, $value['adviser']);
            $obj->getActiveSheet()->setCellValue('K'.$row, $value['interest_way']);
            $obj->getActiveSheet()->setCellValue('L'.$row, $value['id_type']);
            $obj->getActiveSheet()->setCellValue('M'.$row, $value['id_num']."\t");
            $obj->getActiveSheet()->setCellValue('N'.$row, $value['mobile']."\t");
            $obj->getActiveSheet()->setCellValue('O'.$row, $value['inbank']);
            $obj->getActiveSheet()->setCellValue('P'.$row, $value['bank_no']."\t");
            $obj->getActiveSheet()->setCellValue('Q'.$row, $value['bank']);
            $obj->getActiveSheet()->setCellValue('R'.$row, $value['pay_way']);
            $obj->getActiveSheet()->setCellValue('S'.$row, $value['pay_no']);
            $obj->getActiveSheet()->setCellValue('T'.$row, $value['pay_money']);
            $obj->getActiveSheet()->setCellValue('U'.$row, $value['exam_status']);
            $obj->getActiveSheet()->setCellValue('V'.$row, $value['address']);
            $obj->getActiveSheet()->setCellValue('W'.$row, $value['remark']);
            if($value['deadline'] < date('Y-m-d')){
                $isdq = "已到期";
            }else{
                $isdq = "";
            }
            $obj->getActiveSheet()->setCellValue('x'.$row, $isdq);
            $row++;
        }

        $styleThinBlackBorderOutline = array(
            'borders' => array(
                'allborders' => array( //设置全部边框
                    'style' => \PHPExcel_Style_Border::BORDER_THIN //粗的是thick
                ),

            ),
        );
        $obj->getActiveSheet()->getStyle("A1:U".($row-1))->applyFromArray($styleThinBlackBorderOutline);
        
        $obj->getActiveSheet()->getStyle("A1:U".($row-1))->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // 导出
        ob_clean();
        if ($fileType == 'xls') {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $fileName . '.xls');
            header('Cache-Control: max-age=1');
            $objWriter = new \PHPExcel_Writer_Excel5($obj);
            $objWriter->save('php://output');
            exit;
        } elseif ($fileType == 'xlsx') {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx');
            header('Cache-Control: max-age=1');
            $objWriter = \PHPExcel_IOFactory::createWriter($obj, 'Excel2007');
            $objWriter->save('php://output');
            exit;
        }    
    }
    public function main1(){
        return $this->fetch('index/main1');
    }
    public function main2(){
        return $this->fetch('index/main2');
    }

    public function add(){
        return $this->fetch('index/add');
    }

    public function getback($islimit = true){
        $this->model->table = 'ny_order_back';
        $res = $this->model->datalist($islimit);
        return $res;
    }

    //返回一定类型的数据
    public function datalist($islimit = true){
        $res = $this->model->datalist($islimit);

        foreach ($res['data'] as $key => $value) {
            $res['data'][$key]['deliver_time'] = empty($value['deliver_time']) ? '' : date('Y-m-d',intval($value['deliver_time']));
            $res['data'][$key]['invoice_date'] = empty($value['invoice_date']) ? '' : date('Y-m-d',intval($value['invoice_date']));
            $res['data'][$key]['receive_date'] = empty($value['receive_date']) ? '' : date('Y-m-d',intval($value['receive_date']));
        }
        //var_dump($res);exit;
        return $res;
    }

    public function getCols(){
        $date = $this->model->getExcelDate();

        $data = input();
        if($data['back_time']){
            $date = explode('~', $data['back_time']);
            $from = $date[0];
            $end = $date[1];
        }else{
            $from = date('Y-m',time());
            $end = date('Y-m',strtotime("+1years",time()));
        }


        $cols = array();
        $cols[0]['field'] = 'salesman';
        $cols[0]['title'] = '销售员';
        $cols[1]['field'] = 'deliver_time';
        $cols[1]['title'] = '发货日期';
        $cols[2]['field'] = 'con_number';
        $cols[2]['title'] = '合同编号';
        $cols[3]['field'] = 'company';
        $cols[3]['title'] = '欠款单位';
        $cols[4]['field'] = 'debt';
        $cols[4]['title'] = '总欠款金额';
        $cols[5]['field'] = 'alldebt';
        $cols[5]['title'] = '总欠款金额';
        $time = 6;
        for ($i=strtotime($from); $i <= strtotime($end); $i=strtotime("+1months",$i)) { 
            $excelTime = date('Y-m',$i);
            $cols[$time]['field'] = 'debt'.$time;
            $cols[$time]['title'] = $excelTime;
            $time++;
        }
        
        return $cols;
    }

    public function backlist($islimit = true){
        $res = $this->model->backExcel($islimit);
        return $res;
    }

    public function addupload(){
        $orderinfo = $this->model->getdatainfo(input());
        $this->assign("orderinfo", $orderinfo);
        return $this->fetch('index/upload');
    }
   
    public function edit(){
        $this->assign("oid", input('id'));
        return $this->fetch('index/edit');
    }

    public function show_con(){
        //var_dump(input());exit;
        $orderinfo = $this->model->getdatainfo(input());
        $con_link = explode(',',$orderinfo['con_link']);
        $this->assign("urls", $con_link);
        return $this->fetch('index/show_con');
    }

    public function editPic(){
        $data['params']['id'] = intval($_POST['oid']);
        $imgs = $_POST['imgs'];
        $imgs = implode(',',$imgs);
        //var_dump($imgs);exit;
        $data['params']['con_link'] = $imgs;
        
        $edit = $this->model->editfielddata($data);
        if($edit[0]){
            return $this->success('更新成功');
        }
        return $this->error('更新失败');
    }

    public function editback(){
        $data = input();
        $this->model->table = 'ny_order_back';
        $edit = $this->model->editfielddata($data);
        if($edit[0]){
            return $this->success('更新成功');
        }
        return $this->error('更新失败');
    }
    public function editidtype(){
        $data = input();
        $this->model->table = 'ny_id_type';
        $edit = $this->model->editfielddata($data);
        if($edit[0]){
            return $this->success('更新成功');
        }
        return $this->error('更新失败');
    }
    public function editadviser(){
        $data = input();
        $this->model->table = 'ny_adviser';
        $edit = $this->model->editfielddata($data);
        if($edit[0]){
            return $this->success('更新成功');
        }
        return $this->error('更新失败');
    }
    public function editinvterm(){
        $data = input();
        $this->model->table = 'ny_inv_term';
        $edit = $this->model->editfielddata($data);
        if($edit[0]){
            return $this->success('更新成功');
        }
        return $this->error('更新失败');
    }
    public function editcompany(){
        $data = input();
        $this->model->table = 'ny_newcompany';
        $edit = $this->model->editfielddata($data);
        if($edit[0]){
            return $this->success('更新成功');
        }
        return $this->error('更新失败');
    }
    public function editinterestway(){
        $data = input();
        $this->model->table = 'ny_interest_way';
        $edit = $this->model->editfielddata($data);
        if($edit[0]){
            return $this->success('更新成功');
        }
        return $this->error('更新失败');
    }
    public function editproduct(){
        $data = input();
        $this->model->table = 'ny_product';
        $edit = $this->model->editfielddata($data);
        if($edit[0]){
            return $this->success('更新成功');
        }
        return $this->error('更新失败');
    }

    public function editaction(){
        $data = input();
        $edit = $this->model->editfielddata($data);
        if($edit[0]){
            return $this->success('更新成功');
        }
        return $this->error('更新失败');
    }
    public function delback(){
        $this->model->table = 'ny_order_back';
        if($this->model->deldata(input())){
            return $this->success('删除成功');
        }
        return $this->error('删除失败');
    }
    public function delidtype(){
        $this->model->table = 'ny_id_type';
        if($this->model->deldata(input())){
            return $this->success('删除成功');
        }
        return $this->error('删除失败');
    }
    public function deladviser(){
        $this->model->table = 'ny_adviser';
        if($this->model->deldata(input())){
            return $this->success('删除成功');
        }
        return $this->error('删除失败');
    }
    public function delinvterm(){
        $this->model->table = 'ny_inv_term';
        if($this->model->deldata(input())){
            return $this->success('删除成功');
        }
        return $this->error('删除失败');
    }
    public function delcompany(){
        $this->model->table = 'ny_newcompany';
        if($this->model->deldata(input())){
            return $this->success('删除成功');
        }
        return $this->error('删除失败');
    }
    public function delinterestway(){
        $this->model->table = 'ny_interest_way';
        if($this->model->deldata(input())){
            return $this->success('删除成功');
        }
        return $this->error('删除失败');
    }
    public function delproduct(){
        $this->model->table = 'ny_product';
        if($this->model->deldata(input())){
            return $this->success('删除成功');
        }
        return $this->error('删除失败');
    }
    public function delaction(){
        if($this->model->deldata(input())){
            return $this->success('删除成功');
        }
        return $this->error('删除失败');
    }
    public function addaction(){
        $data = input();
        $data['deliver_time'] = strtotime($data['deliver_time']);
        $data['invoice_date'] = strtotime($data['invoice_date']);
        $data['receive_date'] = strtotime($data['receive_date']);
        $add = $this->model->adddata($data);
        if($add[0]){
            return $this->success('添加成功');
        }
        return $this->error('添加失败');
    }
    public function addinvoice(){
        $data = input();
        $data['create_time'] = time();
        $this->model->table = 'ny_order_invoice';
        $add = $this->model->adddata($data);
        if($add[0]){
            return $this->success('添加成功');
        }
        return $this->error('添加失败');
    }
    public function addone(){
        $data = input();
        $add = $this->model->adddata($data);
        if($add[0]){
            return $this->success('添加成功');
        }
        return $this->error('添加失败');
    }
    public function addback(){
        $data = input();

        $this->model->table = 'ny_order';
        $orderinfo = $this->model->getdatainfo(array('id'=>$data['oid']));
        $this->model->table = 'ny_order_back';
        $data['company'] = $orderinfo['company'];
        $data['salesman'] = $orderinfo['salesman'];
        $data['create_time'] = time();
        $add = $this->model->adddata($data);
        if($add[0]){
            return $this->success('添加成功');
        }
        return $this->error('添加失败');
    }
    public function addidtype(){
        $data = input();
        $this->model->table = 'ny_id_type';
        $data['create_time'] = time();
        $add = $this->model->adddata($data);
        if($add[0]){
            return $this->success('添加成功');
        }
        return $this->error('添加失败');
    }
    public function addadviser(){
        $data = input();
        $this->model->table = 'ny_adviser';
        $uid = cmf_get_current_admin_id();
        $user = $this->model->getUserById();
        $data['create_time'] = time();
        $data['company'] = $user['company'];
        $add = $this->model->adddata($data);
        if($add[0]){
            return $this->success('添加成功');
        }
        return $this->error('添加失败');
    }
    public function addinvterm(){
        $data = input();
        $this->model->table = 'ny_inv_term';
        $data['create_time'] = time();
        $add = $this->model->adddata($data);
        if($add[0]){
            return $this->success('添加成功');
        }
        return $this->error('添加失败');
    }
    public function addinterestway(){
        $data = input();
        $this->model->table = 'ny_interest_way';
        $data['create_time'] = time();
        $add = $this->model->adddata($data);
        if($add[0]){
            return $this->success('添加成功');
        }
        return $this->error('添加失败');
    }
    public function addcompany(){
        $data = input();
        $this->model->table = 'ny_newcompany';
        $data['create_time'] = time();
        $add = $this->model->adddata($data);
        if($add[0]){
            return $this->success('添加成功');
        }
        return $this->error('添加失败');
    }
    public function addproduct(){
        $data = input();
        $this->model->table = 'ny_product';
        $data['create_time'] = time();
        $add = $this->model->adddata($data);
        if($add[0]){
            return $this->success('添加成功');
        }
        return $this->error('添加失败');
    }
}