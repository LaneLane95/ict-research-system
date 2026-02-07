<?php

namespace App\Http\Controllers;

use App\Models\Research;
use Illuminate\Http\Request;

class ResearchController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->query('category');
        $search = $request->query('search');
        $categories = ['DepEd', 'Non-DepEd', 'Innovation'];
        
        $query = Research::query();

        if ($selectedCategory == 'Archived') {
            $query->where('is_archived', true);
        } elseif ($selectedCategory) {
            $query->where('category', $selectedCategory)->where('is_archived', false);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('author', 'LIKE', "%{$search}%");
            });
        }

        $researches = $query->latest()->get();

        $overallStats = [
            'total' => Research::count(),
            'deped' => Research::where('category', 'DepEd')->where('is_archived', false)->count(),
            'archived' => Research::where('is_archived', true)->count(),
            'innovation' => Research::where('category', 'Innovation')->where('is_archived', false)->count(),
        ];

        return view('dashboard', compact('researches', 'categories', 'selectedCategory', 'search', 'overallStats'));
    }

    public function update(Request $request, $id)
    {
        $research = Research::findOrFail($id);
        
        // Eto yung fix para ma-save lahat ng dates
        $research->title = $request->title;
        $research->author = $request->author;
        $research->school_name = $request->school_name;
        $research->endorsement_date = $request->endorsement_date;
        $research->released_date = $request->released_date;
        $research->coc_date = $request->coc_date;
        
        $research->save();

        return back()->with('success', 'Updated successfully!');
    }

    public function archive($id)
    {
        $research = Research::findOrFail($id);
        $research->is_archived = true;
        $research->save();
        return back()->with('success', 'Archived successfully!');
    }

    public function store(Request $request) {
        $data = $request->all();
        $data['is_archived'] = false;
        Research::create($data);
        return back();
    }

    public function destroy($id) {
        Research::findOrFail($id)->delete();
        return back();
    }
}