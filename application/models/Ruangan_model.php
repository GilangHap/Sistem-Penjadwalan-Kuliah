<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruangan_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        $this->db->order_by('kode_ruang', 'ASC');
        return $this->db->get('ruangan')->result();
    }

    public function get_all_active() {
        $this->db->where('status_aktif', 1);
        $this->db->order_by('kode_ruang', 'ASC');
        return $this->db->get('ruangan')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('ruangan', ['id_ruang' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('ruangan', $data);
    }

    public function update($id, $data) {
        $this->db->where('id_ruang', $id);
        return $this->db->update('ruangan', $data);
    }

    public function delete($id) {
        $this->db->where('id_ruang', $id);
        return $this->db->delete('ruangan');
    }
    
    public function delete_with_relations($id) {
        $this->db->trans_start();
        
        // Hapus jadwal terkait terlebih dahulu
        $this->db->where('id_ruang', $id);
        $this->db->delete('jadwal_kuliah');
        
        // Kemudian hapus ruangan
        $this->db->where('id_ruang', $id);
        $this->db->delete('ruangan');
        
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    public function count_all() {
        return $this->db->count_all('ruangan');
    }
    
    public function count_active() {
        return $this->db->where('status_aktif', 1)->count_all_results('ruangan');
    }
    
    public function is_used_in_schedule($id) {
        return $this->db->where('id_ruang', $id)->count_all_results('jadwal_kuliah') > 0;
    }
}