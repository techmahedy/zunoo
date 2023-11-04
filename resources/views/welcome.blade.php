{{-- <form action="/" method="post">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="{{ $user->hasError('name') ? ' is-invalid' : '' }}"
        value="{{ $user->name ?? '' }}">
    {{ $user->getErrorMessage('name') }}

    <label class="form-label">Email</label>
    <input type="text" class="{{ $user->hasError('email') ? ' is-invalid' : '' }}" name="email"
        value="{{ $user->email ?? '' }}">
    {{ $user->getErrorMessage('email') }}

    <label class="form-label">Password</label>
    <input type="password" class="{{ $user->hasError('password') ? ' is-invalid' : '' }}" name="password"
        value="{{ $user->password ?? '' }}">
    {{ $user->getErrorMessage('password') }}

    <label class="form-label">Confirm Password</label>
    <input type="password" class="{{ $user->hasError('confirm_password') ? ' is-invalid' : '' }}"
        name="confirm_password" value="{{ $user->confirm_password ?? '' }}">
    {{ $user->getErrorMessage('confirm_password') }}
    <button type="submit" class="btn btn-primary">Submit</button>
</form> --}}

<form action="/" method="post">

    <label class="form-label">Name</label>
    <input type="text" name="first_name" class=""
        value="">

    <label class="form-label">Email</label>
    <input type="text" name="email" class=""
        value="">

    <label class="form-label">Password</label>
    <input type="text" name="last_name" class=""
        value="">

    <label class="form-label">Confirm Password</label>
    <input type="text" name="address" class=""
        value="">

    <button type="submit" class="btn btn-primary">Submit</button>

</form>