<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AgentRequest;
use App\Models\Agent;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class AgentController extends Controller
{

    public function index(): View
    {
        $agents = Agent::get();

        return view('admin.agents.index', compact('agents'));
    }

    public function create(): View
    {
        return view('admin.agents.create');
    }

    public function store(AgentRequest $request): RedirectResponse
    {
        if ($request->validated()) {
            $photo = $request->file('photo')->store('assets/agent', 'public');
            Agent::create($request->except('photo') + ['photo' => $photo]);
        }

        return redirect()->route('admin.agents.index')->with([
            'message' => 'successfully created !',
            'alert-type' => 'success'
        ]);
    }



    public function edit(Agent $agent): View
    {
        return view('admin.agents.edit', compact('agent'));
    }

    public function update(AgentRequest $request, Agent $agent): RedirectResponse
    {
        if ($request->validated()) {
            if ($request->photo) {
                File::delete('storage/' . $agent->photo);
                $photo = $request->file('photo')->store('assets/agent', 'public');
                $agent->update($request->except('photo') + ['photo' => $photo]);
            } else {
                $agent->update($request->validated());
            }
        }

        return redirect()->route('admin.agents.index')->with([
            'message' => 'successfully updated !',
            'alert-type' => 'info'
        ]);
    }

    public function destroy(Agent $agent): RedirectResponse
    {
        File::delete('storage/' . $agent->photo);
        $agent->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }
}
