<?php

namespace App\Models;

use CodeIgniter\Model;

class LocationModel extends Model
{
    protected $table = 'wilayah';
    protected $primaryKey = 'kode';
    protected $allowedFields = ['kode', 'nama'];

    protected $tableKodepos = 'wilayah_kodepos';

    /**
     * Get all provinces
     */
    public function getProvinsi()
    {
        return $this->where('LENGTH(kode)', 2)
            ->orderBy('nama', 'ASC')
            ->findAll();
    }

    /**
     * Get cities by province code
     * @param string $provinceId - Kode provinsi (2 digit, contoh: 36)
     */
    public function getKota($provinceId)
    {
        return $this->where('kode LIKE', $provinceId . '.%')
            ->where('LENGTH(kode)', 5) // 36.74 (5 karakter)
            ->orderBy('nama', 'ASC')
            ->findAll();
    }

    /**
     * Get districts by city code
     * @param string $cityId - Kode kabupaten/kota (5 karakter, contoh: 36.74)
     */
    public function getKecamatan($cityId)
    {
        return $this->where('kode LIKE', $cityId . '.%')
            ->where('LENGTH(kode)', 8) // 36.74.07 (8 karakter)
            ->orderBy('nama', 'ASC')
            ->findAll();
    }

    /**
     * Get villages by district code
     * @param string $districtId - Kode kecamatan (8 karakter, contoh: 36.74.07)
     */
    public function getKelurahan($districtId)
    {
        return $this->where('kode LIKE', $districtId . '.%')
            ->where('LENGTH(kode)', 13) // 36.74.07.1004 (13 karakter)
            ->orderBy('nama', 'ASC')
            ->findAll();
    }

    /**
     * Get kodepos by village code
     * @param string $kodeKelurahan - Kode wilayah 13 karakter (contoh: 36.74.07.1004)
     * @return object|null
     */
    public function getKodeposByKelurahan($kodeKelurahan)
    {
        $builder = $this->db->table($this->tableKodepos);
        return $builder->where('kode', $kodeKelurahan)->get()->getRow();
    }

    /**
     * Search kodepos by term (kode pos or village name)
     * @param string $term - Search term
     * @return array
     */
    public function searchKodepos($term)
    {
        $builder = $this->db->table($this->tableKodepos . ' as kp');
        $builder->select('w.kode, CONCAT(kp.kodepos, " - ", w.nama) as text')
            ->join($this->table . ' as w', 'kp.kode = w.kode', 'inner')
            ->groupStart()
            ->like('kp.kodepos', $term)
            ->orLike('w.nama', $term)
            ->groupEnd()
            ->orderBy('kp.kodepos', 'ASC')
            ->limit(20);

        $query = $builder->get();
        $results = $query->getResultArray();

        // Format hasil untuk Select2
        $formattedResults = [];
        foreach ($results as $row) {
            $formattedResults[] = [
                'id' => $row['kode'],        // Kode wilayah 13 karakter
                'text' => $row['text']       // "15313 - Kademangan"
            ];
        }

        return $formattedResults;
    }

    /**
     * Get complete hierarchy by village code
     *
     * CATATAN PERBAIKAN:
     * Sebelumnya method ini memakai $this->where(...)->first() empat kali
     * berturut-turut pada instance Model yang sama. Query builder milik
     * Model (di-cache di $this->builder) tidak selalu ter-reset bersih
     * antar panggilan berantai seperti itu, sehingga hanya query PERTAMA
     * yang berhasil dan tiga query berikutnya (kecamatan/kabupaten/provinsi)
     * selalu mengembalikan null walau kode-nya valid.
     *
     * Perbaikan: setiap query memakai builder BARU/lepas via
     * $this->db->table($this->table), persis seperti pola yang sudah
     * terbukti bekerja di getKodeposByKelurahan(). Ini menghilangkan
     * kemungkinan state builder yang bocor antar query.
     *
     * @param string $kodeKelurahan - Kode wilayah 13 karakter
     * @return array
     */
    public function getHierarchy($kodeKelurahan)
    {
        // Kelurahan
        $kelurahan = $this->db->table($this->table)
            ->where('kode', $kodeKelurahan)
            ->get()
            ->getRow();

        if (!$kelurahan) {
            return [];
        }

        // Kecamatan (8 karakter)
        $kodeKecamatan = substr($kodeKelurahan, 0, 8);
        $kecamatan = $this->db->table($this->table)
            ->where('kode', $kodeKecamatan)
            ->get()
            ->getRow();

        // Kabupaten (5 karakter)
        $kodeKabupaten = substr($kodeKecamatan, 0, 5);
        $kabupaten = $this->db->table($this->table)
            ->where('kode', $kodeKabupaten)
            ->get()
            ->getRow();

        // Provinsi (2 karakter)
        $kodeProvinsi = substr($kodeKabupaten, 0, 2);
        $provinsi = $this->db->table($this->table)
            ->where('kode', $kodeProvinsi)
            ->get()
            ->getRow();

        // Kode pos
        $kodeposData = $this->getKodeposByKelurahan($kodeKelurahan);

        return [
            'provinsi' => [
                'kode' => $provinsi->kode ?? '',
                'nama' => $provinsi->nama ?? ''
            ],
            'kabupaten' => [
                'kode' => $kabupaten->kode ?? '',
                'nama' => $kabupaten->nama ?? ''
            ],
            'kecamatan' => [
                'kode' => $kecamatan->kode ?? '',
                'nama' => $kecamatan->nama ?? ''
            ],
            'kelurahan' => [
                'kode' => $kelurahan->kode ?? '',
                'nama' => $kelurahan->nama ?? ''
            ],
            'kodepos' => $kodeposData->kodepos ?? ''
        ];
    }
}
