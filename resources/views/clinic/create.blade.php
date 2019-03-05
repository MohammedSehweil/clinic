@extends('backend.layouts.app')


@section('content')
    {{ html()->form('POST', route('admin.clinic.store'))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Clinic Management
                        <small class="text-muted">Create Clinic</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.access.roles.name'))
                            ->class('col-md-2 form-control-label')
                            ->for('name') }}

                        <div class="col-md-4">
                            {{ html()->text('name')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.access.roles.name'))
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->


                    <div class="form-group row">
                        {{ html()->label('Add Specialties')
                            ->class('col-md-2 form-control-label')
                            ->for('specialties') }}

                        <div class="col-md-4">
                            {!! Form::select('specialties[]', app(\App\Methods\GeneralMethods::class)->getAllSpecialties(), null, ['id' => 'specialties', 'class' => 'form-control select2_class_specialties', 'multiple' => 'multiple']); !!}
                        </div><!--col-->
                    </div>


                    <div class="form-group row">
                        {{ html()->label('Choose Country')
                            ->class('col-md-2 form-control-label')
                            ->for('country_id') }}

                        <div class="col-md-4">
                            {!! Form::select('country_id', app(\App\Methods\GeneralMethods::class)->getAllCountries(), null, ['id' => 'country_id', 'class' => 'form-control']); !!}
                        </div><!--col-->
                    </div>

                    <div class="form-group row">
                        {{ html()->label('City')
                            ->class('col-md-2 form-control-label')
                            ->for('city') }}

                        <div class="col-md-4">
                            {{ html()->text('city')
                                ->class('form-control')
                                ->placeholder('City')
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div>


                    <div class="form-group row">
                        {{ html()->label('service_location')
                            ->class('col-md-2 form-control-label')
                            ->for('service_location') }}

                        <div class="col-md-4">
                            {!! Form::select('service_location', ['home' => 'Home', 'clinic' => 'Clinic'], null, ['id' => 'service_location','class' => 'form-control select2_class_service_location']); !!}
                        </div>
                    </div>


                    <div class="form-group row">
                        {{ html()->label('Service Location')
                            ->class('col-md-2 form-control-label')
                            ->for('service_location') }}

                        <div class="col-md-4">
                            {{ html()->text('service_location')
                                ->class('form-control')
                                ->placeholder('Service Location')
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div>


                    <div class="form-group row">
                        {{ html()->label('Description')
                            ->class('col-md-2 form-control-label')
                            ->for('description') }}

                        <div class="col-md-4">
                            {{ html()->textarea('description')
                                ->class('form-control')
                                ->placeholder('Description')
                                ->required()
                                ->autofocus() }}
                        </div>
                    </div>


                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.clinic.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.create')) }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
    {{ html()->form()->close() }}




    <script type="application/javascript">

        $(document).ready(function () {
            $('.select2_class_specialties').select2({
                placeholder: "Select Specialties",
                tags: true
            });

            $('.select2_class_service_location').select2({
                placeholder: "Select Specialties",
            });
        });
    </script>
@endsection
