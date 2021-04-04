<?php

namespace Tests\Feature;


use App\Jobs\SaveUserDetails;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Testing\Fakes\BusFake;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
  /**
   * A basic feature test example.
   *
   * @return void
   */
  public function test_index()
  {
    $response = $this->get('/upload');

    $response->assertStatus(200);
  }

  public function test_file_validation_with_no_data()
  {
    $response = $this->json('POST', 'upload',[]);
    $response->assertStatus(422);
  }

  public function test_file_validation_with_wrong_no_data()
  {
    $data = [
      'file' => UploadedFile::fake()->image('logo.png')
    ];
    $response = $this->json('POST', 'upload',$data);
    $response->assertStatus(422);
  }

  public function testCreateSuccessfully()
  {
    Bus::fake();
    $file = resource_path('test/test.json');
    $data = ['file' => $file];
    $response = $this->json('POST','upload', $data);
    Bus::assertDispatched(SaveUserDetails::class);
    $response->assertOk();
  }
}
