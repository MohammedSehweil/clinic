@extends('backend.layouts.app')

@section('title', app_name() . ' | '. __('labels.backend.access.roles.management'))

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Private Doctors Management
                    </h4>
                </div><!--col-->

                @if(isPrivateDoctor())
                    <div class="col-sm-7 pull-right">
                        <div class="btn-toolbar float-right" role="toolbar"
                             aria-label="@lang('labels.general.toolbar_btn_groups')">
                            <a href="{{ route('admin.private-doctor.create', ['privatedoctor' => $logged_in_user->id]) }}"
                               class="btn btn-success ml-1"
                               data-toggle="tooltip" title="@lang('labels.general.create_new')"><i
                                        class="fas fa-plus-circle"></i></a>
                        </div>

                    </div><!--col-->
                @endif
            </div><!--row-->

            <br>
            <div class="card">
                <h5 class="card-header">
                    Filter
                    {!! Form::submit('Search', ['id' => 'search_btn', 'class' => 'btn-sm float_right']); !!}

                    <button class="btn-sm float_right" type="button" data-toggle="collapse"
                            data-target="#collapsePanel" aria-expanded="false" aria-controls="collapseExample">
                        Collapse
                    </button>

                </h5>
                <div id="collapsePanel" class="card-body">

                    <div class="row">
                        <div class="col-md-3">
                            <div>Doctors</div>
                            {!! Form::select('doctors[]', app(\App\Methods\GeneralMethods::class)->getAllPrivateDoctors(), null, ['id' => 'doctors', 'class' => 'form-control select2_class_doctor', 'multiple' => 'multiple']); !!}
                        </div>

                        <div class="col-md-3">
                            <div>Specialties</div>
                            {!! Form::select('specialties[]', app(\App\Methods\GeneralMethods::class)->getAllSpecialties(), null, ['id' => 'specialties','class' => 'form-control select2_class_specialties', 'multiple' => 'multiple']); !!}
                        </div>

                        <div class="col-md-3">
                            <div>Countries</div>
                            {!! Form::select('countries[]', app(\App\Methods\GeneralMethods::class)->getAllCountries(), null, ['id' => 'countries','class' => 'form-control select2_class_countries', 'multiple' => 'multiple']); !!}
                        </div>

                        <div class="col-md-3">
                            <div>City</div>
                            {!!  html()->text('city')
                                ->id('city')
                                ->class('form-control')
                                ->placeholder('City')
                                ->autofocus()  !!}
                        </div>
                    </div>

                </div>
            </div>

            <div class="load-table">

            </div>

        </div><!--card-body-->
    </div><!--card-->


    <script type="application/javascript">


        $(document).ready(function () {

            $('.select2_class_doctor').select2({
                placeholder: "Select Doctor",
            });

            $('.select2_class_clinic').select2({
                placeholder: "Select Clinic",
            });

            $('.select2_class_specialties').select2({
                placeholder: "Select Specialties",
            });

            $('.select2_class_countries').select2({
                placeholder: "Select Countries",
            });

            $('.load-table').load('{{route('admin.private-doctor.index')}}?view=true', function () {
                intDeleteButton();
            });

            let body = $('body');

            body.on('click', '#search_btn', function (e) {

                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{route('admin.private-doctor.index')}}?view=true",
                    data: {
                        doctors: $("#doctors").val(),
                        clinics: $("#clinics").val(),
                        specialties: $("#specialties").val(),
                        countries: $("#countries").val(),
                        city: $("#city").val(),
                    },
                    success: function (result) {
                        $('.load-table').html(result);
                        intDeleteButton();
                    },
                    error: function (result) {
                    }
                });

            });


            body.on('click', '.change_status_button', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');
                $.ajax({
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    url: url,
                    success: function (result) {
                        $('#search_btn').click();
                    },
                    error: function (result) {
                    }
                });

            });

        });


    </script>

    <style>
        .float_right {
            float: right;
            margin-left: 3px;
        }
    </style>


@endsection


