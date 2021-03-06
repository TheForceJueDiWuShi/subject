<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Map extends MY_Controller{
    public function __construct(){
        parent::__construct();
        //切换到媒介系统数据库
        $this->db->db_select('adv_manage');
        
        $this->load->Model([
            'Model_points' => 'Mpoints',
            'Model_medias' => 'Mmedias',
            'Model_customers' => 'Mcustomers',
            'Model_specifications' => 'Mspecifications'
        ]);
        $this->load->driver('cache');
    }
    
    public function index(){
        $data = $this->data;
        $typeid = (int) $this->input->get('typeid');
        if(!$typeid){
            $this->load->view('map/main', $data);
        }else{
            $data['title'] = '';
            foreach (C('media.media_type') as $k => $v){
                if($typeid == $k){
                    $data['title'] = '时代传媒'.$v.'分布';
                    break;
                }
            }
            //查看是否有缓存
            $list = $this->cache->file->get('media_lists_type_'.$typeid);
            if($list){
                $data['lists'] = $list;
                $this->load->view('map/index', $data);
            }else{
                //查询媒体资源类型
                $info = $this->Mmedias->get_lists('id', ['type' => $typeid, 'is_del' => 0]);
                if($info){
                    $ids = array_column($info, 'id');
                    if($ids){
                        $fields = 'id,price,address,customer_id,tx_coordinate,tx_jiejingid,images,is_lock,points_code,lock_start_time,lock_end_time,point_status';
                        $lists = $this->Mpoints->get_lists($fields, ['in' => ['media_id' => $ids], 'is_del' => 0]);
                    }
                }
                if($lists){
                    $data['lists'] = $lists;
                    foreach ($lists as $k => $v){
                        $data['lists'][$k]['customer_name'] = '';
                        $data['lists'][$k]['specification_name']='';
                        if($v['images']){
                            $data['lists'][$k]['images'] = explode(';', $v['images']);
                        }
                    }
                    //获取所有customer_id
                    $customer_ids = array_column($lists, 'customer_id');
                    if($customer_ids){
                        $customer = $this->Mcustomers->get_lists('id,customer_name', ['in' => ['id' => $customer_ids]]);
                        if($customer){
                            foreach ($lists as $k => $v){
                                foreach ($customer as $key => $val){
                                    if($v['customer_id'] == $val['id']){
                                        $data['lists'][$k]['customer_name'] = $val['customer_name'];
                                    }
                                }
                            }
                        }
                    }
                    //获取所有规格specification_id
                    $specification_ids = array_column($lists, 'specification_id');
                    if($specification_ids){
                        $specification = $this->Mspecifications->get_lists('id,name,size', ['in' => ['id' => $specification_ids]]);
                        if($specification){
                            foreach ($lists as $k => $v){
                                foreach ($specification as $key => $val){
                                    if($v['specification_id'] == $val['id']){
                                        $data['lists'][$k]['specification_name'] = $val['name'].$val['size'];
                                    }
                                }
                            }
                        }
                    }
                
                    $this->cache->file->save('media_lists_type_'.$typeid, $data['lists'], 5*60); //缓存5分钟
                }
                $this->load->view('map/index', $data);
            }
        }
    }
    
}