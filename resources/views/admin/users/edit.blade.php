@include('layout.main')
<form action="{{ route('users.update' ,$user) }}" method="POST">
    @csrf
    <label>FIRST NAME</label>
    <input type="textbox" name="firstname" value="{{ $user->firstname }}" required>
    @error('firstname')
    {{ $message }}
    @enderror
    <label>LAST NAME</label>
    <input type="textbox" name="lastname" value="{{ $user->lastname }}" required>
    @error('lastname')
    {{ $message }}
    @enderror
    <label>EMAIL</label>
    <input type="email" name="email" value="{{ $user->email }}" required>
    @error('email')
    {{ $message }}
    @enderror
    <input type="submit" name="submit"> 
   
</form>