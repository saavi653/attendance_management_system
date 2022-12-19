@include('layout.main')
<h4>Attendance Detail Of {{ $user->fullname }} </h4>
<table class="table table-success table-striped">
    <tr>
    <th>
        DATE
    </th>
    <th>
        STATUS
    </th>
    </tr>
    <tr>
    @foreach($user->attendances as $attendance)
        <td>{{ $attendance->date }}</td>
        <td>{{ $attendance->status }}</td>
    </tr>
    @endforeach
</table>
<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" >CANCEL</a>
