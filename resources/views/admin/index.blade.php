@include('layout.main')
@include('flash')
<h3>WELCOME ADMIN </h3> 
<a href="{{ route('logout') }}" >LOGOUT </a><br>
<a href="{{ route('users.create') }}">CREATE </a>
<table class="table table-success table-striped">
<tr>
    <th>
        FIRST NAME
    </th>
    <th>
        LAST NAME
    </th>
    <th>
        EMAIL
    </th>
    <th>
       EDIT 
    </th>
    <th>
        DELETE
    </th>
    <th>
        ATTENDANCE-DETAIL
    </th>
    <th>
        LEAVES
    </th>
</tr>
@foreach($users as $user)
    <tr>
    <td>{{ $user->firstname }}</td>
    <td>{{ $user->lastname }}</td>
    <td>{{ $user->email }}</td>
    <td><a href="{{ route('users.edit', $user) }}" class="btn btn-secondary">edit</a></td>
    <form action="{{ route('users.delete', $user) }}" method = "POST">
        @csrf
        @method('delete')
        <td><input type="submit"  name="delete" value="delete" class="btn btn-secondary"></td>
    </form>
    <td><a href="{{ route('users.attendance.show', $user) }}" class="btn btn-secondary">ATTENDENCE</a></td>
    @foreach($user->pendingLeaves as $leave)
    <td> 
        {{ $leave->leave }}
        <a href="{{ route('employees.leave.status.approved', [$user, $leave]) }}" class="btn btn-secondary">
            approved
        </a> 
        <a href="{{ route('employees.leave.status.rejected', [$user, $leave]) }}" class="btn btn-secondary">
            rejected 
        </a>
    </td>
    @endforeach
@endforeach