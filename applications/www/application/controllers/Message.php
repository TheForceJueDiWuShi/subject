<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Message extends MY_Controller{
    public function __construct(){
        parent::__construct();       
        $this->load->Model([
            'Model_message' => 'Message'
        ]);
    }
    
    public function index(){
        $data = $this->data;
        $token = $this->createNonceStr();
        $data['csrf'] = $token;
        $this->session->set_userdata('_csrf', $token);
        //显示前十条留言数据
        $data['lists'] = $this->Message->get_lists('msg, create_time', ['is_del' => 0], ['create_time' => 'desc'], $limit = 10);
        $this->load->view('message/index', $data);
    }
    
    public function code(){
        $this->load->library('valicode');
        $this->valicode->outImg('p_yzm');
    }
    
    public function save(){
        $url = C('domain.h5.url');
        header( "Access-Control-Allow-Origin: {$url}");
        if(IS_POST){
            $p_yzm = trim($this->input->post('p_yzm'));
            if(!p_yzm){
                $this->return_json(['code' => 0, 'msg' => '验证码不能为空']);
            }
            //判断验证码是否正确
            if($p_yzm != $_SESSION['p_yzm']){
                $this->return_json(['code' => 0, 'msg' => '验证码错误']);
            }
            $msg = trim($this->input->post('msg'));
            if(!$msg){
                $this->return_json(['code' => 0, 'msg' => '留言不能为空']);
            }
            $csrf = trim($this->input->post('_csrf'));
            if($csrf){
                $_csrf = $this->session->userdata('_csrf');
                if($csrf == $_csrf){
                    //判断今天是否能提交留言
                    $ip = get_client_ip();
                    //判断留言是否重复
                    $count = $this->Message->count(['msg' => $msg]);
                    if($count){
                        $this->return_json(['code' => 0, 'msg' => "您的留言内容已经被人抢先发表啦！"]);
                    }
                    $time = date('Y-m-d H:i:s');
                    $add = [
                        'msg' => $msg,
                        'ip' => $ip,
                        'time' => date('Y-m-d'),
                        'create_time' => $time
                    ];
                    $res = $this->Message->create($add);
                    if(!$res){
                        $this->return_json(['code' => 0, 'msg' => '留言失败，请重试']);
                    }
                    $this->return_json(['code' => 1, 'msg' => '留言成功', 'time' => $time]);
                }else{
                    $this->return_json(['code' => 0, 'msg' => '请重新刷新当前页面']);
                }
            }else{
                $this->return_json(['code' => 0, 'msg' => 'error: csrf is empty']);
            }
        }
    }
    
    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
}