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

<script type="application/javascript">


    $(document).ready(function () {

        let body = $('body');

        body.on('click', '.select_all', function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

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

        $('.load-table').load('{{route('admin.clinic.index')}}?view=true', function () {
            intDeleteButton();
        });


        body.on('click', '#search_btn', function (e) {

            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{route('admin.clinic.index')}}?view=true",
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

    .select2-container {
        width: 100% !important;
    }

</style>
