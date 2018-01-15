<?php

class Validasi {

  public static function angka($masukan) {
    if (is_numeric($masukan)) {
      return $masukan
    } else {
      throw new Exception('Hanya angka yang diperbolehkan');
    }
  }

  public static function huruf($masukan) {
    if (is_string($masukan)) {
      return $masukan;
    } else {
      throw new Exception('Hanya huruf yang diperbolehkan');
    }
  }

}
