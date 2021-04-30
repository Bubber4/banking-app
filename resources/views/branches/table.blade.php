<table>
    <tr>
        <th>Name</th>
        <th>Address</th>
        <th>City</th>
        <th>Country</th>
        <th>Postcode</th>
        <th>Total balance</th>
        <th>Total customers</th>
        <th>Available since</th>
        <th>Actions</th>
    </tr>
	@foreach ($branches as $branch)
        <tr>
		    <td>{{ $branch->name }}</td>
            <td>{{ $branch->address }}</td>
            <td>{{ $branch->city }}</td>
            <td>{{ $branch->country }}</td>
            <td>{{ $branch->postcode }}</td>
            <td>{{ $branch->total_balance }}</td>
            <td>{{ $branch->total_customers }}</td>
            <td>{{ $branch->created_at }}</td>
            <td>
                <a href="{{ route('branch.edit', $branch->id) }}" style="color:cornflowerblue">Edit</a>
                <form action="{{ route('branch.delete', $branch->id) }}" method="post" style="display:inline">
                    @csrf
                    @method('delete')
                    <input type="submit" onclick="return confirm('Are you sure?')" style="color:crimson" value="Remove" />
                </form>
            </td>
        </tr>
	@endforeach
</table>