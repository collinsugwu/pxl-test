<?php

namespace App\Http\Controllers;

use App\Jobs\SaveUserDetails;
use App\Traits\SerializeFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;

class FileUploadController extends Controller
{
  use SerializeFile;

  public function index()
  {
    return view('file-upload.index');
  }

  /**
   * @param Request $request
   * @return mixed
   */
  public function create(Request $request)
  {
    $request->validate([
      'file' => 'required|file|mimes:json,csv,txt'
    ]);

    $fileHash = $this->hashFile($request->file);
    $fileExists = $this->checkFileExists($fileHash);
    if ($fileExists) {
        $this->processRemainingData($request, $fileHash);
    } else {
      $this->saveHash($fileHash);
      list($converted_file, $header) = $this->convertFileToArray($request);
      $this->processJob($converted_file, $header, $fileHash, $fileHash);
    }

    return "Data saved successfully";
  }

  /**
   * @param $converted_file
   * @return array
   */
  private function chunkFileArray($converted_file)
  {
    return array_chunk($converted_file, 500);
  }

  private function toArray($data) {
    if (is_array($data)) {
      return $data;
    }
    return json_decode($data, true);
  }

  private function checkFileExists($fileHash)
  {
    $file_obj = $this->fetchHash($fileHash);
    if (is_object($file_obj)) {
      return true;
    }

    return false;
  }

  private function processJob($converted_file, $header, $hashId)
  {
    $chunks = $this->chunkFileArray($converted_file);
    $batch = Bus::batch([])->dispatch();
    foreach ($chunks as $chunk) {
      $batch->add(new SaveUserDetails($chunk, $header, $hashId));
    }
  }

  /**
   * @param Request $request
   * @param $fileHash
   */
  private function processRemainingData(Request $request, $fileHash){
    $hashedFile = $this->fetchHash($fileHash);
    $index = $hashedFile->index;
    list($convertedFile, $header) = $this->convertFileToArray($request);
    $remainingData = array_slice($convertedFile, $index, count($convertedFile));
    $this->processJob($remainingData, $header, $fileHash);
  }
}
