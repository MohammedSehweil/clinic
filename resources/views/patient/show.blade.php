@extends('backend.layouts.app')


@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Patient Management
                        <small class="text-muted">Show Patient</small>
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
                            {{$patient->name ?? '-'}}
                        </div><!--col-->
                    </div>


                    <div class="form-group row">
                        {{ html()->label('email')
                            ->class('col-md-2 form-control-label')
                            ->for('email') }}

                        <div class="col-md-10">
                            {{$patient->email ?? '-'}}
                        </div><!--col-->
                    </div>


                    <div class="form-group row">
                        {{ html()->label('clinics')
                            ->class('col-md-2 form-control-label')
                            ->for('email') }}

                        <div class="col-md-10">
                            {!! badges($patient->clinics()->pluck('name')->toArray()) !!}
                        </div><!--col-->
                    </div>

                </div><!--col-->


            </div><!--row-->

            <div class="row">
                <div class="col-md-12">
                    <div class="pull-right" style="float: right;">
                        {!! $patient->action_buttons !!}
                    </div><!--col-->
                </div>

            </div>


        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.patient.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
@endsection
