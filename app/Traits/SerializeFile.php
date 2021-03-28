<?php


namespace App\Traits;


use Illuminate\Http\Request;

trait SerializeFile
{
  public function hashFile() {

  }

  public function fetchHash() {

  }

  public function matchHash($firstHash, $secondHash) {

  }
  /**
   * @param Request $request
   * @return array
   */
  public function convertFileToArray(Request $request)
  {
    $file = $request->file;
    $ext =  $file->getClientOriginalExtension();

    switch ($ext) {
      case "txt":
        $data = $this->convertTxtFileToArray($file);
        break;
      case "csv":
        $data = $this->convertCsvFileToArray($file);
        break;
      case "json":
        $data = $this->convertJsonFileToArray($file);
        break;
    }
    return $data;
  }

  /**
   * @param $file
   * @return array
   */
  private function convertTxtFileToArray($file) {
    $file_array = array_map('str_getcsv', file($file));
    $header = $file_array[0];
    return [$file_array, $header];
  }

  /**
   * @param $file
   * @return array
   */
  private function convertCsvFileToArray($file) {
    $file_array = array_map('str_getcsv', file($file));
    $header = $file_array[0];
    return [$file_array, $header];
  }

  /**
   * @param $file
   * @return array
   */
  private function convertJsonFileToArray($file) {
    $file_string = file_get_contents($file);
    $file_array = json_decode($file_string, true);
    $header = array_keys($file_array[0]);
    return [$file_string, $header];
  }
}
