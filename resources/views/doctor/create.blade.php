@extends('backend.layouts.app')


@section('content')
    {{ html()->form('POST', route('admin.doctor.store'))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Doctor Management
                        <small class="text-muted">Create Doctor</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label('First Name')
                            ->class('col-md-2 form-control-label')
                            ->for('first_name') }}

                        <div class="col-md-5">
                            {{ html()->text('first_name')
                                ->class('form-control')
                                ->placeholder('First Name')
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div>


                    <div class="form-group row">
                        {{ html()->label('Second Name')
                            ->class('col-md-2 form-control-label')
                            ->for('name') }}

                        <div class="col-md-5">
                            {{ html()->text('last_name')
                                ->class('form-control')
                                ->placeholder('Second Name')
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div>


                    <div class="form-group row">
                        {{ html()->label('Email')
                            ->class('col-md-2 form-control-label')
                            ->for('email') }}

                        <div class="col-md-5">
                            {{ html()->text('email')
                                ->class('form-control')
                                ->placeholder('Email')
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div>


                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.access.users.password'))->class('col-md-2 form-control-label')->for('password') }}

                        <div class="col-md-5">
                            {{ html()->password('password')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.access.users.password'))
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.access.users.password_confirmation'))->class('col-md-2 form-control-label')->for('password_confirmation') }}

                        <div class="col-md-5">
                            {{ html()->password('password_confirmation')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.access.users.password_confirmation'))
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->


                    <div class="form-group row">
                        {{ html()->label('Phone Number')
                            ->class('col-md-2 form-control-label')
                            ->for('phone') }}

                        <div class="col-md-5">
                            {{ html()->text('phone')
                                ->class('form-control')
                                ->placeholder('Phone Number')
                                ->attribute('maxlength', 191)
                                ->autofocus() }}
                        </div><!--col-->
                    </div>


                    <div class="form-group row">
                        {{ html()->label('Choose Clinic')
                            ->class('col-md-2 form-control-label')
                            ->for('clinics') }}

                        <div class="col-md-5">
                            {!! Form::select('clinics', app(\App\Methods\GeneralMethods::class)->getCurrentUserClinics(), null, ['id' => 'clinics', 'class' => 'form-control select2_class_clinic']); !!}
                        </div><!--col-->
                    </div>


                    <div class="form-group row">
                        {{ html()->label('Choose Specialties')
                            ->class('col-md-2 form-control-label')
                            ->for('specialties') }}

                        <div class="col-md-5">
                            {!! Form::select('specialties[]', app(\App\Methods\GeneralMethods::class)->getAllSpecialties(), null, ['id' => 'specialties', 'class' => 'form-control select2_class_specialties', 'multiple' => 'multiple']); !!}
                        </div><!--col-->
                    </div>



                    <!--form-group-->

                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.doctor.index'), __('buttons.general.cancel')) }}
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
            });
        });
    </script>


@endsection
