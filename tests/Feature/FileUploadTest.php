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
  public function testIndex()
  {
    $response = $this->get('/upload');

    $response->assertStatus(200);
  }

  public function testFileValidation()
  {
    $response = $this->post('upload');
    $response->assertStatus(422);
  }

  public function testCreateSuccessfully()
  {
    Bus::fake();
    $file = resource_path('test/test.csv');
    $data = ['file' => $file];
    $response = $this->post('/upload', $data);
    Bus::assertDispatched(SaveUserDetails::class);
    $response->assertOk();
  }
}
