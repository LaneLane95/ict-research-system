<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Research;

class ResearchController extends Controller
{
    public function index(Request $request)
    {
        // Ang categories natin base sa request mo
        $categories = ['DepEd', 'Non-DepEd', 'Innovation'];
        $selectedCategory = $request->get('category'); 
        $search = $request->get('search');

        // --- DASHBOARD VIEW (Kapag walang piniling category) ---
        if (!$selectedCategory) {
            $overallStats = [
                'total' => Research::count(),
                'deped' => Research::where('category', 'DepEd')->count(),
                'non_deped' => Research::where('category', 'Non-DepEd')->count(),
                'innovation' => Research::where('category', 'Innovation')->count(),
            ];
            
            return view('dashboard', compact('categories', 'overallStats', 'selectedCategory'));
        }

        // --- MODULE VIEW (Kapag may napiling Category) ---
        $researches = Research::where('category', $selectedCategory)
            ->where(function($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('author', 'LIKE', "%{$search}%")
                      ->orWhere('school_name', 'LIKE', "%{$search}%");
            })
            ->latest()
            ->get();

        $stats = [
            'total' => Research::where('category', $selectedCategory)->count(),
            'proposal' => Research::where('category', $selectedCategory)->where('sub_type', 'Proposal')->count(),
            'ongoing' => Research::where('category', $selectedCategory)->where('sub_type', 'Ongoing')->count(),
            'completed' => Research::where('category', $selectedCategory)->whereNotNull('completion_date')->count(),
        ];

        return view('dashboard', compact('researches', 'categories', 'selectedCategory', 'search', 'stats'));
    }

    public function store(Request $request) 
    {
        // I-save lahat ng fields na galing sa form
        Research::create([
            'category'          => $request->category,
            'sub_type'          => $request->sub_type,
            'date_received'     => $request->date_received,
            'school_id'         => $request->school_id,
            'school_name'       => $request->school_name,
            'district'          => $request->district,
            'author'            => $request->author,
            'title'             => $request->title,
            'type_of_research'  => $request->type_of_research,
            'theme'             => $request->theme,
            'endorsement_date'  => $request->endorsement_date,
            'released_date'     => $request->released_date,
            'completion_date'   => $request->completion_date,
            'coc_date'          => $request->coc_date, // Safe ito kahit null (Non-DepEd)
        ]);

        return back()->with('success', 'Data saved successfully!');
    }

    public function update(Request $request, $id) 
    {
        $research = Research::findOrFail($id);
        
        // Update functionality - flexible para sa kahit anong field
        $research->update($request->all());

        return back()->with('success', 'Updated successfully!');
    }

    public function destroy($id) 
    {
        Research::findOrFail($id)->delete();
        return back()->with('success', 'Record deleted.');
    }
}