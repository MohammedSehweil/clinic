<div class="row mt-4">
    <div class="col">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Specialties</th>
                    <th>Doctors</th>
                    <th>Approved</th>
                    <th>@lang('labels.general.actions')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($clinics as $clinic)
                    <tr>
                        <td>{{ ucwords($clinic->name) }}</td>
                        <td>{!! badges($clinic->specialties()->pluck('specialties.name')->toArray()) !!}</td>
                        <td>{!! badges(app(\App\Methods\ClinicMethods::class)->getClinicDoctors($clinic), 'primary')!!}</td>
                        <td>{!! $clinic->approved ? badges(['YES']): badges(['NO'], 'danger')!!}</td>
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