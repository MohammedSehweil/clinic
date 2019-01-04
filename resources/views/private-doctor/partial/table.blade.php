<div class="row mt-4">
    <div class="col">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Specialties</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>Approved</th>
                    <th>@lang('labels.general.actions')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($privateDoctors as $privateDoctor)
                    <tr>
                        <td>{{ ucwords($privateDoctor->name) }}</td>
                        <td>{!! badges($privateDoctor->specialties()->pluck('specialties.name')->toArray()) !!}</td>
                        <td>{{ $privateDoctor->country->name }}</td>
                        <td>{{ $privateDoctor->city }}</td>
                        <td>{!! $privateDoctor->approved ? badges(['YES']): badges(['NO'], 'danger')!!}</td>
                        <td>{!! $privateDoctor->action_buttons !!}</td>
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
            {{ $privateDoctors->total() }} private doctors total
        </div>
    </div><!--col-->

    <div class="col-5">
        <div class="float-right">
            {{--                    {!! $privateDoctor->render() !!}--}}
        </div>
    </div><!--col-->
</div><!--row-->