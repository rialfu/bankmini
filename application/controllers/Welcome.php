<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->model('M_Setting');

		$this->load->model('M_Siswa');
		$this->load->model('M_Kelas');
		cek_login_user();
	}

	public function index()
	{
		// var_dump($this->session);
		$thisM = date('m');
		$id = $this->session->userdata('tipeuser');
		$nominalKredit = 0;
		$nominalDebet = 0;
		$debet = $this->db->query("SELECT tb_transaksi.nominal FROM tb_transaksi JOIN tb_mastertransaksi ON tb_transaksi.id_jenistransaksi = tb_mastertransaksi.id_mastertransaksi WHERE tb_mastertransaksi.debet = 'koperasi' AND MONTH(tb_transaksi.tgl_update) = $thisM")->result(); 
		foreach($debet as $row){
			$nominalDebet = $row->nominal + $nominalDebet;
		}
		$kredit = $this->db->query("SELECT tb_transaksi.nominal FROM tb_transaksi JOIN tb_mastertransaksi ON tb_transaksi.id_jenistransaksi = tb_mastertransaksi.id_mastertransaksi WHERE tb_mastertransaksi.kredit = 'koperasi' AND MONTH(tb_transaksi.tgl_update) = $thisM")->result(); 
		foreach($kredit as $row){
			$nominalKredit = $row->nominal + $nominalKredit;
		}

		$siswa = $this->db->where('status', 'aktif')->get('tb_siswa')->num_rows();
		$staff = $this->db->where('status', 'aktif')->get('tb_staf')->num_rows();

		$data['menu'] = $this->M_Setting->getmenu1($id);
		$data['dataAnggota'] = $siswa + $staff;
		$data['kredit'] = $nominalKredit;
		$data['debet'] = $nominalDebet;
		$data['saldo'] = $nominalDebet - $nominalKredit;
		$data['kelas'] = $this->M_Kelas->getkelas();
		$data['activeMenu'] = '';

		$this->load->view('template/header');
		$this->load->view('template/sidebar', $data);
		$this->load->view('template/index', $data);
		$this->load->view('template/footer');
	}

	public function getTransaksiChart()
	{
		$thisM = date('m');		
		
		// $data['dataTransaksi'] = $this->db->query("SELECT CONVERT(DATE_FORMAT(tb_transaksi.tgl_update, '%d'), SIGNED INTEGER) AS tgl, IF(tb_mastertransaksi.kredit = tb_transaksi.tipeuser || tb_mastertransaksi.kredit = 'koperasi', CONVERT(CONCAT('-',tb_transaksi.nominal), SIGNED INTEGER), CONVERT(tb_transaksi.nominal, SIGNED INTEGER)) AS nominal, IF(tb_mastertransaksi.kredit = tb_transaksi.tipeuser || tb_mastertransaksi.kredit = 'koperasi', 'debet', 'kredit') AS tipe FROM tb_transaksi JOIN tb_mastertransaksi ON tb_transaksi.id_jenistransaksi = tb_mastertransaksi.id_mastertransaksi WHERE tb_mastertransaksi.kredit != ' ' OR tb_mastertransaksi.debet != ' ' AND MONTH(tb_transaksi.tgl_update) = $thisM")->result();		


		$data['dataTransaksi'] = $this->db->query("SELECT CONVERT(DATE_FORMAT(tb_transaksi.tgl_update, '%d'), SIGNED INTEGER) AS tgl, 
			IF(tb_mastertransaksi.kredit = 'koperasi', CONVERT(CONCAT(tb_transaksi.nominal), SIGNED INTEGER), CONVERT(tb_transaksi.nominal, SIGNED INTEGER)) AS nominalkredit, 
			IF(tb_mastertransaksi.debet = 'koperasi', CONVERT(CONCAT(tb_transaksi.nominal), SIGNED INTEGER), CONVERT(tb_transaksi.nominal, SIGNED INTEGER)) AS nominaldebet, 
			IF(tb_mastertransaksi.debet = 'koperasi', 'debet', 'kredit') AS tipe 
			FROM tb_transaksi JOIN tb_mastertransaksi ON tb_transaksi.id_jenistransaksi = tb_mastertransaksi.id_mastertransaksi 
			WHERE tb_mastertransaksi.kredit = 'koperasi' OR tb_mastertransaksi.debet = 'koperasi' AND MONTH(tb_transaksi.tgl_update) = $thisM")->result();		

		$kelas = $this->db->query('SELECT UPPER(tb_kelas.grup) as kelas, COUNT(tb_siswa.id_kelas) AS jmlsiswa FROM tb_siswa JOIN tb_kelas ON tb_siswa.id_kelas = tb_kelas.id_kelas WHERE tb_siswa.status = "aktif" GROUP BY tb_kelas.grup ORDER BY jmlsiswa ASC')->result();	
		
		$data['dataSiswa'] = $kelas;
		echo json_encode($data);
		// $data['kredit'] = $nominalKredit;
		// $data['debet'] = $nominalDebet;
		// $data['saldo'] = $nominalKredit - $nominalDebet;
	}
}
