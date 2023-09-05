<?php

namespace App\Http\Controllers\Karoseri;

use App\Http\Controllers\Controller;
use App\Models\Karoseri\Skrb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SkrbController extends Controller
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
                $equipment = Skrb::paginate($pageSize, ['*'], 'page', $page);
            } else {
                // If no pagination parameters are provided, retrieve all records
                $equipment = Skrb::withTrashed()->get();
            }
    
            // Check if any records were found
            if ($equipment->isEmpty()) {
                return response()->json(['message' => 'No records found'], 404);
            }
    
            // Return the records as JSON
            return response()->json([
                'success' => true,
                'message' => 'SKRB data retrieved successfully.',
                'data' => $equipment,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Return an error response
            return response()->json(['message' => 'An error occurred while fetching data.'], 500);
        }  
    }

    public function show($id)
    {
        $pic = \DB::select("SELECT * FROM msbodymaker_skrb WHERE ms_company_id = $id");

        if (!$pic) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'SKRB data for company id ' . $id . ' retrieved successfully.',
            'data' => $pic,
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        // Validate the incoming JSON data
        $validator = Validator::make($request->all(), [
            '*.ms_hino_five' => 'nullable',
            '*.ms_hino_three' => 'nullable',
            '*.ms_hino_bus' => 'nullable',
            '*.ms_company_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // Return validation error response
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Access the validated data from the validator
            $validatedData = $validator->validated();

            // Initialize an empty array to store the created records
            $createdRecords = [];

            foreach ($validatedData as $data) {
                // Create a new design tool record with the validated data
                $skrb = Skrb::create($data);

                // Add the created record to the array
                $createdRecords[] = $skrb;
            }

            // Commit the database transaction if all records were created successfully
            DB::commit();

            $message = 'All records created successfully';

            // Return a success response with the newly created records and a 201 status code
            return response()->json(['message' => $message, 'data' => $createdRecords], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // Roll back the database transaction in case of an exception
            DB::rollback();

            // Handle any exceptions (e.g., database errors) and return an error response
            return response()->json(['message' => 'Unable to create records', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id, $idSk)
    {
        $attributesToUpdate = $request->except(['id', 'ms_company_id']);

        // Define the where conditions for the update
        $whereConditions = ['id' => $idSk, 'ms_company_id' => $id];

        // Find the Identity model by ID
        $pic = \DB::select("SELECT * FROM msbodymaker_skrb WHERE id = $idSk AND ms_company_id = $id")[0] ?? null;

        if (!$pic) {
            // If the record is not found, return an error response
            return response()->json([
                'success' => false,
                'message' => 'Record not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        // Attempt to update the record based on conditions
        $updated = \DB::table('msbodymaker_skrb')
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
            $pic = \DB::select("DELETE FROM msbodymaker_skrb WHERE ms_company_id = $id");
    
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
