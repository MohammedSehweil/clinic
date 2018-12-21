@extends('backend.layouts.app')

@section('title', app_name() . ' | '. __('labels.backend.access.roles.management'))

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Doctor Management
                    </h4>
                </div><!--col-->

                <div class="col-sm-7 pull-right">
                    @if(isAdmin() or isOwner())
                        <div class="btn-toolbar float-right" role="toolbar"
                             aria-label="@lang('labels.general.toolbar_btn_groups')">
                            <a href="{{ route('admin.doctor.create') }}" class="btn btn-success ml-1"
                               data-toggle="tooltip"
                               title="@lang('labels.general.create_new')"><i class="fas fa-plus-circle"></i></a>
                        </div>
                    @endif

                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Clinic Name</th>
                                <th>Specialties</th>
                                <th>@lang('labels.general.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($doctors as $doctor)
                                <tr>
                                    <td>{{ ucwords($doctor->name) }}</td>
                                    <td>{!! $doctor->email !!}</td>
                                    <td>{!! $doctor->phone ?? '-' !!}</td>
                                    <td>{!! badges(app(\App\Methods\DoctorMethods::class)->getDoctorClinics($doctor))!!}</td>
                                    <td>{!! badges(app(\App\Methods\DoctorMethods::class)->getDoctorSpecialties($doctor))!!}</td>
                                    <td>{!! $doctor->action_buttons !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!--col-->
            </div><!--row-->
            <div class="row">
                <div class="col-7">
                    <div class="float-left">
                        {{ $doctors->total() }} doctors total
                    </div>
                </div><!--col-->

                <div class="col-5">
                    <div class="float-right">
                        {{--                    {!! $doctor->render() !!}--}}
                    </div>
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->
    </div><!--card-->
@endsection
