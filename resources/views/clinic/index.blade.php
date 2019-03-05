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
                </div>

                @if(isAdmin() or isOwner())
                    <div class="col-sm-7 pull-right">
                        <div class="btn-toolbar float-right" role="toolbar"
                             aria-label="@lang('labels.general.toolbar_btn_groups')">
                            <a href="{{ route('admin.clinic.create') }}" class="btn btn-success ml-1"
                               data-toggle="tooltip" title="@lang('labels.general.create_new')"><i
                                        class="fas fa-plus-circle"></i></a>
                        </div>

                    </div>
                @endif
            </div>

            <br>

            @include('clinic.clinic_listing')

        </div>
    </div>



@endsection


