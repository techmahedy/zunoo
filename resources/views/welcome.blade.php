@if (session()->has('errors'))
    @foreach (session()->get('errors') as $error)
        @foreach ($error as $item)
            <li>{{ $item }}</li>
        @endforeach
    @endforeach
@endif

<form action="/" method="post">

    <label class="form-label">Name</label>
    <input type="text" name="first_name" class="" value="">

    <label class="form-label">Last Name</label>
    <input type="text" name="last_name" class="" value="">

    <label class="form-label">Address</label>
    <input type="text" name="address" class="" value="">

    <label class="form-label">Email</label>
    <input type="email" name="email" class="" value="">

    <button type="submit" class="btn btn-primary">Submit</button>

</form>
