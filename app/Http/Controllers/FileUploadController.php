<?php

namespace App\Http\Controllers;

use App\Jobs\SaveUserDetails;
use App\Models\HashFile;
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
        return "File has been uploaded before";
    } else {
      list($converted_file, $header) = $this->convertFileToArray($request);
      $this->processJob($converted_file, $header, $fileHash, $fileHash);
      HashFile::saveHash($fileHash);
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

  /**
   * @param $fileHash
   * @return bool
   */
  private function checkFileExists($fileHash)
  {
    $file_obj = HashFile::fetchHash($fileHash);
    if (is_object($file_obj)) {
      return true;
    }

    return false;
  }

  /**
   * @param $converted_file
   * @param $header
   * @param $hashId
   * @throws \Throwable
   */
  private function processJob($converted_file, $header, $hashId)
  {
    $chunks = $this->chunkFileArray($converted_file);
    $batch = Bus::batch([])->dispatch();
    foreach ($chunks as $chunk) {
      $batch->add(new SaveUserDetails($chunk, $header, $hashId));
    }
  }

}
