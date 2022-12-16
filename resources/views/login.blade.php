@include('layout.main')
@include('flash')
    <h4>LOGIN</h4>
    <form action="{{ route('login.check') }}" method="POST">
        @csrf
    <label>EMAIL</label>
    <input type="textbox" name="email" placeholder="enter your email" required>
    @error('email')
    {{ $message }}
    @enderror
    <label>PASSWORD</label>
    <input type="password" name="password" placeholder="enter your password" required>
    @error('password')
    {{ $message }}
    @enderror
    <input type="submit" name="submit" value="LOGIN">
</body>
</html>