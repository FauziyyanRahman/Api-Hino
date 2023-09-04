<?php

namespace App\Http\Controllers\Karoseri;

use App\Http\Controllers\Controller;
use App\Models\Karoseri\Identity;
use App\Services\Karoseri\IdentityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class IdentityController
 * @package App\Http\Controllers\Karoseri
 */
class IdentityController extends Controller
{
    public function __construct()
    {
        // Apply the 'auth.api' middleware to the functions that require authentication.
        $this->middleware('auth.api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection|Identity[]
     */
    public function index(Request $request)
    {
        try {
            // Check if pagination parameters are provided
            $pageSize = $request->query('page_size');
            $page = $request->query('page');
    
            if ($pageSize && $page) {
                // If both page_size and page parameters are provided, paginate the results
                $identities = Identity::paginate($pageSize, ['*'], 'page', $page);
            } else {
                // If no pagination parameters are provided, retrieve all records
                $identities = Identity::withTrashed()->get();
            }
    
            // Check if any records were found
            if ($identities->isEmpty()) {
                return response()->json(['message' => 'No records found'], 404);
            }
    
            // Return the records as JSON
            return response()->json([
                'success' => true,
                'message' => 'Identity data retrieved successfully.',
                'data' => $identities,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error in index method: ' . $e->getMessage());
    
            // Return an error response
            return response()->json(['message' => 'An error occurred while fetching data.'], 500);
        }   
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Identity
     */
    public function show($id)
    {
        $identity = \DB::select("SELECT * FROM msbodymaker_identitas WHERE id = $id")[0] ?? null;

        if (!$identity) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Identity data ' . $id . ' retrieved successfully.',
            'data' => $identity,
        ], Response::HTTP_OK);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Identity
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), $this->validationRules());

        if ($validator->fails()) {
            // Return validation error response
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Create a new Identity record using a service
            $identityService = new IdentityService();
    
            // Access the validated data from the validator
            $validatedData = $validator->validate();

            $identity = $identityService->createIdentity($validatedData);

            // Custom success message
            $message = 'Record created successfully';

            // Return a success response with the newly created record and a 200 status code
            return response()->json(['message' => $message, 'data' => $identity], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., database errors) and return an error response
            return response()->json(['message' => 'Unable to create record', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Identity
     */
    public function update(Request $request, $id)
    {
        // Retrieve the request data for updating (excluding 'id' and 'ms_company_name')
        $attributesToUpdate = $request->except(['id', 'ms_company_name']);

        // Define the where conditions for the update
        $whereConditions = ['id' => $id];

        // Find the Identity model by ID
        $identity = \DB::select("SELECT * FROM msbodymaker_identitas WHERE id = $id")[0] ?? null;

        if (!$identity) {
            // If the record is not found, return an error response
            return response()->json([
                'success' => false,
                'message' => 'Record not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        // Attempt to update the record based on conditions
        $updated = \DB::table('msbodymaker_identitas')
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $identity = \DB::select("DELETE FROM msbodymaker_identitas WHERE id = $id");
    
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

    public function validationRules() {

        return [
            'ms_company_name' => 'required|string|max:255',
            'ms_company_status' => 'required|string|max:255',
            'ms_address' => 'required|string|max:255',
            'ms_phone_number' => 'required|string|max:20',
            'ms_fax' => 'required|string|max:20',
            'ms_email' => 'nullable|email',
            'ms_website' => 'nullable|url',
            'ms_established' => 'nullable|date',
            'ms_owner' => 'nullable|string|max:255',
            'ms_warranty_to_customer' => 'nullable|string|max:255',
            'ms_business_activity' => 'nullable|string|max:255',
            'ms_number_employee' => 'nullable|integer',
            'ms_building_area_land' => 'nullable|numeric',
            'ms_quality_system' => 'nullable|string|max:255',
            'ms_technical_assistance' => 'nullable|string|max:255',
            'ms_number_of_branch' => 'nullable|integer',
            'ms_company_license' => 'nullable|string|max:255',
        ];
    }
}
