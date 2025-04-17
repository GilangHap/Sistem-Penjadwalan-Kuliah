<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruangan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Ruangan_model');
    }

    public function index() {
        $data['title'] = 'Data Ruangan';
        $data['list'] = $this->Ruangan_model->get_all();
        $this->load->view('template/header', $data);
        $this->load->view('ruangan/index', $data);
        $this->load->view('template/footer');
    }

    public function tambah() {
        $data['title'] = 'Tambah Ruangan';
        $this->load->view('template/header', $data);
        $this->load->view('ruangan/form');
        $this->load->view('template/footer');
    }

    public function create() {
        $data = array(
            'kode_ruang' => $this->input->post('kode_ruang'),
            'kapasitas' => $this->input->post('kapasitas'),
            'status_aktif' => $this->input->post('status_aktif'),
            'jenis_ruang' => $this->input->post('jenis_ruang'),
            'lokasi' => $this->input->post('lokasi'),
            'keterangan' => $this->input->post('keterangan')
        );

        $this->Ruangan_model->insert($data);
        $this->session->set_flashdata('pesan', 'Data ruangan berhasil ditambahkan!');
        redirect('ruangan');
    }

    public function edit($id) {
        $data['title'] = 'Edit Ruangan';
        $data['ruangan'] = $this->Ruangan_model->get_by_id($id);
        
        if(!$data['ruangan']) {
            $this->session->set_flashdata('error', 'Data ruangan tidak ditemukan');
            redirect('ruangan');
        }
        
        $this->load->view('template/header', $data);
        $this->load->view('ruangan/edit', $data);
        $this->load->view('template/footer');
    }

    public function update($id) {
        $data = array(
            'kode_ruang' => $this->input->post('kode_ruang'),
            'kapasitas' => $this->input->post('kapasitas'),
            'status_aktif' => $this->input->post('status_aktif'),
            'jenis_ruang' => $this->input->post('jenis_ruang'),
            'lokasi' => $this->input->post('lokasi'),
            'keterangan' => $this->input->post('keterangan')
        );

        $this->Ruangan_model->update($id, $data);
        $this->session->set_flashdata('pesan', 'Data ruangan berhasil diupdate!');
        redirect('ruangan');
    }

    // Metode lama, simpan untuk backward compatibility
    public function delete($id) {
        // Redirect ke delete_ajax untuk handling yang lebih baik
        $this->delete_ajax($id);
    }
    
    // Metode baru dengan AJAX
    public function delete_ajax($id) {
        if(empty($id)) {
            if($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'ID ruangan tidak valid']);
                return;
            } else {
                $this->session->set_flashdata('error', 'ID ruangan tidak valid');
                redirect('ruangan');
            }
        }
        
        $ruangan = $this->Ruangan_model->get_by_id($id);
        if(!$ruangan) {
            if($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Data ruangan tidak ditemukan']);
                return;
            } else {
                $this->session->set_flashdata('error', 'Data ruangan tidak ditemukan');
                redirect('ruangan');
            }
        }
        
        $has_jadwal = $this->db->where('id_ruang', $id)
                            ->count_all_results('jadwal_kuliah') > 0;
        
        if($has_jadwal) {
            if($this->input->is_ajax_request()) {
                echo json_encode([
                    'success' => false, 
                    'has_jadwal' => true,
                    'message' => 'Ruangan <strong>' . htmlspecialchars($ruangan->kode_ruang) . '</strong> digunakan dalam jadwal perkuliahan. Menghapus ruangan ini juga akan menghapus semua jadwal terkait. Apakah Anda yakin?',
                    'ruangan_id' => $id
                ]);
                return;
            } else {
                $this->session->set_flashdata('confirm', [
                    'message' => 'Ruangan ini memiliki jadwal terkait. Yakin ingin menghapus?',
                    'id' => $id
                ]);
                redirect('ruangan');
            }
        } else {
            try {
                $result = $this->Ruangan_model->delete($id);
                
                if($result) {
                    if($this->input->is_ajax_request()) {
                        echo json_encode(['success' => true, 'message' => 'Ruangan berhasil dihapus']);
                    } else {
                        $this->session->set_flashdata('pesan', 'Data ruangan berhasil dihapus!');
                        redirect('ruangan');
                    }
                } else {
                    if($this->input->is_ajax_request()) {
                        echo json_encode(['success' => false, 'message' => 'Gagal menghapus ruangan']);
                    } else {
                        $this->session->set_flashdata('error', 'Gagal menghapus data ruangan');
                        redirect('ruangan');
                    }
                }
            } catch (Exception $e) {
                if($this->input->is_ajax_request()) {
                    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
                } else {
                    $this->session->set_flashdata('error', 'Error: ' . $e->getMessage());
                    redirect('ruangan');
                }
            }
        }
    }

    public function delete_confirm_ajax($id) {
        if(empty($id)) {
            echo json_encode(['success' => false, 'message' => 'ID ruangan tidak valid']);
            return;
        }
        
        $ruangan = $this->Ruangan_model->get_by_id($id);
        if(!$ruangan) {
            echo json_encode(['success' => false, 'message' => 'Data ruangan tidak ditemukan']);
            return;
        }
        
        try {
            if ($this->Ruangan_model->delete_with_relations($id)) {
                echo json_encode(['success' => true, 'message' => 'Ruangan dan semua jadwal terkait berhasil dihapus']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal menghapus ruangan dan jadwal terkait']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}