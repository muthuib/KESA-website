@if($users->isNotEmpty())
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>

                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->FIRST_NAME }} {{ $user->LAST_NAME }}</td>
                    <td>{{ $user->EMAIL }}</td>
                    <td>
                        <a href="{{ route('users.assignRolesForm', $user->ID) }}" class="btn btn-success btn-sm">Assign Roles</a>
                        <a href="{{ route('users.show', $user->ID) }}" class="btn btn-info btn-sm">View</a>
                        <!-- <a href="{{ route('users.edit', $user->ID) }}" class="btn btn-warning btn-sm">Edit</a> -->
                        <form action="{{ route('users.destroy', $user->ID) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p class="text-muted text-center">No users in this category.</p>
@endif
