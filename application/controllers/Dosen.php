<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dosen_model');
    }

    public function index() {
        $data['title'] = 'Data Dosen';
        $data['dosen_list'] = $this->Dosen_model->get_all();
        
        $this->load->view('template/header', $data);
        $this->load->view('dosen/index', $data);
        $this->load->view('template/footer');
    }

    public function add() {
        $data['title'] = 'Tambah Dosen';
        
        $this->load->view('template/header', $data);
        $this->load->view('dosen/form', $data);
        $this->load->view('template/footer');
    }

    public function edit($id) {
        $data['title'] = 'Edit Dosen';
        $data['dosen'] = $this->Dosen_model->get_by_id($id);
        
        if (!$data['dosen']) {
            $this->session->set_flashdata('error', 'Data dosen tidak ditemukan');
            redirect('dosen');
        }
        
        $this->load->view('template/header', $data);
        $this->load->view('dosen/edit', $data);
        $this->load->view('template/footer');
    }

    public function save() {
        $this->form_validation->set_rules('kode_dosen', 'Kode Dosen', 'required|callback_check_kode_unique');
        $this->form_validation->set_rules('nama_dosen', 'Nama Dosen', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            $this->add();
        } else {
            $data = [
                'kode_dosen' => $this->input->post('kode_dosen'),
                'nama_dosen' => $this->input->post('nama_dosen'),
                'status_aktif' => $this->input->post('status_aktif') ? 1 : 0
            ];
            
            if ($this->Dosen_model->insert($data)) {
                $this->session->set_flashdata('success', 'Data dosen berhasil ditambahkan');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data dosen');
            }
            redirect('dosen');
        }
    }

    public function update($id) {
        $this->form_validation->set_rules('kode_dosen', 'Kode Dosen', 'required|callback_check_kode_unique['.$id.']');
        $this->form_validation->set_rules('nama_dosen', 'Nama Dosen', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            $this->edit($id);
        } else {
            $data = [
                'kode_dosen' => $this->input->post('kode_dosen'),
                'nama_dosen' => $this->input->post('nama_dosen'),
                'status_aktif' => $this->input->post('status_aktif') ? 1 : 0
            ];
            
            if ($this->Dosen_model->update($id, $data)) {
                $this->session->set_flashdata('success', 'Data dosen berhasil diperbarui');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data dosen');
            }
            redirect('dosen');
        }
    }

    public function delete($id) {
        if(empty($id)) {
            $this->session->set_flashdata('error', 'ID dosen tidak valid');
            redirect('dosen');
        }
        
        $dosen = $this->Dosen_model->get_by_id($id);
        if(!$dosen) {
            $this->session->set_flashdata('error', 'Data dosen tidak ditemukan');
            redirect('dosen');
        }
        
        $has_jadwal = $this->db->where('id_dosen', $id)
                            ->count_all_results('jadwal_kuliah') > 0;
        
        if($has_jadwal) {
            $this->session->set_flashdata('confirm', [
                'message' => 'Dosen ini memiliki jadwal mengajar. Yakin ingin menghapus?',
                'id' => $id
            ]);
            redirect('dosen');
        } else {
            if ($this->Dosen_model->delete($id)) {
                $this->session->set_flashdata('success', 'Data dosen berhasil dihapus');
            } else {
                $this->session->set_flashdata('error', 'Gagal menghapus data dosen');
            }
            redirect('dosen');
        }
    }
    
    public function delete_confirm($id) {
        if ($this->Dosen_model->delete($id)) {
            $this->session->set_flashdata('success', 'Data dosen dan jadwal terkait berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data dosen');
        }
        redirect('dosen');
    }

    public function check_kode_unique($kode, $id = null) {
        if ($this->Dosen_model->is_unique_kode($kode, $id)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_kode_unique', 'Kode dosen sudah digunakan');
            return FALSE;
        }
    }

    public function delete_ajax($id) {
        if(empty($id)) {
            echo json_encode(['success' => false, 'message' => 'ID dosen tidak valid']);
            return;
        }
        
        $dosen = $this->Dosen_model->get_by_id($id);
        if(!$dosen) {
            echo json_encode(['success' => false, 'message' => 'Data dosen tidak ditemukan']);
            return;
        }
        
        $has_jadwal = $this->db->where('id_dosen', $id)
                            ->count_all_results('jadwal_kuliah') > 0;
        
        if($has_jadwal) {
            echo json_encode([
                'success' => false, 
                'has_jadwal' => true,
                'message' => 'Dosen <strong>' . htmlspecialchars($dosen->nama_dosen) . '</strong> memiliki jadwal mengajar. Menghapus dosen ini juga akan menghapus semua jadwal terkait. Apakah Anda yakin?'
            ]);
        } else {
            if ($this->Dosen_model->delete($id)) {
                echo json_encode(['success' => true, 'message' => 'Data dosen berhasil dihapus']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal menghapus data dosen']);
            }
        }
    }

    public function delete_confirm_ajax($id) {
        if(empty($id)) {
            echo json_encode(['success' => false, 'message' => 'ID dosen tidak valid']);
            return;
        }
        
        $dosen = $this->Dosen_model->get_by_id($id);
        if(!$dosen) {
            echo json_encode(['success' => false, 'message' => 'Data dosen tidak ditemukan']);
            return;
        }
        
        if ($this->Dosen_model->delete($id)) {
            echo json_encode(['success' => true, 'message' => 'Data dosen dan semua jadwal terkait berhasil dihapus']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus data dosen']);
        }
    }
}