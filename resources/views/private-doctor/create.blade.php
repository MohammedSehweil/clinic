@extends('backend.layouts.app')


@section('content')

    @if(!currentUser()->info_filled)
        <div class="alert alert-danger" role="alert">
            You must fill your information before you start using our services.
        </div>
    @endif


    {{ html()->form('POST', route('admin.private-doctor.store', ['privatedoctor' => $user]))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Fill Your Data
                        <small class="text-muted">Fill/Edit Your Data</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4">
                <div class="col">


                    <div class="form-group row">
                        {{ html()->label('Add Specialties')
                            ->class('col-md-2 form-control-label')
                            ->for('specialties') }}

                        <div class="col-md-4">
                            {!! Form::select('specialties[]', app(\App\Methods\GeneralMethods::class)->getAllSpecialties(), app(\App\Methods\PrivateDoctorMethods::class)->getPrivateDoctorSpecialties($user), ['id' => 'specialties', 'class' => 'form-control select2_class_specialties', 'multiple' => 'multiple']); !!}
                        </div>
                    </div>


                    <div class="form-group row">
                        {{ html()->label('Choose Country')
                            ->class('col-md-2 form-control-label')
                            ->for('country_id') }}

                        <div class="col-md-4">
                            {!! Form::select('country_id', app(\App\Methods\GeneralMethods::class)->getAllCountries(), $user->country_id, ['id' => 'country_id', 'class' => 'form-control']); !!}
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
                                ->value($user->city)
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
                                ->value($user->description)
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
                    {{ form_cancel(route('admin.private-doctor.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit('Fill') }}
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
        });
    </script>
@endsection


@push('after-styles')
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush