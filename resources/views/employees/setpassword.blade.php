@include('layout.main')
    <h4>SET-PASSWORD</h4>
    <form action="{{ route('password.store', $user) }}" method="POST">
        @csrf
    <input type="textbox" name="email" value="{{ $user->email }}" hidden>
    <label>PASSWORD</label>
    <input type="password" name="password" placeholder="enter your password" required>
    @error('password')
    {{ $message }}
    @enderror
    <label>CONFIRM-PASSWORD</label>
    <input type="password" name="confirm_password" placeholder="enter your password" required>
    @error('confirm_password')
    {{ $message }}
    @enderror
    <input type="submit" name="submit">
</body>
</html>