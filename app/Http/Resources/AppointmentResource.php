<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'reserved' => $this->reserved,
            'start_at' => $this->start_at,
            'clinic_name' => $this->clinic->name,
            'service_type' => $this->service_type,
            'doctor_name' => data_get($this->doctor, 'first_name').' '.data_get($this->doctor, 'last_name'),
            'patient_name' => data_get($this->patient, 'first_name').' '.data_get($this->patient, 'last_name'),
            'patient_medical_record' => data_get($this->patient, 'medicalRecord.id'),
        ];
    }
}
