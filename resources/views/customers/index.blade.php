@include('layouts.header')


<h2>List of all the CUSTOMERS</h2>

<table>
    <tr>
        <th>Name</th>
        <th>Balance</th>
        <th>Birth</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Branch</th>
        <th>GDPR</th>
        <th>Customer since</th>
        <th>Actions</th>
    </tr>
	@foreach ($customers as $customer)
        <tr>
		    <td>{{ $customer->last_name . ', ' . $customer->first_name }}</td>
            <td>{{ $customer->balance }}</td>
            <td>{{ $customer->birth }}</td>
            <td>{{ $customer->phone }}</td>
            <td>{{ $customer->email }}</td>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->gdpr_compliant }} [Yes]</td>
            <td>{{ $customer->created_at }}</td>
            <td>
                <a href="{{ route('customer.edit', $customer->id) }}" style="color:cornflowerblue">Edit</a>
                <form action="{{ route('customer.destroy', $customer->id) }}" method="post" style="display:inline">
                    @csrf
                    @method('delete')
                    <input type="submit" onclick="return confirm('Are you sure?')" style="color:crimson" value="Remove" />
                </form>
                <a href="{{ route('customer.transfer', $customer->id) }}" style="color:lime">Send money to...</a>
            </td>
        </tr>
	@endforeach
</table>

@include('layouts.footer')