<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends Admin_Controller {

    public function __construct(){
        parent::__construct();

        /* Load :: Common */
		$this->lang->load('admin/posts');

        /* Title Page :: Common */
		$this->page_title->push(lang('menu_posts'));
		$this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, lang('menu_posts'), 'admin/posts');
		$this->load->helper("url");
		$this->load->helper('ckeditor');
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

			/* Get all posts */
	        $config = array();
	        $config["base_url"] = site_url() . "admin/posts/index";
	        $config["total_rows"] = $this->Core_model->record_count('posts');
	        $config["per_page"] = 1;
	        //$config['suffix'] = '?'.http_build_query($_REQUEST, '', "&");
	        $config['reuse_query_string'] = TRUE;
	        $config["uri_segment"] = 4;
	        $config['use_page_numbers'] = TRUE;
	        $this->pagination->initialize($config);
	        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
			$offset = ($page - 1) * $config['per_page'];
	        $this->data["posts"] = $this->Core_model->fetch_data('posts',$config["per_page"], $offset);
	        $this->data["links"] = $this->pagination->create_links();

			/* Load Template */
			$this->template->admin_render('admin/posts/index', $this->data);
        }
	}


	public function create(){
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()){
            redirect('auth/login', 'refresh');
		}else{
			/* Breadcrumbs */
	        $this->breadcrumbs->unshift(2, lang('posts_create_post'), 'admin/posts/create');
	        $this->data['breadcrumb'] = $this->breadcrumbs->show();

	        /* Variables */
			$tables = $this->config->item('tables', 'ion_auth');

			/* Validate form input */
			$this->form_validation->set_rules('post_title', 'lang:posts_post_title', 'required');

			if ($this->form_validation->run() == TRUE){
				
				$main_data = array(
					'post_title'	 	=> $this->input->post('post_title'),
					'slug'	 			=> slug($this->input->post('post_title')),
					'post_content'  	=> $this->input->post('post_content'),
					'post_category'  	=> json_encode($this->input->post('post_category')),
					'post_type'  		=> 'post',
					'post_status'  		=> 'published',
					'created_by'  		=> $this->data['user_login']['username'],
				);
			}
			if ($this->form_validation->run() == TRUE && $this->Post_M->insertpost($main_data)){
	            $this->session->set_flashdata('message', 'Post Successfully Created');
				redirect('admin/posts', 'refresh');
			}else{
	            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

				$this->data['post_title'] = array(
					'name'  => 'post_title',
					'id'    => 'post_title',
					'type'  => 'text',
	                'class' => 'form-control',
					'value' => $this->form_validation->set_value('post_title'),
				);
				$this->data['post_content'] = $this->input->post('post_content');
				$this->data['post_category'] = $this->input->post('post_category');
				$this->data['list_category'] = $this->db->get('categories')->result();

	            /* Load Template */
	            $this->template->admin_render('admin/posts/create', $this->data);
	        }
	    }
	}

	public function delete(){
		if ( ! $this->ion_auth->logged_in() OR ( ! $this->ion_auth->is_admin())){
			redirect('auth', 'refresh');
		}

        /* Load Template */
		$this->template->admin_render('admin/users/delete', $this->data);
	}


	public function edit($id){
        $id = (int) $id;

		if ( ! $this->ion_auth->logged_in() OR ( ! $this->ion_auth->is_admin() && ! ($this->ion_auth->user()->row()->id == $id))){
			redirect('auth', 'refresh');
		}

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_posts_edit'), 'admin/posts/edit');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        /* Data */
		$post          = $this->Post_M->post($id)->row();

		//$groups        = $this->ion_auth->groups()->result_array();
		//$currentGroups = $this->ion_auth->get_users_groups($id)->result();


		/* Validate form input */
		$this->form_validation->set_rules('post_title', 'lang:posts_post_title', 'required');

		if (isset($_POST) && ! empty($_POST)){
            if ($this->_valid_csrf_nonce() === FALSE OR $id != $this->input->post('id')){
				show_error($this->lang->line('error_csrf'));
			}


			if ($this->form_validation->run() == TRUE){
				$data = array(
					'post_title'	 	=> $this->input->post('post_title'),
					'slug'	 			=> ($this->input->post('post_title') == $post->post_title) ? $post->slug : slug($this->input->post('post_title')) ,
					'post_content'  	=> $this->input->post('post_content'),
					'post_category'  	=> json_encode($this->input->post('post_category')),
					'post_type'  		=> 'post',
					'post_status'  		=> 'published',
					'created_by'  		=> $this->data['user_login']['username'],
				);

                if($this->Post_M->updatepost($post->id, $data)){
                    $this->session->set_flashdata('message', $this->ion_auth->messages());

				    if ($this->ion_auth->is_admin()){
						redirect('admin/posts', 'refresh');
					}else{
						redirect('admin', 'refresh');
					}
			    }else{
                    $this->session->set_flashdata('message', $this->ion_auth->errors());

				    if ($this->ion_auth->is_admin()){
						redirect('auth', 'refresh');
					}else{
						redirect('/', 'refresh');
					}
			    }
			}
		}

		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		//$this->data['user']          = $user;
		//$this->data['groups']        = $groups;
		//$this->data['currentGroups'] = $currentGroups;
		$this->data['list_category'] = $this->db->get('categories')->result();

		$this->data['post_id'] = $post->id;
		$this->data['post_title'] = array(
			'name'  => 'post_title',
			'id'    => 'post_title',
			'type'  => 'text',
            'class' => 'form-control',
			'value' => $this->form_validation->set_value('post_title', $post->post_title)
		);
		$this->data['post_content'] 	= $post->post_content;
		$this->data['post_category'] 	= json_decode($post->post_category);



        /* Load Template */
		$this->template->admin_render('admin/posts/edit', $this->data);
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
