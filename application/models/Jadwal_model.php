<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal_model extends CI_Model {

    public function get_all() {
        return $this->db->select('jadwal_kuliah.*, mata_kuliah.nama_matkul, dosen.nama_dosen, ruangan.kode_ruang, waktu_sks.jam_mulai, waktu_sks.jam_selesai')
            ->from('jadwal_kuliah')
            ->join('mata_kuliah', 'mata_kuliah.id_matkul = jadwal_kuliah.id_matkul')
            ->join('dosen', 'dosen.id_dosen = jadwal_kuliah.id_dosen')
            ->join('ruangan', 'ruangan.id_ruang = jadwal_kuliah.id_ruang')
            ->join('waktu_sks', 'waktu_sks.urutan_sks = jadwal_kuliah.sks_ke')
            ->order_by('jadwal_kuliah.hari, jadwal_kuliah.sks_ke')
            ->get()
            ->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('jadwal_kuliah', ['id_jadwal' => $id])->row();
    }

    public function insert($data) {
        $this->db->trans_start();
        $this->db->insert('jadwal_kuliah', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return false;
        }
        
        return $insert_id;
    }

    public function update($id, $data) {
        return $this->db->where('id_jadwal', $id)->update('jadwal_kuliah', $data);
    }

    public function delete($id) {
        // Mulai transaction untuk memastikan konsistensi data
        $this->db->trans_start();
        $this->db->where('id_jadwal', $id)
                ->or_where('id_bentrok', $id)
                ->delete('log_validasi_jadwal');
        $this->db->where('id_jadwal', $id)
                 ->delete('jadwal_kuliah');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function get_validations($id_jadwal) {
        return $this->db->select('log_validasi_jadwal.*, jadwal_kuliah.*, mata_kuliah.nama_matkul, dosen.nama_dosen, ruangan.kode_ruang')
            ->from('log_validasi_jadwal')
            ->join('jadwal_kuliah', 'jadwal_kuliah.id_jadwal = log_validasi_jadwal.id_jadwal')
            ->join('mata_kuliah', 'mata_kuliah.id_matkul = jadwal_kuliah.id_matkul')
            ->join('dosen', 'dosen.id_dosen = jadwal_kuliah.id_dosen')
            ->join('ruangan', 'ruangan.id_ruang = jadwal_kuliah.id_ruang')
            ->where('log_validasi_jadwal.id_jadwal', $id_jadwal)
            ->get()
            ->result();
    }

    public function get_recent_validations($limit = 10) {
        return $this->db->select('log_validasi_jadwal.*, jadwal_kuliah.kelas, mata_kuliah.nama_matkul')
            ->from('log_validasi_jadwal')
            ->join('jadwal_kuliah', 'jadwal_kuliah.id_jadwal = log_validasi_jadwal.id_jadwal')
            ->join('mata_kuliah', 'mata_kuliah.id_matkul = jadwal_kuliah.id_matkul')
            ->order_by('log_validasi_jadwal.waktu_validasi', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    public function validate_jadwal($id_jadwal) {
        $this->db->query("CALL validasi_jadwal_sks(?)", array($id_jadwal));
        return $this->get_validations($id_jadwal);
    }

    public function get_sks_options() {
        return $this->db->get('waktu_sks')->result();
    }

    public function get_available_sks($hari, $sks_mulai, $jumlah_sks, $id_jadwal = null) {
        $query = "
            SELECT * FROM waktu_sks ws
            WHERE NOT EXISTS (
                SELECT 1 FROM jadwal_kuliah jk
                WHERE jk.hari = ? 
                AND jk.id_jadwal != COALESCE(?, 0)
                AND (
                    (? BETWEEN jk.sks_ke AND jk.sks_ke + jk.jumlah_sks - 1) OR
                    (? + ? - 1 BETWEEN jk.sks_ke AND jk.sks_ke + jk.jumlah_sks - 1) OR
                    (jk.sks_ke BETWEEN ? AND ? + ? - 1)
                )
            )
            AND ws.urutan_sks BETWEEN ? AND ? + ? - 1
        ";
        
        return $this->db->query($query, array(
            $hari, $id_jadwal, $sks_mulai, $sks_mulai, $jumlah_sks, 
            $sks_mulai, $sks_mulai, $jumlah_sks,
            $sks_mulai, $sks_mulai, $jumlah_sks
        ))->result();
    }

    public function get_full_schedule() {
        $this->db->select('jadwal_kuliah.*, dosen.nama_dosen, mata_kuliah.nama_matkul, ruangan.kode_ruang');
        $this->db->from('jadwal_kuliah');
        $this->db->join('dosen', 'dosen.id_dosen = jadwal_kuliah.id_dosen');
        $this->db->join('mata_kuliah', 'mata_kuliah.id_matkul = jadwal_kuliah.id_matkul');
        $this->db->join('ruangan', 'ruangan.id_ruang = jadwal_kuliah.id_ruang');
        return $this->db->get()->result();
    }

    public function count_all() {
        return $this->db->count_all('jadwal_kuliah');
    }

    public function count_by_day($day) {
        return $this->db->where('hari', $day)->count_all_results('jadwal_kuliah');
    }
    
    public function check_availability_edit($id_dosen, $id_ruang, $hari, $sks_ke, $jumlah_sks, $current_id) {
        // Hitung sks_selesai
        $sks_selesai = $sks_ke + $jumlah_sks - 1;
        
        // Cek bentrok dengan jadwal lain untuk dosen yang sama
        $query_dosen = $this->db->query("
            SELECT * FROM jadwal_kuliah 
            WHERE id_jadwal != ? AND id_dosen = ? AND hari = ? AND 
            ((sks_ke BETWEEN ? AND ?) OR 
             (sks_ke + jumlah_sks - 1 BETWEEN ? AND ?) OR 
             (? BETWEEN sks_ke AND sks_ke + jumlah_sks - 1))
        ", array($current_id, $id_dosen, $hari, $sks_ke, $sks_selesai, $sks_ke, $sks_selesai, $sks_ke));
        
        if ($query_dosen->num_rows() > 0) {
            return false;
        }
        
        // Cek bentrok dengan jadwal lain untuk ruangan yang sama
        $query_ruang = $this->db->query("
            SELECT * FROM jadwal_kuliah 
            WHERE id_jadwal != ? AND id_ruang = ? AND hari = ? AND 
            ((sks_ke BETWEEN ? AND ?) OR 
             (sks_ke + jumlah_sks - 1 BETWEEN ? AND ?) OR 
             (? BETWEEN sks_ke AND sks_ke + jumlah_sks - 1))
        ", array($current_id, $id_ruang, $hari, $sks_ke, $sks_selesai, $sks_ke, $sks_selesai, $sks_ke));
        
        if ($query_ruang->num_rows() > 0) {
            return false;
        }
        
        return true;
    }
    
    // Tambahkan metode untuk validasi
    public function check_availability($id_dosen, $id_ruang, $hari, $sks_ke, $jumlah_sks) {
        // Hitung sks_selesai
        $sks_selesai = $sks_ke + $jumlah_sks - 1;
        
        // Cek bentrok dengan jadwal lain untuk dosen yang sama
        $query_dosen = $this->db->query("
            SELECT * FROM jadwal_kuliah 
            WHERE id_dosen = ? AND hari = ? AND 
            ((sks_ke BETWEEN ? AND ?) OR 
             (sks_ke + jumlah_sks - 1 BETWEEN ? AND ?) OR 
             (? BETWEEN sks_ke AND sks_ke + jumlah_sks - 1))
        ", array($id_dosen, $hari, $sks_ke, $sks_selesai, $sks_ke, $sks_selesai, $sks_ke));
        
        if ($query_dosen->num_rows() > 0) {
            return false;
        }
        
        // Cek bentrok dengan jadwal lain untuk ruangan yang sama
        $query_ruang = $this->db->query("
            SELECT * FROM jadwal_kuliah 
            WHERE id_ruang = ? AND hari = ? AND 
            ((sks_ke BETWEEN ? AND ?) OR 
             (sks_ke + jumlah_sks - 1 BETWEEN ? AND ?) OR 
             (? BETWEEN sks_ke AND sks_ke + jumlah_sks - 1))
        ", array($id_ruang, $hari, $sks_ke, $sks_selesai, $sks_ke, $sks_selesai, $sks_ke));
        
        if ($query_ruang->num_rows() > 0) {
            return false;
        }
        
        return true;
    }
}