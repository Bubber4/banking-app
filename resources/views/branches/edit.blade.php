@include('layouts.header')


<h2>Edit a branch</h2>

<p>Currently editing the branch {{ $branch->name }}</p>

@include('layouts.form_messages')


<form method="post" action="{{ route('branch.update', $branch->id) }}">
    @csrf
    @method('patch')
    Name: <input type="text" name="name" value="{{ old('name', $branch->name) }}"></input> <br>
    Address:<input type="text" name="address" value="{{ old('address', $branch->address) }}"></input> <br>
    City:<input type="text" name="city" value="{{ old('city', $branch->city) }}"></input> <br>
    Country:<input type="text" name="country" value="{{ old('country', $branch->country) }}"></input> <br>
    Postcode:<input type="text" name="postcode" value="{{ old('postcode', $branch->postcode) }}"></input> <br>
    <input type="submit" value="Save">
</form>


@include('layouts.form_notes')

@include('layouts.footer')