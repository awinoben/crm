<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use World\Countries\Model\Country;

class CacheController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * cache all the countries
     * @return mixed
     */
    public static function cacheCountries()
    {
        return Cache::remember('countries', now()->addMinutes(1), function () {
            return Country::all()->sortBy('name');
        });
    }
}
