<?php

namespace App\Models\Karoseri;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Identity extends Model
{
    use HasFactory, SoftDeletes;

    // Define the table name explicitly
    protected $table = 'msbodymaker_identitas';
    protected $primaryKey = 'id';
    // Define the fillable columns to allow mass assignment
    protected $fillable = [
        'ms_company_name',
        'ms_company_status',
        'ms_address',
        'ms_phone_number',
        'ms_email',
        'ms_website',
        'ms_established',
        'ms_owner',
        'ms_warranty_to_customer',
        'ms_business_activity',
        'ms_number_employee',
        'ms_building_area_land',
        'ms_quality_system',
        'ms_technical_assistance',
        'ms_number_of_branch',
        'ms_company_license',
        'created_at',
        'created_by',
        'update_at',
        'update_by',
        'deleted_at',
        'deleted_by',
        'ms_fax',
    ];

    // Timestamps
    public $timestamps = false; // Disable Laravel's automatic timestamps

    // Soft deletes
    protected $dates = ['deleted_at']; // Enable soft deletes

    /**
     * Update the model's attributes based on a where clause.
     *
     * @param  array  $attributes
     * @param  array  $whereConditions
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function updateModel(array $attributes, array $whereConditions)
    {
        $this->validateAttributes($attributes);

        // Create a query builder instance with the provided where conditions
        $queryBuilder = $this->newQuery();
        foreach ($whereConditions as $column => $value) {
            $queryBuilder->where($column, $value);
        }

        // Update the matching records with the provided attributes
        $queryBuilder->update($attributes);

        return $this;
    }

    /**
     * Validate the input data for updating.
     *
     * @param  array  $attributes
     * @return void
     * @throws \InvalidArgumentException
     */
    private function validateAttributes(array $attributes)
    {
        $validator = Validator::make($attributes, [
            'ms_company_name' => 'required|string|max:255',
            'ms_company_status' => 'required|string|max:255',
            'ms_address' => 'nullable|string|max:255',
            'ms_phone_number' => 'nullable|string|max:20',
            'ms_email' => 'nullable|email|max:255',
            'ms_website' => 'nullable|string|max:255',
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
            'ms_fax' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }
    }
}
