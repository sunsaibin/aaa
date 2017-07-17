<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/12/9
 * Time: 15:26
 */
class Flow_dictionary_statics_model extends CI_Model
{
    private $select_sql = array();

    public function __construct()
    {
        parent::__construct();

        $this->select_sql["bm_staff_salarytype"] = $this->bm_staff_salarytype();
        $this->select_sql["get_staff_performancetype"] = $this->get_staff_performancetype();
        $this->select_sql["get_staff_education"] = $this->get_staff_education();
        $this->select_sql["get_staff_bandcard"] = $this->get_staff_bandcard();
        $this->select_sql["get_staff_handtype"] = $this->get_staff_handtype();
        $this->select_sql["bm_staff_sextype"] = $this->bm_staff_sextype();
        $this->select_sql["get_staff_department"] = $this->get_staff_department();
        $this->select_sql["get_store_companyranklevel"] = $this->get_store_companyranklevel();
        $this->select_sql["get_staff_overtime_handtype"] = $this->get_staff_overtime_handtype();
    }

    private  function  get_staff_department(){
        $department_type = array();
        array_push($department_type, array('option_key' =>1 , 'option_value'=>"美发"));
        array_push($department_type, array('option_key' =>2 , 'option_value'=>"美容"));
        array_push($department_type, array('option_key' =>3 , 'option_value'=>"美甲"));
        return $department_type;
    }

    private  function  bm_staff_sextype(){
        $sextype = array();
        array_push($sextype, array('option_key' =>1 , 'option_value'=>"男"));
        array_push($sextype, array('option_key' =>0 , 'option_value'=>"女"));
        return $sextype;
    }

    public  function  bm_staff_salarytype(){
        $salarytype = array();
        array_push($salarytype, array('option_key' =>1 , 'option_value'=>"税前"));
        array_push($salarytype, array('option_key' =>2 , 'option_value'=>"税后"));
        return $salarytype;
    }

    private function  get_staff_performancetype(){
        $performancetype = array();

        array_push($performancetype, array('option_key' =>1 , 'option_value'=>"美发虚业绩"));
        array_push($performancetype, array('option_key' =>2 , 'option_value'=>"美容虚业绩"));
        array_push($performancetype, array('option_key' =>3 , 'option_value'=>"总虚业绩"));
        array_push($performancetype, array('option_key' =>4 , 'option_value'=>"美发实业绩"));
        array_push($performancetype, array('option_key' =>5 , 'option_value'=>"美容实业绩"));
        array_push($performancetype, array('option_key' =>6 , 'option_value'=>"总实业绩"));
        array_push($performancetype, array('option_key' =>7, 'option_value'=>"无业绩"));
        return $performancetype;
    }

    private function get_staff_education()
    {
        $education = array();

        array_push($education, array('option_key' =>1 , 'option_value'=>"本科"));
        array_push($education, array('option_key' =>2 , 'option_value'=>"大专"));
        array_push($education, array('option_key' =>3 , 'option_value'=>"高中"));
        array_push($education, array('option_key' =>4 , 'option_value'=>"初中"));
        return $education;
    }

    private function get_staff_bandcard()
    {
        $bandcard = array();

        array_push($bandcard, array('option_key' =>1 , 'option_value'=>"农业银行"));
        array_push($bandcard, array('option_key' =>2 , 'option_value'=>"建设银行"));
        array_push($bandcard, array('option_key' =>3 , 'option_value'=>"工商银行"));
        array_push($bandcard, array('option_key' =>4 , 'option_value'=>"交通银行"));
        array_push($bandcard, array('option_key' =>5 , 'option_value'=>"中国银行"));
        array_push($bandcard, array('option_key' =>6 , 'option_value'=>"招商银行"));
        return $bandcard;
    }

    private function get_staff_handtype()
    {
        $handtype = array();

        array_push($handtype, array('option_key' =>1 , 'option_value'=>"病假"));
        array_push($handtype, array('option_key' =>2 , 'option_value'=>"事假"));
        array_push($handtype, array('option_key' =>3 , 'option_value'=>"婚假"));
        array_push($handtype, array('option_key' =>4 , 'option_value'=>"丧假"));
        array_push($handtype, array('option_key' =>5 , 'option_value'=>"公休"));
        array_push($handtype, array('option_key' =>6 , 'option_value'=>"产假"));
        array_push($handtype, array('option_key' =>7 , 'option_value'=>"年假"));
        array_push($handtype, array('option_key' =>8 , 'option_value'=>"培训假"));
        array_push($handtype, array('option_key' =>9 , 'option_value'=>"学习假"));
        return $handtype;
    }

    private function get_staff_overtime_handtype()
    {
        $overtimetype = array();

        array_push($overtimetype, array('option_key' =>1 , 'option_value'=>"工作日加班"));
        array_push($overtimetype, array('option_key' =>2 , 'option_value'=>"休息日加班"));
        array_push($overtimetype, array('option_key' =>3 , 'option_value'=>"节假日加班"));
        return $overtimetype;
    }

    public function get_store_companyranklevel()
    {
        $companyranklevel = array();
        array_push($companyranklevel, array('option_key' =>1 , 'option_value'=>"A级"));
        array_push($companyranklevel, array('option_key' =>2 , 'option_value'=>"B级"));
        array_push($companyranklevel, array('option_key' =>3 , 'option_value'=>"C级"));
        array_push($companyranklevel, array('option_key' =>4 , 'option_value'=>"D级"));
        return $companyranklevel;
    }

    public function is_static_select_option($model)
    {
        if (array_key_exists($model, $this->select_sql)) {
            return true;
        }
        return false;
    }

    public function get_select_option($data,$model)
    {
        $companyid = $data["companyid"];

        if (array_key_exists($model, $this->select_sql)) {
            $model_data = $this->select_sql[$model];
            return $model_data;
        }
    }
}