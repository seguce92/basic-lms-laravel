@extends('layouts.sidebar')
@section('content')
    @if(Session::has('invalid_access_code'))
        <div class="alert alert-danger">
            <p>@lang('module.errors.error-access-code')</p>
        </div>
    @endif
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('module.courses.enroll-course')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped" id="{{ count($courses) > 0 ? 'datatable' : '' }}">
                <thead>
                <tr>
                    <th>@lang('module.courses.relation-title')</th>
                    <th>@lang('module.users.registered-users')</th>
                    <th>@lang('module.created_at')</th>
                    <th>@lang('module.operations')</th>
                </tr>
                </thead>

                <tbody>
                @if( count($available_courses ) > 0)
                    @foreach($available_courses as $course)
                        <tr data-entry-id="{{ $course->id }}">
                            <td>{{ $course->title }}</td>
                            <td>{{ count($course->users) }}</td>
                            <td>{!! $course->created_at !!}</td>
                            <td>
                                <button class="btn btn-xs btn-danger" id="enroll{{$course->id}}"
                                        onclick="enroll({{$course->id}})">@lang('module.courses.enroll-course')</button>
                                <div id="register{{$course->id}}" style="display:none;">
                                    {{ Form::open(['method' => 'POST', 'route' => 'enroll.store']) }}
                                    {{ Form::hidden('course_id', $course->id, array('id' => 'course_id')) }}
                                    {!! Form::input('text','access_code', old('access_code'), ['required', 'placeholder' => trans('module.courses.fields.access_code')]) !!}
                                    {{ Form::submit(Lang::get('module.save'), ['class' => 'btn-xs btn btn-info']) }}
                                    {!! Form::close() !!}
                                </div>
                            </td>

                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">@lang('module.no_entries_in_table')</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable({
                responsive: true
            });
        });
    </script>
    <script>
        function enroll(id) {
            $("#register" + id).toggle(500);
        }
    </script>
@endsection