<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Jadwal_model', 'Dosen_model', 'Matakuliah_model', 'Ruangan_model']);
    }

    public function index() {
        $data['title'] = 'Data Jadwal';
        $data['jadwal_list'] = $this->Jadwal_model->get_all();
        
        $this->load->view('template/header', $data);
        $this->load->view('jadwal/index', $data);
        $this->load->view('template/footer');
    }

    public function calendar() {
        $data['title'] = 'Kalender Jadwal';
        $data['jadwal_list'] = $this->Jadwal_model->get_full_schedule();
        
        $this->load->view('template/header', $data);
        $this->load->view('jadwal/calendar', $data);
        $this->load->view('template/footer');
    }

    public function add() {
        $data['title'] = 'Tambah Jadwal';
        $data['dosen_list'] = $this->Dosen_model->get_all_active();
        $data['matkul_list'] = $this->Matakuliah_model->get_all();
        $data['ruangan_list'] = $this->Ruangan_model->get_all();
        $data['sks_options'] = $this->Jadwal_model->get_sks_options();
        
        $this->load->view('template/header', $data);
        $this->load->view('jadwal/form', $data);
        $this->load->view('template/footer');
    }

    public function edit($id) {
        $data['title'] = 'Edit Jadwal';
        $data['jadwal'] = $this->Jadwal_model->get_by_id($id);
        
        if (!$data['jadwal']) {
            $this->session->set_flashdata('error', 'Data jadwal tidak ditemukan');
            redirect('jadwal');
        }
        
        $data['dosen_list'] = $this->Dosen_model->get_all();
        $data['matkul_list'] = $this->Matakuliah_model->get_all();
        $data['ruangan_list'] = $this->Ruangan_model->get_all();
        $data['sks_options'] = $this->Jadwal_model->get_sks_options();
        
        $this->load->view('template/header', $data);
        $this->load->view('jadwal/edit', $data);
        $this->load->view('template/footer');
    }

    public function save() {
        $this->form_validation->set_rules('id_matkul', 'Mata Kuliah', 'required');
        $this->form_validation->set_rules('id_dosen', 'Dosen', 'required');
        $this->form_validation->set_rules('id_ruang', 'Ruangan', 'required');
        $this->form_validation->set_rules('hari', 'Hari', 'required');
        $this->form_validation->set_rules('sks_ke', 'SKS Mulai', 'required');
        $this->form_validation->set_rules('jumlah_sks', 'Jumlah SKS', 'required');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required');
        $this->form_validation->set_rules('semester', 'Semester', 'required');
        $this->form_validation->set_rules('tahun_ajaran', 'Tahun Ajaran', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            $this->add();
        } else {
            $data = [
                'id_matkul' => $this->input->post('id_matkul'),
                'id_dosen' => $this->input->post('id_dosen'),
                'id_ruang' => $this->input->post('id_ruang'),
                'hari' => $this->input->post('hari'),
                'sks_ke' => $this->input->post('sks_ke'),
                'jumlah_sks' => $this->input->post('jumlah_sks'),
                'kelas' => $this->input->post('kelas'),
                'semester' => $this->input->post('semester'),
                'tahun_ajaran' => $this->input->post('tahun_ajaran')
            ];
            
            $id_jadwal = $this->Jadwal_model->insert($data);
            
            if ($id_jadwal) {
                $validations = $this->Jadwal_model->validate_jadwal($id_jadwal);
                if (!empty($validations)) {
                    $this->session->set_flashdata('error', 'Jadwal berhasil ditambahkan tetapi ditemukan konflik');
                    foreach ($validations as $validation) {
                        $this->session->set_flashdata('validation_error', $validation->pesan_error);
                    }
                } else {
                    $this->session->set_flashdata('success', 'Data jadwal berhasil ditambahkan tanpa konflik');
                }
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data jadwal');
            }
            redirect('jadwal');
        }
    }

    public function update($id) {
        $this->form_validation->set_rules('id_matkul', 'Mata Kuliah', 'required');
        $this->form_validation->set_rules('id_dosen', 'Dosen', 'required');
        $this->form_validation->set_rules('id_ruang', 'Ruangan', 'required');
        $this->form_validation->set_rules('hari', 'Hari', 'required');
        $this->form_validation->set_rules('sks_ke', 'SKS Mulai', 'required');
        $this->form_validation->set_rules('jumlah_sks', 'Jumlah SKS', 'required');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required');
        $this->form_validation->set_rules('semester', 'Semester', 'required');
        $this->form_validation->set_rules('tahun_ajaran', 'Tahun Ajaran', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            $this->edit($id);
        } else {
            $data = [
                'id_matkul' => $this->input->post('id_matkul'),
                'id_dosen' => $this->input->post('id_dosen'),
                'id_ruang' => $this->input->post('id_ruang'),
                'hari' => $this->input->post('hari'),
                'sks_ke' => $this->input->post('sks_ke'),
                'jumlah_sks' => $this->input->post('jumlah_sks'),
                'kelas' => $this->input->post('kelas'),
                'semester' => $this->input->post('semester'),
                'tahun_ajaran' => $this->input->post('tahun_ajaran')
            ];
            
            if ($this->Jadwal_model->update($id, $data)) {
                $validations = $this->Jadwal_model->validate_jadwal($id);
                if (!empty($validations)) {
                    $this->session->set_flashdata('error', 'Jadwal berhasil diperbarui tetapi ditemukan konflik');
                    foreach ($validations as $validation) {
                        $this->session->set_flashdata('validation_error', $validation->pesan_error);
                    }
                } else {
                    $this->session->set_flashdata('success', 'Data jadwal berhasil diperbarui tanpa konflik');
                }
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data jadwal');
            }
            redirect('jadwal');
        }
    }

    public function delete($id) {
        if ($this->Jadwal_model->delete($id)) {
            $this->session->set_flashdata('success', 'Data jadwal berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data jadwal');
        }
        redirect('jadwal');
    }

    public function check_availability() {
        // Mengambil data dari POST
        $id_dosen = $this->input->post('id_dosen');
        $id_ruang = $this->input->post('id_ruang');
        $hari = $this->input->post('hari');
        $sks_ke = $this->input->post('sks_ke');
        $jumlah_sks = $this->input->post('jumlah_sks');
    
        // Cek ketersediaan
        $is_available = $this->Jadwal_model->check_availability($id_dosen, $id_ruang, $hari, $sks_ke, $jumlah_sks);
    
        if ($is_available) {
            $response = ['available' => true];
        } else {
            $response = ['available' => false, 'message' => 'Jadwal bentrok dengan jadwal yang sudah ada!'];
        }
    
        echo json_encode($response);
    }

    public function check_availability_edit() {
        // Mengambil data dari POST
        $id_dosen = $this->input->post('id_dosen');
        $id_ruang = $this->input->post('id_ruang');
        $hari = $this->input->post('hari');
        $sks_ke = $this->input->post('sks_ke');
        $jumlah_sks = $this->input->post('jumlah_sks');
        $current_id = $this->input->post('current_id'); // ID jadwal yang sedang diedit
    
        // Cek ketersediaan dengan memastikan current_id tidak kosong
        if (empty($current_id)) {
            $response = ['available' => false, 'message' => 'ID jadwal tidak valid!'];
            echo json_encode($response);
            return;
        }
    
        $is_available = $this->Jadwal_model->check_availability_edit($id_dosen, $id_ruang, $hari, $sks_ke, $jumlah_sks, $current_id);
    
        if ($is_available) {
            $response = ['available' => true];
        } else {
            $response = ['available' => false, 'message' => 'Jadwal bentrok dengan jadwal yang sudah ada!'];
        }
    
        echo json_encode($response);
    }
}