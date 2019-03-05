@extends('backend.layouts.app')

@section('title', app_name() . ' | '. __('labels.backend.access.roles.management'))

@section('content')



    <div class="card">
        <div class="card-body">
            @include('clinic.clinic_listing_with_filters')
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <h4 class="card-title mb-0">
                        Clinic Registration
                    </h4>
                </div>
            </div>
            <br>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Registration</strong>
                            <small>Form</small>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="phone">Choose Clinic</label>
                                    {!! Form::select('patientClinics[]', [], null, ['id' => 'patientClinics','class' => 'form-control select2_class_clinics_for_patient', 'multiple' => 'multiple']); !!}
                                    <small>You can choose multiple clinics, An appointment will be made to you at the
                                        first clinic that approves your application
                                    </small>
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="phone">Choose Specialties</label>
                                    {!! Form::select('patientSpecialties[]', [], null, ['id' => 'patientSpecialties','class' => 'form-control select2_class_specialties_for_patient']); !!}
                                    <small>Not required</small>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="phone">Choose Doctors</label>
                                    {!! Form::select('patientDoctors[]', [], null, ['id' => 'patientDoctors','class' => 'form-control select2_class_doctors_for_patient']); !!}
                                    <small>Not required</small>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <button class="btn btn-primary mb-1" type="button" data-toggle="modal" data-target="#clinicModal">Reserve Appointment</button>


        </div>
    </div>

    <script type="application/javascript">

        let body = $('body');

        $(document).ready(function () {
            $('.select2_class_service_location').select2({
                placeholder: "Select Service Location",
            });
        });

    </script>


@endsection

@push('after-styles')


    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.3/daterangepicker.min.css">

@endpush

@push('after-scripts')
    <script type="text/javascript">

        $('.select2_class_clinics_for_patient').select2({
            placeholder: "Select Clinic",
        });

        $('.select2_class_specialties_for_patient').select2({
            placeholder: "Select Specialties",
        });

        $('.select2_class_doctors_for_patient').select2({
            placeholder: "Select Doctors",
        });


        $(function () {
            $('#datetimepicker12').datetimepicker({
                inline: true,
                sideBySide: true,
            });
        });

        $('#patientClinics').on('select2:select', function (e) {
            var clinicsIds = $(this).val();

            $('#patientSpecialties').select2({
                ajax: {
                    url: '/api/clinics/specialties',
                    data: {
                        'clinicsIds': clinicsIds
                    }
                }
            });

        });


        $('#patientSpecialties').on('select2:select', function (e) {
            var specialtiesId = $(this).val();

            $('#patientDoctors').select2({
                ajax: {
                    url: '/api/specialties/doctors',
                    data: {
                        'specialtiesId': specialtiesId
                    }
                }
            });

        });

    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.3/daterangepicker.min.js"></script>
@endpush