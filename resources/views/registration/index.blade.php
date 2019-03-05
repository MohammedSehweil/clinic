@extends('backend.layouts.app')

@section('title', app_name() . ' | '. __('labels.backend.access.roles.management'))

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Registration Management
                    </h4>
                </div>
            </div>
            <br>
            <div class="container">
                <div class="row">

                    <a href="{{route('admin.registration.show', ['type' => 'clinic'])}}">
                        <div class="card mr-4" style="width: 16rem;">
                            <img class="card-img-top"
                                 src="https://static1.squarespace.com/static/5500b6e2e4b0e46bd2e53641/t/56ce38127da24f587ace9075/1539282514846/Clinic+In+A+Can+ENT%2FOBGYN%2FProcedure+suite"
                                 height="180px"
                                 alt="Clinic image">
                            <div class="card-body">
                                <h5 class="card-text text-center">Clinics</h5>
                            </div>

                        </div>
                    </a>

                    <a href="{{route('admin.registration.show', ['type' => 'lab'])}}">
                        <div class="card mr-4" style="width: 16rem;">
                            <img class="card-img-top"
                                 src="http://www.mandel.ca/UserFiles/Images/Category/LabStartUp_396x264.jpg"
                                 height="180px"
                                 alt="Lab image">
                            <div class="card-body">
                                <h5 class="card-text text-center">Labs</h5>
                            </div>
                        </div>
                    </a>

                    <a href="{{route('admin.registration.show', ['type' => 'private-doctor'])}}">
                        <div class="card mr-4" style="width: 16rem;">
                            <img class="card-img-top"
                                 src="https://www.kevinmd.com/blog/wp-content/uploads/shutterstock_154662227.jpg"
                                 height="180px"
                                 alt="Private Doctor image">
                            <div class="card-body">
                                <h5 class="card-text text-center">Private Doctor</h5>
                            </div>
                        </div>
                    </a>

                    <a href="{{route('admin.registration.show', ['type' => 'nurse'])}}">
                        <div class="card mr-4" style="width: 16rem;">
                            <img class="card-img-top"
                                 src="https://www.princetonhcs.org/-/media/images/healthcare-professionals/nurses/nurses-465702013-1280w.jpg?la=en&hash=F2023316458E493FFBD011031F66D4F50F32F7D8"
                                 height="180px"
                                 alt="Nurse image">
                            <div class="card-body">
                                <h5 class="card-text text-center">Nurses</h5>
                            </div>
                        </div>
                    </a>
                </div>


            </div>
        </div>
    </div>





@endsection


