<?php

namespace App\Http\Controllers\Api\v1\Dashboard;

use App\Http\Controllers\BaseApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Dashboard\ProfileRequset;
use Illuminate\Http\Request;

class ProfieController extends BaseApiController
{
    public function store(Request $request)
    {

    }

    public function update(Request $request)
    {
      //  $user = auth()->user();

    }


    public function show(Request $request)
    {


    }

    public function test(Request $request) {
        dd($request);
    }



}
