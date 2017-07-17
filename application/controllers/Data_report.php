<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2017/3/23
 * Time: 15:05
 */
class Data_report extends CI_Controller
{
    function __construct()
    {
        parent :: __construct();
    }

    function index()
    {

    }

    function print_form_report()
    {
       // $this->print_data("XXX店营业日报表","","");

        $seach_name = $this->input->get_post("seach_name");
        $start_date = $this->input->get_post("start_date");
        $end_date = $this->input->get_post("end_date");
        $table_data = $this->input->get_post("table_data");
        $table_header = $this->input->get_post("table_header");

        // Starting the PHPExcel library
        $this -> load -> library('PHPExcel');
        $this -> load -> library('PHPExcel/IOFactory');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel -> getProperties() -> setTitle($seach_name."_报表") -> setDescription("起始时间:".$start_date."至".$end_date);
        $objPHPExcel -> setActiveSheetIndex(0);

        $objPHPExcel->getProperties()->setCreator("点美");// 设置excel的属性： 创建人
        $objPHPExcel->getProperties()->setLastModifiedBy("点美");//最后修改人
        $objPHPExcel->getProperties()->setTitle($seach_name."报表"); //标题
        $objPHPExcel->getProperties()->setSubject("2016年3月1日-2016年3月31日"); //题目
        $objPHPExcel->getProperties()->setDescription("门店报表123456");//描述
        $objPHPExcel->getProperties()->setKeywords("b 2007 openxml php");//关键字
        $objPHPExcel->getProperties()->setCategory("Test result file");//种类

        // Field names in the first row
        //$fields = $query -> list_fields();
        $col = 0;

        $json_table_header = json_decode($table_header);
        foreach ($json_table_header as  $key => $value)
        {
            $objPHPExcel -> getActiveSheet() -> setCellValueByColumnAndRow($col, 1, $value);
            $col++;
        }
        // Fetching the table data
        $row = 2;
        $json_table_data = json_decode($table_data);
        foreach($json_table_data as  $key => $value)
        {
            $col = 0;
            foreach ($value as  $key2 => $value2)
            {
                $value2_tem = str_replace('<span style="color: red">',"",$value2);
                $value2_tem = str_replace('</span>',"",$value2_tem);
                $objPHPExcel -> getActiveSheet() -> setCellValueByColumnAndRow($col, $row, $value2_tem);
                $col++;
            }

            $row++;
        }

        $objPHPExcel -> setActiveSheetIndex(0);
        $objWriter = IOFactory :: createWriter($objPHPExcel, 'Excel5');
        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$seach_name."_" . date('ymd') . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter -> save('php://output');

    }
}


?>