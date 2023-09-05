<?php

namespace App\Http\Controllers\Banners;

use App\Http\Controllers\Controller;
use App\Models\Banners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class BannersController extends Controller
{ 
    public function __construct()
    {
        // Apply the 'auth.api' middleware to the functions that require authentication.
        $this->middleware('auth.api');
    }

    // Retrieve all banners
    public function index(Request $request)
    {
        try {
            // Check if pagination parameters are provided
            $pageSize = $request->query('page_size');
            $page = $request->query('page');
    
            if ($pageSize && $page) {
                // If both page_size and page parameters are provided, paginate the results
                $banners = Banners::paginate($pageSize, ['*'], 'page', $page);
            } else {
                // If no pagination parameters are provided, retrieve all records
                $banners = Banners::withTrashed()->get();
            }
    
            // Check if any records were found
            if ($banners->isEmpty()) {
                return response()->json(['message' => 'No records found'], 404);
            }
    
            // Return the records as JSON
            return response()->json([
                'success' => true,
                'message' => 'Banners data retrieved successfully.',
                'data' => $banners,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Return an error response
            return response()->json(['message' => 'An error occurred while fetching data.'], 500);
        }  
    }

    // Retrieve a specific banner by ID
    public function show($id, $typeB)
    {
        $typeBanners = ucfirst($typeB);

        $banners = \DB::select("SELECT * FROM msbanner WHERE ms_company_id = $id AND ms_type = '$typeBanners'");

        if (!$banners) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Banners ' . $typeBanners . ' data for company id ' . $id . ' retrieved successfully.',
            'data' => $banners,
        ], Response::HTTP_OK);
    }

    // Create a new banner
    public function store(Request $request)
    {
        // Validate the incoming JSON data
        $request->validate([
            'ms_title' => 'required|string',
            'ms_description' => 'required|string',
            'ms_company_id' => 'required|integer',
            'files' => 'required|array',
            'files.*.file_type' => 'required|string|in:images,videos',
            'files.*.file_name' => 'required|string',
        ]);

        $data = $request->all();

        try {
            // Start a database transaction
            DB::beginTransaction();

            foreach ($data['files'] as $fileData) {
                $banner = new Banners([
                    'ms_title' => $data['ms_title'],
                    'ms_description' => $data['ms_description'],
                    'ms_company_id' => $data['ms_company_id'],
                    'ms_type' => ucfirst($fileData['file_type']),
                    'ms_url' => $fileData['file_name'],
                ]);

                $banner->save();
            }

            // Commit the transaction if all saves were successful
            DB::commit();

            $message = 'All records created successfully';

            // Return a success response with the newly created records and a 201 status code
            return response()->json(['message' => $message, 'data' => $data], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // Roll back the transaction on error
            DB::rollBack();
            
            // Handle the error as needed (e.g., log it or return an error response)
            return response()->json(['message' => 'Unable to create records', 'error' => $e->getMessage()], 500);
        }
    }
    

    // Update a banner by ID
    public function update(Request $request, $id, $idBanners)
    {
        $attributesToUpdate = $request->only(['ms_title', 'ms_description', 'ms_url', 'ms_status', 'update_by']);

        // Define the where conditions for the update
        $whereConditions = ['id' => $idBanners, 'ms_company_id' => $id];

        // Find the Identity model by ID
        $banners = \DB::table('msbanner')->where($whereConditions)->first();

        if (!$banners) {
            // If the record is not found, return an error response
            return response()->json([
                'success' => false,
                'message' => 'Record not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        // Add the 'updated_at' field to the attributesToUpdate
        $attributesToUpdate['update_at'] = now();

        // Attempt to update the record based on conditions
        $updated = \DB::table('msbanner')
            ->where($whereConditions)
            ->update($attributesToUpdate);

        if ($updated) {
            // If the record was successfully updated, return a success response
            return response()->json([
                'success' => true,
                'message' => 'Record updated successfully.',
            ], Response::HTTP_OK);
        } else {
            // If the record was not updated, return an error response
            return response()->json([
                'success' => false,
                'message' => 'Record update failed',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Delete a banner by ID
    public function destroy($id, $idBanners)
    {
        // Delete a specific design tool
        try {
            $pic = \DB::select("DELETE FROM msbanner WHERE id = $idBanners AND ms_company_id = $id");
    
            return response()->json([
                'success' => true,
                'message' => 'Record deleted successfully.',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the record',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
