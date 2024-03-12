<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Slider;
use App\Models\Team;
use App\Models\Testimonial;
use App\Models\Umkm;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        $sliders = Slider::get();
        $testimonials = Testimonial::get();
        $agents = Agent::get();
        $umkms = Umkm::get();

    return view('frontend.homepage', compact('sliders', 'testimonials', 'agents', 'umkms'));
    }
}
