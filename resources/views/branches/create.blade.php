@include('layouts.header')


<h2>Create a new branch</h2>

@include('layouts.form_messages')


<form method="post">
    @csrf
    Branch name: <input type="text" name="name" value="{{ old('name') }}"></input> <br>
    Address: <input type="text" name="address" value="{{ old('address') }}"></input> <br>
    City: <input type="text" name="city" value="{{ old('city') }}"></input> <br>
    Country: <input type="text" name="country" value="{{ old('country') }}"></input> <br>
    Postcode: <input type="text" name="postcode" value="{{ old('postcode') }}"></input> <br>
    <input type="submit" value="Save">
</form>


@include('layouts.form_notes')

@include('layouts.footer')
