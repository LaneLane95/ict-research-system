<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Research;

class ResearchController extends Controller
{
    public function index(Request $request)
    {
        $modules = ['Proposal Innovation', 'Thesis', 'Research', 'Dissertation', 'Certificate of Completion', 'Others']; 
        $selectedModule = $request->get('module'); 
        $search = $request->get('search');

        // DASHBOARD VIEW
        if (!$selectedModule) {
            $overallStats = [
                'total' => Research::count(),
                'checking' => Research::where('status', 'For Checking')->count(),
                'pending' => Research::where('status', 'Pending')->count(),
                'completed' => Research::where('status', 'Completed')->count(),
            ];
            
            $moduleSummary = [];
            foreach($modules as $m) {
                $moduleSummary[] = [
                    'name' => $m,
                    'count' => Research::where('module', $m)->count(),
                    'completed' => Research::where('module', $m)->where('status', 'Completed')->count()
                ];
            }
            return view('dashboard', compact('modules', 'overallStats', 'moduleSummary', 'selectedModule'));
        }

        // MODULE VIEW with SEARCH
        $researches = Research::where('module', $selectedModule)
            ->where(function($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('author', 'LIKE', "%{$search}%");
            })
            ->latest()
            ->get();

        $stats = [
            'total' => Research::where('module', $selectedModule)->count(),
            'checking' => Research::where('module', $selectedModule)->where('status', 'For Checking')->count(),
            'pending' => Research::where('module', $selectedModule)->where('status', 'Pending')->count(),
            'completed' => Research::where('module', $selectedModule)->where('status', 'Completed')->count(),
        ];

        return view('dashboard', compact('researches', 'modules', 'selectedModule', 'search', 'stats'));
    }

    public function store(Request $request) {
        Research::create([
            'title' => $request->title,
            'author' => $request->author,
            'status' => 'For Checking',
            'module' => $request->module,
            'entry_date' => now()->format('Y-m-d')
        ]);
        return back()->with('success', 'Data saved successfully!');
    }

    public function update(Request $request, $id) {
        $research = Research::findOrFail($id);
        $research->update([
            'status' => $request->status,
            'released_date' => $request->released_date
        ]);
        return back()->with('success', 'Updated successfully!');
    }

    public function destroy($id) {
        Research::findOrFail($id)->delete();
        return back()->with('success', 'Record deleted.');
    }
}