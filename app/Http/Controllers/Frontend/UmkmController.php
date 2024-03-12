<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function index()
    {
        $umkms = Umkm::paginate(6);

        return view('frontend.umkm.index', compact('umkms'));
    }

    public function show(Umkm $umkm)
    {
        return view('frontend.umkm.single', compact('umkm'));
    }
}
