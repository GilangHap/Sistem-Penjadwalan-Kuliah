<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matakuliah_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        return $this->db->get('mata_kuliah')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('mata_kuliah', ['id_matkul' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('mata_kuliah', $data);
    }

    public function update($id, $data) {
        $this->db->where('id_matkul', $id);
        return $this->db->update('mata_kuliah', $data);
    }

    public function delete($id) {
        $this->db->where('id_matkul', $id);
        return $this->db->delete('mata_kuliah');
    }
    
    public function delete_with_relations($id) {
        $this->db->trans_start();
        
        // Hapus jadwal terkait terlebih dahulu
        $this->db->where('id_matkul', $id);
        $this->db->delete('jadwal_kuliah');
        
        // Kemudian hapus mata kuliah
        $this->db->where('id_matkul', $id);
        $this->db->delete('mata_kuliah');
        
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    public function count_all() {
        return $this->db->count_all('mata_kuliah');
    }
}