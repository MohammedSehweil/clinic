@extends('backend.layouts.app')


@section('content')
    {{ html()->modelForm($clinic, 'PATCH', route('admin.clinic.update', $clinic))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Clinic Management
                        <small class="text-muted">Edit Clinic</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->
            <!--row-->

            <hr/>

            <div class="row mt-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.access.roles.name'))
                            ->class('col-md-2 form-control-label')
                            ->for('name') }}

                        <div class="col-md-4">
                            {{ html()->text('name')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.access.roles.name'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Add Specialties')
                            ->class('col-md-2 form-control-label')
                            ->for('specialties') }}

                        <div class="col-md-4">
                            {!! Form::select('specialties[]', app(\App\Methods\GeneralMethods::class)->getAllSpecialties(), app(\App\Methods\ClinicMethods::class)->getClinicSpecialties($clinic), ['id' => 'specialties', 'class' => 'form-control select2_class_specialties', 'multiple' => 'multiple']); !!}
                        </div><!--col-->
                    </div>


                </div><!--col-->


            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.clinic.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.update')) }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
    {{ html()->closeModelForm() }}


    <script type="application/javascript">

        $(document).ready(function () {
            $('.select2_class_specialties').select2({
                placeholder: "Select Specialties",
                tags: true
            });
        });
    </script>



@endsection
