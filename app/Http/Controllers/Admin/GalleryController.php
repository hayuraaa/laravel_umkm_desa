<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryRequest;
use App\Models\Gallery;
use App\Models\Umkm;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function store(GalleryRequest $request, Umkm $umkm): RedirectResponse
    {
        if ($request->validated()) {
            $photo = $request->file('photo')->store('assets/gallery', 'public');
            $umkm->galleries()->create($request->except('photo') + ['photo' => $photo]);
        }


        return redirect()->route('admin.umkms.edit', $umkm->id)->with([
            'message' => 'successfully created !',
            'alert-type' => 'success'
        ]);
    }


    public function edit(Umkm $umkm, Gallery $gallery): View
    {
        return view('admin.galleries.edit', compact('gallery', 'umkm'));
    }

    public function update(GalleryRequest $request, Umkm $umkm, Gallery $gallery): RedirectResponse
    {
        if ($request->validated()) {
            if ($request->photo) {
                File::delete('storage/' . $gallery->photo);
                $photo = $request->file('photo')->store('assets/gallery', 'public');
                $gallery->update($request->except('photo') + ['photo' => $photo]);
            } else {
                $gallery->update($request->validated());
            }
        }


        return redirect()->route('admin.umkms.edit', $umkm->id)->with([
            'message' => 'successfully updated !',
            'alert-type' => 'info'
        ]);
    }

    public function destroy(Umkm $umkm, Gallery $gallery): RedirectResponse
    {
        file::delete('storage/' . $gallery->photo);
        $gallery->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }
}
