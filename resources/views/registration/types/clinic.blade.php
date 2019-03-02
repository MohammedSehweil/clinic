@extends('backend.layouts.app')

@section('title', app_name() . ' | '. __('labels.backend.access.roles.management'))

@section('content')




    <div class="modal fade" id="clinicModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Clinics</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    @include('clinic.clinic_listing')
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">

                </div>
            </div>

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
                            <strong>Patient</strong>
                            <small>Personal Info</small>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" id="name" type="text" placeholder="Enter your Name"
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input class="form-control" id="phone" type="text"
                                       placeholder="Enter your phone number" required>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


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
                                    <label for="phone">Service Location</label>
                                    {!! Form::select('service_location', ['home' => 'Home', 'clinic' => 'Clinic'], null, ['id' => 'service_location','class' => 'form-control select2_class_service_location']); !!}
                                    <small>Type the other location then press enter</small>

                                </div>

                                <div class="form-group col-md-9">
                                    <label> Choose appointment</label>
                                    <div style="overflow:hidden;">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div id="datetimepicker12"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="phone">Choose Clinic</label>
                                    {!! Form::select('patientClinics[]', app(\App\Methods\GeneralMethods::class)->getAllClinics(), null, ['id' => 'patientClinics','class' => 'form-control select2_class_clinics_for_patient', 'multiple' => 'multiple']); !!}
                                    <small>You can choose multiple clinics, An appointment will be made to you at the
                                        first clinic that approves your application
                                    </small>
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="phone">Choose Specialties</label>
                                    {!! Form::select('patientSpecialties[]', [], null, ['id' => 'patientSpecialties','class' => 'form-control select2_class_specialties_for_patient']); !!}
                                    <small></small>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <button class="btn btn-primary mb-1" type="button" data-toggle="modal" data-target="#clinicModal">Show All
                Clinics
            </button>


        </div>
    </div>

    <script type="application/javascript">

        let body = $('body');

        $(document).ready(function () {
            $('.select2_class_service_location').select2({
                placeholder: "Select Service Location",
                tags: true,
            });
        });


        $('#patientClinics').on('select2:select', function (e) {
            var data = e.params.data;
            console.log(data);
        });


    </script>


@endsection

@push('after-styles')


    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

@endpush

@push('after-scripts')
    <script type="text/javascript">

        $('.select2_class_clinics_for_patient').select2({
            placeholder: "Select Clinic",
        });

        $('.select2_class_specialties_for_patient').select2({
            placeholder: "Select Specialties",
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

            console.log(clinicsIds);
        });

    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
@endpush