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

    public function store(Request $request) {
        Research::create([
            'category'      => $request->category,
            'sub_type'      => $request->sub_type,
            'date_received' => $request->date_received,
            'author'        => $request->author,
            'title'         => $request->title,
            'is_archived'   => false,
        ]);
        return back()->with('success', 'Saved!');
    }

    public function update(Request $request, $id) {
        $research = Research::findOrFail($id);
        $research->update($request->all());
        return back()->with('success', 'Updated!');
    }

    public function archive($id) {
        $res = Research::findOrFail($id);
        $res->is_archived = true;
        $res->save();
        return back()->with('success', 'Archived!');
    }

    public function destroy($id) {
        Research::findOrFail($id)->delete();
        return back();
    }
}