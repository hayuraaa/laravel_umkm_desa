<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UmkmRequest;
use App\Models\Agent;
use App\Models\Umkm;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class UmkmController extends Controller
{

    public function index(): View
    {
        $umkms = Umkm::get();

        return view('admin.umkms.index', compact('umkms'));
    }

    public function create(): View
    {
        $agents = Agent::get();

        return view('admin.umkms.create', compact('agents'));
    }

    public function store(UmkmRequest $request): RedirectResponse
    {
        if ($request->validated()) {
            $banner = $request->file('banner')->store('assets/umkm', 'public');
            $slug = Str::slug($request->title, '-');
            Umkm::create($request->except('banner') + ['banner' => $banner, 'slug' => $slug]);
        }


        return redirect()->route('admin.umkms.index')->with([
            'message' => 'successfully created !',
            'alert-type' => 'success'
        ]);
    }

    public function edit(Umkm $umkm): View
    {
        $agents = Agent::get();
        return view('admin.umkms.edit', compact('umkm', 'agents'));
    }

    public function update(UmkmRequest $request, Umkm $umkm): RedirectResponse
    {
        if ($request->validated()) {
            $slug = Str::slug($request->title, '-');
            if ($request->banner) {
                file::delete('storage/' . $umkm->banner);
                $banner = $request->file('banner')->store('assets/umkm', 'public');
                $umkm->update($request->except('banner') + ['banner' => $banner, 'slug' => $slug]);
            } else {
                $umkm->update($request->validated() + ['slug' => $slug]);
            }
        }

        return redirect()->route('admin.umkms.index')->with([
            'message' => 'successfully updated !',
            'alert-type' => 'info'
        ]);
    }

    public function destroy(Umkm $umkm): RedirectResponse
    {
        file::delete('storage/' . $umkm->banner);
        $umkm->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }
}