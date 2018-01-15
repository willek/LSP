<?php

class Item {

    private $file = 'Barang.json';

    public $list;

    /**
     * Konstruktor
     */
    public function __construct()
    {
        $this->get();
    }

    /**
     * Menghapus semua item
     * @return void
     */
    private function clear()
    {
        $this->list = [];
        $this->edit();
    }

    /**
     * Mengambil array di file .json dan menyimpannya di array variabel $list
     */
    private function get(){
        $jsondata = file_get_contents($this->filename);
        $this->list = json_decode($jsondata, true);
    }

    /**
     * Mengirim inputan array ke file .json
     * @param $array
     */
    private function push($array){
        array_push($this->list,$array);
        $jsondata = json_encode($this->list, JSON_PRETTY_PRINT);
        file_put_contents($this->filename, $jsondata);
        $this->get();
    }

    /**
     * Mengirim array variabel $list ke file .json
     */
    public function edit()
    {
        $jsondata = json_encode($this->list, JSON_PRETTY_PRINT);
        file_put_contents($this->filename, $jsondata);
    }

    /**
     * Menambah item baru
     * @param $kode
     * @param $name
     * @param $qty
     * @param $price
     */
    public function add($kode, $name, $qty, $price){
        if(in_array($kode, array_column($this->list, 'kode'))) {
//            echo "Kode produk sudah ada! Data tidak disimpan.. \n";

	    // Menambah stok produk kalau kodenya sama
            $key = array_search($kode, array_column($this->list, 'kode'));
            $this->list[$key]['jumlah'] += $qty;
            $this->edit();
        } else{
            /**
             * ======================================= Exception Handling
             */
            try{
                $newItems = [
                    'kode'      => $kode,
                    'nama'      => $name,
                    'jumlah'    => $qty,
                    'harga'     => $price
                ];
                $this->push($newItems);
            } catch (Exception $e){
                die($e->getMessage());
            }
        }
    }

    public function search($kode)
    {
        return in_array($kode, array_column($this->list, 'kode'));
    }

    /**
     * Menghapus array berdasarkan kode
     * @param $kode
     */
    public function remove($kode){
        foreach ($this->list as $key => $item) {
            if ($item['kode'] == $kode) {
                unset($item[$key]);
            }
        }
    }

    /**
     * ========================================= Pointer
     * Mengurutkan array berdasarkan masukan
     * @param array $arr isi array
     * @param string $col kolom yang akan diurutkan
     * @param int $dir tipe sorting
     */
    public function sort(&$arr, $col, $dir = SORT_ASC) {
        $sort_col = array();
        foreach ($arr as $key=> $row) {
            $sort_col[$key] = $row[$col];
        }
        array_multisort($sort_col, $dir, $arr);
    }
}
