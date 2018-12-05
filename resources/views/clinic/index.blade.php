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

            <div class="col-sm-7 pull-right">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                    <a href="{{ route('admin.clinic.create') }}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('labels.general.create_new')"><i class="fas fa-plus-circle"></i></a>
                </div>

            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Doctors</th>
                            <th>@lang('labels.general.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clinics as $clinic)
                            <tr>
                                <td>{{ ucwords($clinic->name) }}</td>
                                <td>{!! badges(array_pluck($clinic->doctors()->selectRaw('CONCAT(first_name, " ", last_name) as full_name_value')->get('full_name_value')->toArray(),'full_name_value'))!!}</td>
                                <td>{!! $clinic->action_buttons !!}</td>
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
                    {{ $clinics->total() }} clinics total
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
{{--                    {!! $clinic->render() !!}--}}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
