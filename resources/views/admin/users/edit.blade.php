@include('layout.main')
<form action="{{ route('users.update' ,$user) }}" method="POST">
    @csrf
    <label>FIRST NAME</label>
    <input type="text" name="firstname" value="{{ $user->firstname }}" required>
    @error('firstname')
    {{ $message }}
    @enderror
    <label>LAST NAME</label>
    <input type="text" name="lastname" value="{{ $user->lastname }}" required>
    @error('lastname')
    {{ $message }}
    @enderror
    <label>EMAIL</label>
    <input type="email" name="email" value="{{ $user->email }}" required>
    @error('email')
    {{ $message }}
    @enderror
    <input type="submit" name="submit" class="btn btn-secondary"> 
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" >CANCEL</a>
</form>