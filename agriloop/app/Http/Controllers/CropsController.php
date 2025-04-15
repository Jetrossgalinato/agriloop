<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crops; // Ensure you import the Crops model

class CropsController extends Controller
{
    public function getMeals()
    {
        // Retrieve all crops from the database
        $crops = Crops::all();

        // Append the full URL to the image path
        $crops->transform(function ($crop) {
            $crop->image = url('storage/' . $crop->image); // Assuming images are stored in the 'storage/app/public' directory
            return $crop;
        });

        // Return the crops as a JSON response
        return response()->json($crops);
    }
}
