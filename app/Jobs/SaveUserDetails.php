<?php

namespace App\Jobs;

use App\Models\CreditCard;
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
use mysql_xdevapi\Exception;

class SaveUserDetails implements ShouldQueue
{
  use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $header;
  public $chunk;

  /**
   * Create a new job instance.
   *
   * @param $chunk
   * @param $header
   */
  public function __construct($chunk, $header)
  {
    $this->chunk = $chunk;
    $this->header = $header;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    foreach ($this->chunk as $data) {
      $date = $this->sanitizeDate($data['date_of_birth']);
      $carbonDate = Carbon::parse($date);
      $age = $carbonDate->age;
      if (is_null($date) || ($age >= 18 && $age <= 65)) {
        $this->createUser($data, $this->header, $date);
      }
    }
  }

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

  /**
   * @param $data
   * @param $header
   * @param $date
   */
  private function createUser($data, $header, $date)
  {
    DB::transaction(function () use ($data, $date) {
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
    });
  }

  private function saveData() {

  }
}
