<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matakuliah extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Matakuliah_model');
    }

    public function index() {
        $data['title'] = 'Data Mata Kuliah';
        $data['list'] = $this->Matakuliah_model->get_all();
        $this->load->view('template/header', $data);
        $this->load->view('matakuliah/index', $data);
        $this->load->view('template/footer');
    }

    public function tambah() {
        $data['title'] = 'Tambah Mata Kuliah';
        $this->load->view('template/header', $data);
        $this->load->view('matakuliah/form');
        $this->load->view('template/footer');
    }

    public function create() {
        $data = array(
            'kode_matkul' => $this->input->post('kode_matkul'),
            'nama_matkul' => $this->input->post('nama_matkul'),
            'sks' => $this->input->post('sks')
        );

        $this->Matakuliah_model->insert($data);
        $this->session->set_flashdata('success', 'Data berhasil ditambahkan!');
        redirect('matakuliah');
    }

    public function edit($id) {
        $data['title'] = 'Edit Mata Kuliah';
        $data['matakuliah'] = $this->Matakuliah_model->get_by_id($id);
        
        if(!$data['matakuliah']) {
            $this->session->set_flashdata('error', 'Data mata kuliah tidak ditemukan');
            redirect('matakuliah');
        }
        
        $this->load->view('template/header', $data);
        $this->load->view('matakuliah/edit', $data);
        $this->load->view('template/footer');
    }

    public function update($id) {
        $data = array(
            'kode_matkul' => $this->input->post('kode_matkul'),
            'nama_matkul' => $this->input->post('nama_matkul'),
            'sks' => $this->input->post('sks')
        );

        $this->Matakuliah_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data berhasil diupdate!');
        redirect('matakuliah');
    }

    // Metode lama, simpan untuk backward compatibility
    public function delete($id) {
        // Redirect ke delete_ajax untuk memastikan penanganan yang konsisten
        redirect('matakuliah/delete_ajax/'.$id);
    }
    
    // Metode baru dengan AJAX
    public function delete_ajax($id) {
        if(empty($id)) {
            echo json_encode(['success' => false, 'message' => 'ID mata kuliah tidak valid']);
            return;
        }
        
        $matkul = $this->Matakuliah_model->get_by_id($id);
        if(!$matkul) {
            echo json_encode(['success' => false, 'message' => 'Data mata kuliah tidak ditemukan']);
            return;
        }
        
        $has_jadwal = $this->db->where('id_matkul', $id)
                            ->count_all_results('jadwal_kuliah') > 0;
        
        if($has_jadwal) {
            echo json_encode([
                'success' => false, 
                'has_jadwal' => true,
                'message' => 'Mata kuliah <strong>' . htmlspecialchars($matkul->nama_matkul) . '</strong> digunakan dalam jadwal perkuliahan. Menghapus mata kuliah ini juga akan menghapus semua jadwal terkait. Apakah Anda yakin?'
            ]);
        } else {
            try {
                if ($this->Matakuliah_model->delete($id)) {
                    echo json_encode(['success' => true, 'message' => 'Mata kuliah berhasil dihapus']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Gagal menghapus mata kuliah']);
                }
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }
    }

    public function delete_confirm_ajax($id) {
        if(empty($id)) {
            echo json_encode(['success' => false, 'message' => 'ID mata kuliah tidak valid']);
            return;
        }
        
        $matkul = $this->Matakuliah_model->get_by_id($id);
        if(!$matkul) {
            echo json_encode(['success' => false, 'message' => 'Data mata kuliah tidak ditemukan']);
            return;
        }
        
        try {
            if ($this->Matakuliah_model->delete_with_relations($id)) {
                echo json_encode(['success' => true, 'message' => 'Mata kuliah dan semua jadwal terkait berhasil dihapus']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal menghapus mata kuliah dan jadwal terkait']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}