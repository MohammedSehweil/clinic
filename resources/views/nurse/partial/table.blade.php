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
                @foreach($nurses as $nurse)
                    <tr>
                        <td>{{ ucwords($nurse->name) }}</td>
                        <td>{!! badges($nurse->specialties()->pluck('specialties.name')->toArray()) !!}</td>
                        <td>{{ $nurse->country->name }}</td>
                        <td>{{ $nurse->city }}</td>
                        <td>{!! $nurse->approved ? badges(['YES']): badges(['NO'], 'danger')!!}</td>
                        <td>{!! $nurse->action_buttons !!}</td>
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
            {{ $nurses->total() }} Nurses total
        </div>
    </div><!--col-->

    <div class="col-5">
        <div class="float-right">
            {{--                    {!! $nurse->render() !!}--}}
        </div>
    </div><!--col-->
</div><!--row-->