@include('layout.main')
<form action="{{ route('users.store') }}" method="POST">
    @csrf
    <label>FIRST NAME</label>
    <input type="textbox" name="firstname" value="{{ old('firstname') }}" required>
    @error('firstname')
    {{ $message }}
    @enderror
    <label>LAST NAME</label>
    <input type="textbox" name="lastname" value="{{ old('lastname') }}" required>
    @error('lastname')
    {{ $message }}
    @enderror
    <label>EMAIL</label>
    <input type="email" name="email" value="{{ old('email') }}" required>
    @error('email')
    {{ $message }}
    @enderror
    <label>Role</label>
        <select name="role_id" >
            <option value="{{ $role->id }}"> {{ $role->name }}</option>
        </select>
            @error('role_id')
            {{ $message }}
            @enderror
    <input type="submit" name="submit"> 
   
</form>