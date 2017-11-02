<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_M extends CI_Model {

    public function __construct(){
        parent::__construct();
    }


    public function insertpost($postdata){
        return (!empty($postdata)) ? $this->db->insert('posts', $postdata) : FALSE ;
    }

    public function updatepost($postid, $postdata){
        return (!empty($postdata) && !empty($postid)) ? $this->db->update('posts', $postdata, array('id' => $postid)) : FALSE ;
    }

    public function insertcategory($categorydata){
        return (!empty($categorydata)) ? $this->db->insert('categories', $categorydata) : FALSE ;
    }

    public function post($id){
        return (!empty($id)) ? $this->db->get_where('posts', array('id' => $id)) : FALSE;
    }



}
