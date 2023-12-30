<table>
    <thead>
    <tr>
        <th><b>Name</b></th>
        <th><b>Email</b></th>
        <th><b>Phone Number</b></th>
        <th><b>Created at</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone_number }}</td>
            <td>{{ $user->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
