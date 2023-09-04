<?php

namespace App\Http\Controllers\Karoseri;

use App\Http\Controllers\Controller;
use App\Models\Karoseri\DesignTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class DesignToolsController extends Controller
{
    public function __construct()
    {
        // Apply the 'auth.api' middleware to the functions that require authentication.
        $this->middleware('auth.api');
    }
    
    public function index(Request $request)
    {
        try {
            // Check if pagination parameters are provided
            $pageSize = $request->query('page_size');
            $page = $request->query('page');
    
            if ($pageSize && $page) {
                // If both page_size and page parameters are provided, paginate the results
                $designTools = DesignTools::paginate($pageSize, ['*'], 'page', $page);
            } else {
                // If no pagination parameters are provided, retrieve all records
                $designTools = DesignTools::withTrashed()->get();
            }
    
            // Check if any records were found
            if ($designTools->isEmpty()) {
                return response()->json(['message' => 'No records found'], 404);
            }
    
            // Return the records as JSON
            return response()->json([
                'success' => true,
                'message' => 'Design tools data retrieved successfully.',
                'data' => $designTools,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Return an error response
            return response()->json(['message' => 'An error occurred while fetching data.'], 500);
        }  
    }

    public function show($id)
    {
        $designTool = \DB::select("SELECT * FROM msbodymaker_design_tool WHERE ms_company_id = $id")[0] ?? null;

        if (!$designTool) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Design tools data for company id ' . $id . ' retrieved successfully.',
            'data' => $designTool,
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        // Validate the incoming JSON data
        $validator = Validator::make($request->all(), [
            'ms_quantity_of_computer_design' => 'required',
            'ms_twod_program_design' => 'required',
            'ms_threed_program_design' => 'required',
            'ms_company_id' => 'required',
        ]);

        if ($validator->fails()) {
            // Return validation error response
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Access the validated data from the validator
            $validatedData = $validator->validate();

            // Create a new design tool record with the validated data
            $designTool = DesignTools::create($validatedData);

            $message = 'Record created successfully';

            // Return a success response with the newly created record and a 200 status code
            return response()->json(['message' => $message, 'data' => $designTool], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., database errors) and return an error response
            return response()->json(['message' => 'Unable to create record', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $attributesToUpdate = $request->except(['id', 'ms_company_id']);

        // Define the where conditions for the update
        $whereConditions = ['ms_company_id' => $id];

        // Find the Identity model by ID
        $designTool = \DB::select("SELECT * FROM msbodymaker_design_tool WHERE ms_company_id = $id")[0] ?? null;

        if (!$designTool) {
            // If the record is not found, return an error response
            return response()->json([
                'success' => false,
                'message' => 'Record not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        // Attempt to update the record based on conditions
        $updated = \DB::table('msbodymaker_design_tool')
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

    public function destroy($id)
    {
        // Delete a specific design tool
        try {
            $designTool = \DB::select("DELETE FROM msbodymaker_design_tool WHERE ms_company_id = $id");
    
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
