<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Core_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function record_count($table='') {
        if(!empty($table)){

            if(!empty($this->input->post_get('post_type', TRUE))){
                $post_type = $this->input->post_get('post_type', TRUE);
                if(is_array($post_type)){
                    $this->db->where_in('post_type',$post_type);
                }else{
                    $this->db->where_in('post_type',explode(',',$post_type));
                }
            }

            if(!empty($this->input->post_get('cat', TRUE))){
                $post_category = $this->input->post_get('cat', TRUE);
                $this->db->like('post_category', '"'.$post_category.'"');
            }

            return $this->db->count_all_results($table);
        }
        return false;
    }

    public function fetch_data($table='',$limit=1, $start=0) {
        if(!empty($table)){

            if(!empty($this->input->post_get('post_type', TRUE))){
                $post_type = $this->input->post_get('post_type', TRUE);
                if(is_array($post_type)){
                    $this->db->where_in('post_type',$post_type);
                }else{
                    $this->db->where_in('post_type',explode(',',$post_type));
                }
            }

            if(!empty($this->input->post_get('cat', TRUE))){
                $post_category = $this->input->post_get('cat', TRUE);
                $this->db->like('post_category', $post_category);
            }

            $this->db->limit($limit, $start);
            $query = $this->db->get($table);
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $data[] = $row;
                }
                return $data;
            }
            return false;
        }
        return false;
   }


}
