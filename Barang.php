<?php

Class Barang {
  private $file = 'Barang.json';
  public $daftar_barang;

  public function __construct() {
    $this->ambilData();
  }

  private function kosongkanData() {
    // $this->
  }

  private function ambilData() {
    $data = file_get_contents($this->file);
    $this->daftar_barang = json_decode($data, true);
  }

  public function sortir(&$array, $kolom, $arah = SORT_ASC) {
    $sortir_kolom = [];
    foreach ($array as $key => $baris) {
      $sortir_kolom[$key] = $baris[$kolom];
    }
    array_multisort($sortir_kolom, $arah, $array);
  }
}
