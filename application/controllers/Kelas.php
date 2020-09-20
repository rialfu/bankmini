<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->helper(array('form','url'));
        $this->load->library('session');
        $this->load->model('M_Setting');        
        $this->load->model('M_Kelas');
        cek_login_user();
    }

	public function index()
	{
        $data['menu'] = $this->M_Setting->getmenu1();
        $data['kelas'] = $this->M_Kelas->getkelas();

		// $id = $this->session->userdata('tipeuser');
		$this->load->view('template/header');
		$this->load->view('template/sidebar', $data);
		$this->load->view('v_kelas/v_kelas', $data);
		$this->load->view('template/footer');
	}	

	public function kelas_add(){
		 $data['menu'] = $this->M_Setting->getmenu1();
		
		$this->load->view('template/header');
		$this->load->view('template/sidebar', $data);
		$this->load->view('v_kelas/v_kelas-add');
		$this->load->view('template/footer');
	}

	public function add_process(){
		$data = array(
				'id_kelas' => '' , 
				'kelas' => $this->input->post('kelas', true),
				'status' => 'aktif',
				'id_user' => $this->session->userdata('id_user'),
				'tglupdate' => date("Y-m-d h:i:sa")
			);

		$this->M_Kelas->addKelas($data);
		$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
                                            		<strong>Sukses!</strong> Berhasil Menambahkan Kelas Baru.
                                        		</div>');
		redirect(base_url('kelas/'));
	}

	public function kelas_delete($id){
		$this->M_Kelas->delKelas($id);
		$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
                                            		<strong>Sukses!</strong> Berhasil Menghapus Kelas.
                                        		</div>');
		redirect(base_url('kelas/'));
	}

	public function kelas_edit($id){
		$data['menu'] = $this->M_Setting->getmenu1();
		$data['kelas'] = $this->M_Kelas->getkelasDetail($id);
		// print_r(expression)
		$this->load->view('template/header');
		$this->load->view('template/sidebar', $data);
		$this->load->view('v_kelas/v_kelas-edit', $data);
		$this->load->view('template/footer');
	}

	public function edt_process(){
		$id = $this->input->post('idKelas', true);
		$data = array(
				'kelas' => $this->input->post('kelas', true),
				'id_user' => 1,
				'tglupdate' => date("Y-m-d h:i:sa")
			);

		$this->M_Kelas->editKelas($data, $id);
		$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
                                            		<strong>Sukses!</strong> Berhasil Mengubah Kelas.
                                        		</div>');
		redirect(base_url('kelas/'));	
	}

	public function delete_all(){
		$this->M_Kelas->deleteSemuaKelas();
		$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
                                            		<strong>Sukses!</strong> Berhasil Menghapus Semua Kelas.
                                        		</div>');
		redirect(base_url('kelas/'));
	}
}