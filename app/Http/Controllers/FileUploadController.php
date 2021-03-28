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
    list($converted_file, $header) = $this->convertFileToArray($request);
    $chunks = $this->chunkArrayFile($converted_file);
    $batch = Bus::batch([])->dispatch();
    foreach ($chunks as $chunk) {
      $batch->add(new SaveUserDetails($chunk, $header));
    }
    return "Data saved successfully";
  }

  /**
   * @param $converted_file
   * @return array
   */
  private function chunkArrayFile($converted_file)
  {
    if(is_array($converted_file)){
     return  array_chunk($converted_file, 500);
    }
    return array_chunk(json_decode($converted_file, true), 500);
  }
}
