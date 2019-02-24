@extends('backend.layouts.app')

@section('title', app_name() . ' | '. __('labels.backend.access.roles.management'))

@section('content')
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
                                        <script type="text/javascript">
                                            $(function () {
                                                $('#datetimepicker12').datetimepicker({
                                                    inline: true,
                                                    sideBySide: true,
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>


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
    </div>

    <script type="application/javascript">


        $(document).ready(function () {
            $('.select2_class_service_location').select2({
                placeholder: "Select Service Location",
                tags: true,
            });
        });


    </script>


@endsection

@push('after-styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

@endpush

@push('after-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
@endpush