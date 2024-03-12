<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeamRequest;
use App\Models\Team;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    
   
    public function index(): View
    {
        $teams = Team::get();
        return view('admin.teams.index', compact('teams'));
    }

    public function create(): View
    {
        return view('admin.teams.create');
    }

    public function store(TeamRequest $request): RedirectResponse
    {
        if($request->validated()){
            $photo = $request->file('photo')->store('asset/team', 'public');
            Team::create($request->except('photo') + ['photo' => $photo]);
        }
        

        return redirect()->route('admin.teams.index')->with([
            'message' => 'successfully created !',
            'alert-type' => 'success'
        ]);
    }


    public function edit(Team $team): View
    {
        return view('admin.teams.edit', compact('team'));
    }

    public function update(TeamRequest $request, Team $team): RedirectResponse
    {
        if($request->validated()){
            if($request->photo){
                File::delete('storage/' . $team->photo);
                $photo = $request->file('photo')->store('asset/team', 'public');
                $team->update($request->except('photo') + ['photo' => $photo]);
            }else {
                $team->update($request->validated());
            }
        }

        return redirect()->route('admin.teams.index')->with([
            'message' => 'successfully updated !',
            'alert-type' => 'info'
        ]);
    }

    public function destroy(Team $team): RedirectResponse
    {
        File::delete('storage/' . $team->photo);
        $team->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }
}