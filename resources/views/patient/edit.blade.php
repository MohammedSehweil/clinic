@extends('backend.layouts.app')


@section('content')
    {{ html()->modelForm($patient, 'PATCH', route('admin.patient.update', $patient))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Patient Management
                        <small class="text-muted">Edit Patient</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->
            <!--row-->

            <hr/>


            <div class="row mt-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label('First Name')
                            ->class('col-md-2 form-control-label')
                            ->for('first_name') }}

                        <div class="col-md-5">
                            {{ html()->text('first_name')
                                ->class('form-control')
                                ->placeholder('First Name')
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div>


                    <div class="form-group row">
                        {{ html()->label('Second Name')
                            ->class('col-md-2 form-control-label')
                            ->for('name') }}

                        <div class="col-md-5">
                            {{ html()->text('last_name')
                                ->class('form-control')
                                ->placeholder('Second Name')
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div>


                    <div class="form-group row">
                        {{ html()->label('Email')
                            ->class('col-md-2 form-control-label')
                            ->for('email') }}

                        <div class="col-md-5">
                            {{ html()->text('email')
                                ->class('form-control')
                                ->placeholder('Email')
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div>


                    @if(isCurrentUser($patient->id))

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.access.users.password'))->class('col-md-2 form-control-label')->for('password') }}


                            <div class="col-md-5">
                                {{ html()->password('password')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.backend.access.users.password'))
                                    ->required()
                                    ->value('')
                                    }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.access.users.password_confirmation'))->class('col-md-2 form-control-label')->for('password_confirmation') }}

                            <div class="col-md-5">
                                {{ html()->password('password_confirmation')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.backend.access.users.password_confirmation'))
                                    ->required()
                                    ->value('')
                                    }}
                            </div><!--col-->
                        </div><!--form-group-->

                    @endif

                    <div class="form-group row">
                        {{ html()->label('Phone Number')
                            ->class('col-md-2 form-control-label')
                            ->for('phone') }}

                        <div class="col-md-5">
                            {{ html()->text('phone')
                                ->class('form-control')
                                ->placeholder('Phone Number')
                                ->attribute('maxlength', 191)
                                ->autofocus() }}
                        </div><!--col-->
                    </div>



                    <!--form-group-->

                </div><!--col-->
            </div>
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.patient.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.update')) }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
    {{ html()->closeModelForm() }}
@endsection
