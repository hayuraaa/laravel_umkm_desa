<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact');
    }

    public function store(ContactRequest $request)
    {
        if ($request->validated()) {
            Contact::create($request->validated());
        }

        return back()->with([
            'message' => 'successfully send !',
            'alert-type' => 'sucsess'
        ]);
    }
}
