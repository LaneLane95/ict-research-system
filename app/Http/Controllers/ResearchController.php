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

        // ARCHIVE LOGIC: Kapag "Archived" ang click, pakita lahat ng may COC Date
        if ($selectedCategory == 'Archived') {
            $query->whereNotNull('coc_date');
        } 
        // MAIN MODULE LOGIC: Pakita lang ang category na pinili pero dapat WALANG COC Date
        elseif ($selectedCategory) {
            $query->where('category', $selectedCategory)->whereNull('coc_date');
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('author', 'LIKE', "%{$search}%")
                  ->orWhere('school_name', 'LIKE', "%{$search}%");
            });
        }

        $researches = $query->latest()->get();

        // Statistics para sa Dashboard Cards
        $overallStats = [
            'total' => Research::count(),
            'deped' => Research::where('category', 'DepEd')->whereNull('coc_date')->count(),
            'non_deped' => Research::where('category', 'Non-DepEd')->whereNull('coc_date')->count(),
            'innovation' => Research::where('category', 'Innovation')->whereNull('coc_date')->count(),
            'archived' => Research::whereNotNull('coc_date')->count(),
        ];

        return view('dashboard', compact('researches', 'categories', 'selectedCategory', 'search', 'overallStats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'author' => 'required',
            'category' => 'required',
            'sub_type' => 'nullable',
            'date_received' => 'nullable|date',
            'school_id' => 'nullable',
            'school_name' => 'nullable',
            'district' => 'nullable',
            'type_of_research' => 'nullable',
            'theme' => 'nullable',
            'coc_date' => 'nullable|date',
        ]);

        Research::create($data);
        return back()->with('success', 'Record saved!');
    }

    public function update(Request $request, $id)
    {
        $research = Research::findOrFail($id);
        $data = $request->validate([
            'title' => 'required',
            'author' => 'required',
            'school_name' => 'nullable',
            'endorsement_date' => 'nullable|date',
            'released_date' => 'nullable|date',
            'coc_date' => 'nullable|date',
        ]);

        $research->update($data);
        return back()->with('success', 'Record updated!');
    }

    public function destroy($id)
    {
        Research::findOrFail($id)->delete();
        return back()->with('success', 'Record deleted!');
    }
}