<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{

    public function index(): View
    {
        $testimonials = Testimonial::get();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create(): View
    {
        return view('admin.testimonials.create');
    }

    public function store(TestimonialRequest $request): RedirectResponse
    {
        if ($request->validated()) {
            $photo = $request->file('photo')->store('assets/testimonial', 'public');
            Testimonial::create($request->except('photo') + ['photo' => $photo]);
        }

        return redirect()->route('admin.testimonials.index')->with([
            'message' => 'successfully created !',
            'alert-type' => 'success'
        ]);
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial): RedirectResponse
    {
        if ($request->validated()) {
            if ($request->photo) {
                File::delete('storage/' . $testimonial->photo);
                $photo = $request->file('photo')->store('assets/testimonial', 'public');
                $testimonial->update($request->except('photo') + ['photo' => $photo]);
            } else {
                $testimonial->update($request->validated());
            }
        }


        return redirect()->route('admin.testimonials.index')->with([
            'message' => 'successfully updated !',
            'alert-type' => 'info'
        ]);
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        File::delete('storage/' . $testimonial->photo);
        $testimonial->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }
}
