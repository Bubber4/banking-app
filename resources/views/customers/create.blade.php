@include('layouts.header')


<h2>Create a new customer</h2>

@include('layouts.form_messages')


<form method="post" action="{{route('customer.store')}}">
    @csrf
    First name: <input type="text" name="first_name" value="{{ old('first_name') }}"></input> <br>
    Last name:<input type="text" name="last_name" value="{{ old('last_name') }}"></input> <br>
    Balance:<input type="text" name="balance" value="{{ old('balance') }}"></input> [defaults to 0 if empty]<br>
    Birth:<input type="date" name="birth" value="{{ old('birth') }}"></input> <br>
    Phone:<input type="text" name="phone" value="{{ old('phone') }}"></input> <br>
    Email:<input type="text" name="email" value="{{ old('email') }}"></input> <br>
    Branch:
        <select name="branch_id">
            <option></option>
        	@foreach ($branches as $branch)
                @if (old('branch_id') == $branch->id)
                    <option value="{{$branch->id}}" selected>{{$branch->name}}</option>
                @else
                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                @endif
            @endforeach
        </select> <br/>
    GDPR:<input type="checkbox" name="gdpr_compliant[]" value="1" {{ (is_array(old('gdpr_compliant')) and in_array(1, old('gdpr_compliant'))) ? ' checked' : '' }}></input> <br>
    <input type="submit" value="Save">
</form>


@include('layouts.form_notes')

@include('layouts.footer')