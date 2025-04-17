<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Jadwal_model', 'Dosen_model', 'Matakuliah_model', 'Ruangan_model']);
    }

    public function index() {
        $data['title'] = 'Dashboard';
        $data['total_dosen'] = $this->Dosen_model->count_all();
        $data['total_matkul'] = $this->Matakuliah_model->count_all();
        $data['total_ruangan'] = $this->Ruangan_model->count_all();
        $data['total_jadwal'] = $this->Jadwal_model->count_all();
        $data['recent_validations'] = $this->Jadwal_model->get_recent_validations();
        
        // Data untuk chart distribusi jadwal
        $data['monday_count'] = $this->Jadwal_model->count_by_day('Senin');
        $data['tuesday_count'] = $this->Jadwal_model->count_by_day('Selasa');
        $data['wednesday_count'] = $this->Jadwal_model->count_by_day('Rabu');
        $data['thursday_count'] = $this->Jadwal_model->count_by_day('Kamis');
        $data['friday_count'] = $this->Jadwal_model->count_by_day('Jumat');
        $data['saturday_count'] = $this->Jadwal_model->count_by_day('Sabtu');
        
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('template/footer');
    }
}