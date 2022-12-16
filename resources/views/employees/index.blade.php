@include('layout.main')
@include('flash')
<a href="{{ route('logout') }}">LOGOUT </a><br>
<h2>Welcome {{Auth::user()->fullname }}</h2>
<form action="{{ route('attendance.store') }}" method="Post">
    @csrf
    <label>Mark Your Attendance </label>
    <input type="submit" name="attendance" value="present" class="btn btn-secondary">
</form>

<form action="{{ route('leave.store') }}" method="post">
    @csrf
    <label>TITLE</label>
    <input type="text" name="title" placeholder=" subject..." value="{{ old('title') }}" required>
    @error('title')
    {{ $message }}
    @enderror
    <label>DESCRIPTION</label>
    <textarea name="des"  placeholder="add description " value="{{ old('des') }}" required></textarea>
    @error('des')
    {{ $message }}
    @enderror
    <label>Enter date for leave</label>
    <input type="date" name="leave" required>
    @error('leave')
    {{ $message }}
    @enderror
    <input type="submit" value="leave" class="btn btn-secondary">
</form>
<h4>LEAVE DETAILS </h4>
<table class="table table-success table-striped">
    <tr>
        <th>DATE</th>
        <th>SUBJECT</th>
        <th>STATUS</th>
</tr>
@foreach(Auth::user()->TotalLeaves as $leave)  
<tr> 
    <td>{{ $leave->leave_on}}</td>
    <td>{{ $leave->subject}}</td>
    <td>{{ $leave->status}}</td>
@endforeach
</tr>
</table>