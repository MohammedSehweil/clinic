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
                                <input class="form-control" id="name" type="text" placeholder="Enter your Name" required>
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
                            <div class="form-group">

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



        </div>
    </div>





@endsection


