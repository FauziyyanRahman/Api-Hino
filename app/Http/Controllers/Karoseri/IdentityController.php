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
    public function index()
    {
        return Identity::all();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Identity
     */
    public function show($id)
    {
        return Identity::findOrFail($id);
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

            // Log the successful creation
            Log::info($message, ['identity_id' => $identity->id]);

            // Return a success response with the newly created record and a 200 status code
            return response()->json(['message' => $message, 'data' => $identity], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Unable to create record', ['error_message' => $e->getMessage()]);

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
        $identity = Identity::findOrFail($id);
        $identity->update($request->all());
        return $identity;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $identity = Identity::findOrFail($id);
        $identity->delete();
        return response()->json(['message' => 'Record deleted successfully']);
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
