@extends('backend.layouts.app')


@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Doctor Management
                        <small class="text-muted">Show Doctor</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->
            <!--row-->

            <hr/>

            <div class="row mt-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.access.roles.name'))
                            ->class('col-md-2 form-control-label')
                            ->for('name') }}

                        <div class="col-md-10">
                            {{$doctor->name ?? '-'}}
                        </div><!--col-->
                    </div>


                    <div class="form-group row">
                        {{ html()->label('email')
                            ->class('col-md-2 form-control-label')
                            ->for('email') }}

                        <div class="col-md-10">
                            {{$doctor->email ?? '-'}}
                        </div><!--col-->
                    </div>


                    <div class="form-group row">
                        {{ html()->label('Clinics')
                            ->class('col-md-2 form-control-label')
                            ->for('email') }}

                        <div class="col-md-10">
                            {!! badges(app(\App\Methods\DoctorMethods::class)->getDoctorClinics($doctor)) !!}
                        </div><!--col-->
                    </div>


                    <div class="form-group row">
                        {{ html()->label('Specialties')
                            ->class('col-md-2 form-control-label')
                             }}

                        <div class="col-md-10">
                            {!! badges(app(\App\Methods\DoctorMethods::class)->getDoctorSpecialties($doctor), 'primary') !!}
                        </div><!--col-->
                    </div>



                </div><!--col-->


            </div><!--row-->

            <div class="row">
                <div class="col-md-12">
                    <div class="pull-right" style="float: right;">
                        {!! $doctor->action_buttons !!}
                    </div><!--col-->
                </div>

            </div>


        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.doctor.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
@endsection
