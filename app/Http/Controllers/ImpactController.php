<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Impact;


class ImpactController extends Controller
{
            public function index()
        {
            $impact = Impact::first(); // Assume only one row is maintained
            return view('impacts.index', compact('impact'));
        }

        public function create()
        {
            return view('impacts.create');
        }

        public function store(Request $request)
        {
            $request->validate([
                'total_people' => 'required|integer|min:0',
                'total_events' => 'required|integer|min:0',
                'total_trainings' => 'required|integer|min:0',
            ]);

            Impact::create($request->all());
            return redirect()->route('impacts.index')->with('success', 'Impact stats added.');
        }

        public function show(Impact $impact)
        {
            return view('impacts.show', compact('impact'));
        }

        public function edit(Impact $impact)
        {
            return view('impacts.edit', compact('impact'));
        }

        public function update(Request $request, Impact $impact)
        {
            $request->validate([
                'total_people' => 'required|integer|min:0',
                'total_events' => 'required|integer|min:0',
                'total_trainings' => 'required|integer|min:0',
            ]);

            $impact->update($request->all());
            return redirect()->route('impacts.index')->with('success', 'Impact stats updated.');
        }

        public function destroy(Impact $impact)
        {
            $impact->delete();
            return redirect()->route('impacts.index')->with('danger', 'Impact stats deleted.');
        }
}
