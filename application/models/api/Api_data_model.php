<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2017/1/9
 * Time: 11:11
 */

date_default_timezone_set("Asia/Shanghai");
class Api_data_model extends CI_Model
{

    public function  get_user($user){

    }

    public function post_url($url,$postData)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $json = curl_exec($ch);
        curl_close($ch);
        return $json;
    }

    public function get_url($url)
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        return $data;
    }

    public function get_cook_url($url,$post="")
    {
        // 设置cookie保存路径
        $cookie = dirname(__FILE__) . '/cookie_student.txt';
        $curl = curl_init();//初始化curl模块
        curl_setopt($curl, CURLOPT_URL, $url);//登录提交的地址
        curl_setopt($curl, CURLOPT_HEADER, 0);//是否显示头信息
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,0);//是否自动显示返回的信息
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie); //设置Cookie信息保存在指定的文件中
        curl_setopt($curl, CURLOPT_POST, 1);//post方式提交
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));//要提交的信息
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//文件流输出
        curl_setopt($curl, CURLOPT_NOBODY, 1);//文件流输出
        $a=curl_exec($curl);//执行cURL
        curl_close($curl);//关闭cURL资源，并且释放系统资源
    }

    public function add_task_change($chage_storeid,$chage_companyid,$orderTime,$serverTimeNow,$chage_type,$orderId,$staffid)
    {
        $sql = "insert into sp_task_chage (`chage_storeid`,`chage_companyid`,`chage_before_time`,`chage_after_time`,`chage_type`,`data`,`staff_id`) values (?,?,?,?,?,?,?)";
        $this->db->query($sql,array($chage_storeid,$chage_companyid,$orderTime,$serverTimeNow,$chage_type,$orderId,$staffid));
        //echo $this->db->last_query();
        return $this->db->affected_rows();
    }

    public function get_sys_info($id)
    {
        $sql = "SELECT companyid,storeid,staffid FROM bm_order where id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }
}
?>