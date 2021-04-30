@include('layouts.header')


<h2>Edit a customer</h2>

<p>Currently editing customer {{ $customer->id }}</p>

@include('layouts.form_messages')


<form method="post" action="{{ route('customer.update', $customer->id) }}">
    @csrf
    @method('put')
    First name: <input type="text" name="first_name" value="{{ old('first_name', $customer->first_name) }}"></input> <br>
    Last name:<input type="text" name="last_name" value="{{ old('last_name', $customer->last_name) }}"></input> <br>
    Birth:<input type="date" name="birth" value="{{ old('birth', $customer->birth) }}"></input> <br>
    Phone:<input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"></input> <br>
    Email:<input type="text" name="email" value="{{ old('email', $customer->email) }}"></input> <br>
    <span style="color:red">Balance:<input type="text" name="balance" value="{{ old('balance', $customer->balance) }}"></input> [Just for the sake of making tests easier]</span><br>
    Branch:
        <select name="branch_id">
            <option></option>
        	@foreach ($branches as $branch)
                @if (old('branch_id', $customer->branch_id) == $branch->id)
                    <option value="{{$branch->id}}" selected>{{$branch->name}}</option>
                @else
                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                @endif
            @endforeach
        </select> <br/>
    <input type="submit" value="Save">
</form>


@include('layouts.form_notes')

@include('layouts.footer')