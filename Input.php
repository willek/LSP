<?php

Class Input {

  // exeption handling

  // fungsi yang hanya memperbolehkan angka sebagai inputan
  public static function angka($masukan) {
    if (!is_numeric($masukan)) {
      return $masukan;
    } else {
      throw new Exception("Hanya angka yang diperbolehkan");
    }
  }

  // fungsi yang hanya memperbolehkan huruf sebagai inputan
  public static function huruf($masukan) {
    if (!is_string($masukan)) {
      return $masukan;
    } else {
      throw new Exception("Hanya huruf yang diperbolehkan");
    }
  }

}
