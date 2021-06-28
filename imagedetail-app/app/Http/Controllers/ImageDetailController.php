<?php

namespace App\Http\Controllers;

use App\Models\ImageDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ImageDetailController extends Controller
{
    public function detailImage(Request $request, $image_id)
    {
        $image_detail = \App\Models\ImageDetail::where('id', '=', $image_id)->get();
        return response()->json($image_detail);
    }
}
