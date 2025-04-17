<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen_model extends CI_Model {

    public function get_all() {
        return $this->db->get('dosen')->result();
    }
    public function get_all_active() {
        return $this->db->get_where('dosen', ['status_aktif' => '1'])->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('dosen', ['id_dosen' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('dosen', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id_dosen', $id)->update('dosen', $data);
    }

    public function delete($id_dosen) {
        $this->db->trans_start();
        $this->db->where('id_jadwal IN (SELECT id_jadwal FROM jadwal_kuliah WHERE id_dosen = '.$id_dosen.')', null, false)
                 ->or_where('id_bentrok IN (SELECT id_jadwal FROM jadwal_kuliah WHERE id_dosen = '.$id_dosen.')', null, false)
                 ->delete('log_validasi_jadwal');
        $this->db->where('id_dosen', $id_dosen)
                 ->delete('jadwal_kuliah');
        $this->db->where('id_dosen', $id_dosen)
                 ->delete('dosen');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function count_all() {
        return $this->db->count_all('dosen');
    }

    public function is_unique_kode($kode, $id = null) {
        if ($id) {
            $this->db->where('id_dosen !=', $id);
        }
        $result = $this->db->get_where('dosen', ['kode_dosen' => $kode]);
        return $result->num_rows() == 0;
    }
}