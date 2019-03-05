<div class="row mt-4">
    <div class="col">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input select_all" type="checkbox" value="on">
                            <label class="form-check-label" for="inline-checkbox1"></label>
                        </div>
                    </th>
                    <th>Name</th>
                    <th>Specialties</th>
                    <th>Doctors</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>Approved</th>
                    <th>@lang('labels.general.actions')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($clinics as $clinic)
                    <tr>
                        <td>
                            <div class="form-check form-check-inline mr-1">
                                <input class="form-check-input row_checkbox" data-id="{{$clinic->id}}" type="checkbox"
                                       value="{{$clinic->id}}">
                            </div>
                        </td>
                        <td>{{ ucwords($clinic->name) }}</td>
                        <td>{!! badges($clinic->specialties()->pluck('specialties.name')->toArray()) !!}</td>
                        <td>{!! badges(app(\App\Methods\ClinicMethods::class)->getClinicDoctors($clinic), 'primary')!!}</td>
                        <td>{{ $clinic->country->name }}</td>
                        <td>{{ $clinic->city }}</td>
                        <td>{!! $clinic->approved ? badges(['YES']): badges(['NO'], 'danger')!!}</td>
                        <td>{!! $clinic->action_buttons !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-7">
        <div class="float-left">
            {{ $clinics->total() }} clinics total
        </div>
    </div>

    <div class="col-5">
        <div class="float-right">
        </div>
    </div>
</div>