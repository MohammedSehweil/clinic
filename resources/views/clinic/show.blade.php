@extends('backend.layouts.app')


@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Clinic Management
                        <small class="text-muted">Show Clinic</small>
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
                            {{$clinic->name ?? '-'}}
                        </div><!--col-->
                    </div>


                    <div class="form-group row">
                        {{ html()->label('Specialties')
                            ->class('col-md-2 form-control-label')
                        }}

                        <div class="col-md-10">


                            <ul>
                                @foreach( $clinic->specialties()->get() as $key => $specialties)
                                    <li>
                                        {{$specialties->name}}
                                        <ul>
                                            @foreach( app(\App\Methods\DoctorMethods::class)->getSpecialtiesDoctors($specialties) as $doctor)
                                                <li>{{$doctor}}</li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>


                        </div><!--col-->
                    </div>


                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.clinic.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
@endsection
