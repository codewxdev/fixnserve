<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConsultantController extends Controller
{
   public function index(Request $request)
    {
        // 1. Start with a base query (e.g., all consultants)
        // For demonstration, we'll use a hardcoded array first.
        $allConsultants = [
             // Note: In a real app, this would be fetched from a database query builder (e.g., Consultant::query())
             ['id' => 1, 'name' => 'Consultant Name 1', 'expertise' => 'Financial Tech', 'rating' => 4.8],
             ['id' => 2, 'name' => 'Tech Expert 2', 'expertise' => 'Technology', 'rating' => 4.3],
             ['id' => 3, 'name' => 'Health Pro 3', 'expertise' => 'Health', 'rating' => 4.6],
             ['id' => 4, 'name' => 'Finance Advisor 4', 'expertise' => 'Finance', 'rating' => 4.9],
             ['id' => 5, 'name' => 'Tech Specialist 5', 'expertise' => 'Technology', 'rating' => 4.7],
        ];

        // Convert the array to a Laravel Collection for easy filtering
        $consultants = collect($allConsultants);

        // 2. Apply Search Filter
        if ($search = $request->get('search')) {
            $consultants = $consultants->filter(function ($consultant) use ($search) {
                // Check if the search term is in the name or expertise
                return str_contains(strtolower($consultant['name']), strtolower($search)) || 
                       str_contains(strtolower($consultant['expertise']), strtolower($search));
            });
        }

        // 3. Apply Expertise Filter
        if ($expertise = $request->get('expertise')) {
            $consultants = $consultants->where('expertise', $expertise);
        }

        // 4. Apply Rating Filter
        if ($rating = $request->get('rating')) {
            // Filter consultants where rating is greater than or equal to the selected value
            $consultants = $consultants->where('rating', '>=', (float)$rating);
        }

        // 5. Pass the filtered data to the view
        // In a real app, you would likely use ->paginate(10) here
        // and pass a Paginator instance.
        return view('Admin.consultant.index', [
            'consultants' => $consultants->values(), // Use ->values() to reset keys after filtering
        ]);
    }
}
