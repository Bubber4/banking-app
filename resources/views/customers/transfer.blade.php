@include('layouts.header')


<h2>Transfer balance</h2>

<p>Currently making a transfer from customer {{ $customer->first_name . ' ' .  $customer->last_name }} | id: {{ $customer->id }} <br>
Balance availble to transfer: {{ $customer->balance }}
</p>

@include('layouts.form_messages')


<form method="post" action="{{ route('customer.transfer', $customer->id) }}">
    @csrf
    Amount to send: <input type="text" name="amount" value="{{ old('amount', '0') }}"> <br>
    Recipient: 
        <select name="recipient_customer_id">
            <option></option>
            @foreach ($customers as $customer)
                @if (old('recipient_customer_id') == $customer->id)
                    <option value="{{$customer->id}}" selected>{{$customer->first_name . ' ' .  $customer->last_name}} | id: {{ $customer->id }}</option>
                @else
                    <option value="{{$customer->id}}">{{$customer->first_name . ' ' .  $customer->last_name}} | id: {{ $customer->id }}</option>
                @endif
            @endforeach
        </select> <br>
    <input type="submit" value="Confirm transaction" onclick="return confirm('Do you want to proceed with the transaction?')">
</form>


@include('layouts.form_notes')

@include('layouts.footer')