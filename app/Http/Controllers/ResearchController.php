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
        
        $query = Research::query();

        // Pag 'Archived' ang pinili sa filter/link, ipakita lang ang naka-archive
        if ($selectedCategory == 'Archived') {
            $query->where('is_archived', true);
        } else {
            // Default: Ipakita lang ang hindi naka-archive
            $query->where('is_archived', false);
            if ($selectedCategory) {
                $query->where('category', $selectedCategory);
            }
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('author', 'LIKE', "%{$search}%");
            });
        }

        $researches = $query->latest()->get();

        // Stats para sa Dashboard Cards
        $overallStats = [
            'total' => Research::count(),
            'deped' => Research::where('category', 'DepEd')->where('is_archived', false)->count(),
            'archived' => Research::where('is_archived', true)->count(),
            'innovation' => Research::where('category', 'Innovation')->where('is_archived', false)->count(),
        ];

        return view('dashboard', compact('researches', 'selectedCategory', 'search', 'overallStats'));
    }

    public function store(Request $request) 
    {
        Research::create([
            'category'      => $request->category,
            'sub_type'      => $request->sub_type,
            'date_received' => $request->date_received,
            'author'        => $request->author,
            'title'         => $request->title,
            'is_archived'   => false,
        ]);
        return back()->with('success', 'Saved successfully!');
    }

    // ETO YUNG ARCHIVE FUNCTION
    public function archive($id) 
    {
        $research = Research::findOrFail($id);
        $research->is_archived = true;
        $research->save();
        return back()->with('success', 'Moved to Archived Modules!');
    }

    public function update(Request $request, $id) 
    {
        $research = Research::findOrFail($id);
        $research->update($request->all());
        return back()->with('success', 'Updated successfully!');
    }

    public function destroy($id) 
    {
        Research::findOrFail($id)->delete();
        return back()->with('success', 'Deleted!');
    }
}