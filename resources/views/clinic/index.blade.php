@extends('backend.layouts.app')

@section('title', app_name() . ' | '. __('labels.backend.access.roles.management'))

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Clinic Management
                    </h4>
                </div><!--col-->

                @if(isAdmin() or isOwner())
                    <div class="col-sm-7 pull-right">
                        <div class="btn-toolbar float-right" role="toolbar"
                             aria-label="@lang('labels.general.toolbar_btn_groups')">
                            <a href="{{ route('admin.clinic.create') }}" class="btn btn-success ml-1"
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
                            {!! Form::select('doctors[]', app(\App\Methods\GeneralMethods::class)->getAllDoctors(), null, ['id' => 'doctors', 'class' => 'form-control select2_class_doctor', 'multiple' => 'multiple']); !!}
                        </div>

                        <div class="col-md-3">
                            <div>Clinics</div>
                            {!! Form::select('clinics[]', app(\App\Methods\GeneralMethods::class)->getAllClinics(), null, ['id' => 'clinics','class' => 'form-control select2_class_clinic', 'multiple' => 'multiple']); !!}
                        </div>

                        <div class="col-md-3">
                            <div>Specialties</div>
                            {!! Form::select('specialties[]', app(\App\Methods\GeneralMethods::class)->getAllSpecialties(), null, ['id' => 'specialties','class' => 'form-control select2_class_specialties', 'multiple' => 'multiple']); !!}
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

            $('.load-table').load('{{route('admin.clinic.index')}}?view=true', function () {
                intDeleteButton();
            });


            $('body').on('click', '#search_btn', function (e) {

                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{route('admin.clinic.index')}}?view=true",
                    data: {
                        doctors: $("#doctors").val(),
                        clinics: $("#clinics").val(),
                        specialties: $("#specialties").val(),
                    },
                    success: function (result) {
                        $('.load-table').html(result);
                        intDeleteButton();
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


