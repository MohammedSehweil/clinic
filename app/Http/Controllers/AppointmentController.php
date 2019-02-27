<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auth\Appointment;
use App\Http\Resources\AppointmentResource;
use App\Http\Resources\AppointmentsResource;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new AppointmentsResource(Appointment::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Appointment::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new AppointmentResource(Appointment::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->update($request->all());

        return $appointment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->delete();
    }

    public function search(Request $request)
    {
        $appointments= $this->loadQuery($request)
            ->get();

        return new AppointmentsResource($appointments);
    }

    public function loadQuery($request)
    {
        // Allow custom params from request
        $permittedParams = ['doctor_id', 'service_type', 'reserved', 'clinic_id', 'start_at'];

        $query = Appointment::query();

        foreach ($permittedParams as $param) {
            if ($value = $request->get($param)) {
                $query->where($param, $value);
            }
        }

        if ($request->get('range')) {
            return $query->whereBetween('start_at', $request->get('range'));
        }

        return $query;
    }

    public function getAppointments()
    {
        return new AppointmentsResource(\Auth::user()->myAppointments);
    }
}
