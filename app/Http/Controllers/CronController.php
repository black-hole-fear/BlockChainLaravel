<?php

namespace App\Http\Controllers;

use App\Models\CoinRate;
use App\Models\User;

class CronController extends Controller {

    public function cron() {
        $general            = gs();
        $general->last_cron = now();

        $initialPrice        = $general->coin_init_price;
        $increasePerThousand = $general->per_thousand_rate;
        $randPercent         = rand($general->start_value * 10, $general->end_value * 10) / 10;
        $randType            = rand(0, 1);
        $currentCirculation  = User::sum('coin');

        $currentCoinPrice = $initialPrice + ($increasePerThousand * $currentCirculation / 1000);
        $randomPrice      = ($currentCoinPrice * $randPercent) / 100;

        if ($randType == 0) {
            $currentCoinPrice -= $randomPrice;
        } else {
            $currentCoinPrice += $randomPrice;
        }
        $general->coin_rate = $currentCoinPrice;

        $general->save();
        $rate        = new CoinRate();
        $rate->price = $currentCoinPrice;
        $rate->save();
        return $currentCoinPrice;
    }

}
