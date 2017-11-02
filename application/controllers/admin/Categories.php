<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends Admin_Controller {

    public function __construct(){
        parent::__construct();

        /* Load :: Common */
		$this->lang->load('admin/posts');

        /* Title Page :: Common */
		$this->page_title->push(lang('menu_categories'));
		$this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, lang('menu_categories'), 'admin/categories');
		$this->load->helper("url");
		$this->load->library("pagination");

		/*Loading Models*/
		$this->load->model("admin/Post_M");
    }


	public function index(){
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()){
            redirect('auth/login', 'refresh');
		}else{
            /* Breadcrumbs */
			$this->data['breadcrumb'] = $this->breadcrumbs->show();

			/*Loading Models*/
			$this->load->model("Core_model");

			/* Get all categories */
	        $config = array();
	        $config["base_url"] = site_url() . "admin/categories/index";
	        $config["total_rows"] = $this->Core_model->record_count('categories');
	        $config["per_page"] = 2;
	        $config["uri_segment"] = 4;
	        $config['use_page_numbers'] = TRUE;
	        $this->pagination->initialize($config);
	        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
			$offset = ($page - 1) * $config['per_page'];
	        $this->data["categories"] = $this->Core_model->fetch_data('categories',$config["per_page"], $offset);
	        $this->data["links"] = $this->pagination->create_links();


	        /* Variables */
			$tables = $this->config->item('tables', 'ion_auth');

			/* Validate form input */
			$this->form_validation->set_rules('category_name', 'lang:posts_category_name', 'required');

			if ($this->form_validation->run() == TRUE){
				
				$main_data = array(
					'category_name'	 		=> $this->input->post('category_name'),
					'category_slug'  		=> slug($this->input->post('category_name'),'categories','category_slug'),
					'category_description'  => $this->input->post('category_description'),
				);
			}

			if ($this->form_validation->run() == TRUE && $this->Post_M->insertcategory($main_data)){
	            $this->session->set_flashdata('message', 'Category Successfully Created');
				redirect('admin/categories', 'refresh');
			}else{
	            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

				$this->data['category_name'] = array(
					'name'  => 'category_name',
					'id'    => 'category_name',
					'type'  => 'text',
	                'class' => 'form-control',
					'value' => $this->form_validation->set_value('category_name'),
				);
				$this->data['category_description'] = array(
					'name'  => 'category_description',
					'id'    => 'category_description',
					'type'  => 'text',
	                'class' => 'form-control',
					'value' => $this->form_validation->set_value('category_description'),
				);

	            /* Load Template */
	            $this->template->admin_render('admin/categories/index', $this->data);
	        }
	    }
	}

	public function delete(){
		if ( ! $this->ion_auth->logged_in() OR ( ! $this->ion_auth->is_admin())){
			redirect('auth', 'refresh');
		}

        /* Load Template */
		$this->template->admin_render('admin/categories/delete', $this->data);
	}


	public function _get_csrf_nonce(){
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}


	public function _valid_csrf_nonce(){
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE && $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}
