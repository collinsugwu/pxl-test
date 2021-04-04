<?php


namespace App\Models\Traits;


use mysql_xdevapi\Exception;

trait SanitizeDate
{
  /**
   * @param $date
   * @return string|null
   */
  private function sanitizeDate($date)
  {
    if (is_null($date)) return null;

    try {
      $pattern = "/\d+/i";
      preg_match_all($pattern, $date, $matches);
      $getFirstThreeValues = array_slice($matches[0], 0, 3);
      if (strlen($getFirstThreeValues[2]) > 2) {
        $getFirstThreeValues = array_reverse($getFirstThreeValues);
      }
      return implode('-', $getFirstThreeValues);
    } catch (Exception $e) {
      return null;
    }
  }
}
