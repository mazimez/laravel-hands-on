<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Created at</th>
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
