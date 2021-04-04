<?php

namespace App\Jobs;

use App\Models\CreditCard;
use App\Models\HashFile;
use App\Models\Traits\SanitizeDate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class SaveUserDetails implements ShouldQueue
{
  use SanitizeDate, Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  private $header;
  private $chunk;
  private $hashId;

  private $index = 0;

  private $tries = 2;

  /**
   * Create a new job instance.
   *
   * @param $chunk
   * @param $header
   * @param $hashId
   */
  public function __construct($chunk, $header, $hashId)
  {
    $this->chunk = $chunk;
    $this->header = $header;
    $this->hashId = $hashId;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    foreach ($this->chunk as $data) {
      $this->index++;
      $date = $this->sanitizeDate($data['date_of_birth']);
      $carbonDate = Carbon::parse($date);
      $age = $carbonDate->age;
      if (is_null($date) || ($age >= 18 && $age <= 65)) {
        $this->createUser($data, $date, $this->hashId);
      }
    }
  }

  /**
   * @param $data
   * @param $date
   * @param $hashedId
   */
  private function createUser($data, $date, $hashedId)
  {
    DB::transaction(function () use ($data, $date, $hashedId) {
      $user = new User();
      $user->name = $data['name'];
      $user->address = $data['address'];
      $user->checked = $data['checked'];
      $user->email = $data['email'];
      $user->interest = $data['interest'];
      $user->description = $data['description'];
      $user->account = $data['account'];
      $user->date_of_birth = $date;
      $user->save();

      $creditCard = new CreditCard();
      $creditCard->user_id = $user->id;
      $creditCard->name = $data['credit_card']['name'];
      $creditCard->type = $data['credit_card']['type'];
      $creditCard->number = $data['credit_card']['number'];
      $creditCard->expiration_date = $data['credit_card']['expirationDate'];
      $creditCard->save();

      HashFile::where('file_hash_id', $hashedId)->update([
        'index' => $this->index,
      ]);
    });
  }

}
