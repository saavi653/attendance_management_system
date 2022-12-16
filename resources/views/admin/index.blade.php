@include('layout.main')
@include('flash')
<a href="{{ route('logout') }}">LOGOUT </a><br>
<a href="{{ route('users.create') }}">CREATE </a>
<table>
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
        LEAVES_DATE
    </th>
</tr>
@foreach($users as $user)
    <tr>
    <td>{{ $user->firstname }}</td>
    <td>{{ $user->lastname }}</td>
    <td>{{ $user->email }}</td>
    <td><a href="{{ route('users.edit', $user) }}">edit</a></td>
    <form action="{{ route('users.delete', $user) }}" method = "POST">
        @csrf
        @method('delete')
        <td><input type="submit"  name="delete" value="delete"></td>
    </form>
    @foreach($user->leaves as $leave)
    <td> 
        {{ $leave->leave_on }}
        <a href="{{ route('employees.leave.status.approved', [$user, $leave]) }}">
            approved
        </a> 
        <a href="{{ route('employees.leave.status.rejected', [$user, $leave]) }}" >
            rejected 
        </a>
    </td>
    @endforeach
@endforeach