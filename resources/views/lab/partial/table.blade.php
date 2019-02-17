<div class="row mt-4">
    <div class="col">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Specialties</th>
                    <th>Doctors</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>Approved</th>
                    <th>@lang('labels.general.actions')</th>
                </tr>

                <tbody>
                @foreach($labs as $lab)
                    <tr>
                        <td>{{ ucwords($lab->name) }}</td>
                        <td>{!! badges($lab->specialties()->pluck('specialties.name')->toArray()) !!}</td>
                        <td>{!! badges(app(\App\Methods\ClinicMethods::class)->getClinicDoctors($lab), 'primary')!!}</td>
                        <td>{{ $lab->country->name }}</td>
                        <td>{{ $lab->city }}</td>
                        <td>{!! $lab->approved ? badges(['YES']): badges(['NO'], 'danger')!!}</td>
                        <td>{!! $lab->action_buttons !!}</td>
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
            {{ $labs->total() }} labs total
        </div>
    </div><!--col-->

    <div class="col-5">
        <div class="float-right">
            {{--                    {!! $lab->render() !!}--}}
        </div>
    </div><!--col-->
</div><!--row-->