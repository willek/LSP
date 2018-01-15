<?php

class __Masukan {

  public static function angka($masukan) {
    if (is_numeric($masukan)) {
      return $masukan
    } else {
      throw new Exception('Hanya angka yang diperbolehkan');
    }
  }


}
