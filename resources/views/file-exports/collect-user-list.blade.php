<div class="row">
    <div class="col-lg-12 text-center">
        <h1>List Of Users</h1>
    </div>
    <div class="col-lg-12">
        <table>
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Ref ID</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $key => $user)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $user->f_name ?? '' }}</td>
                    <td>{{ $user->username ?? '' }}</td>
                    <td>{{ $user->phone ?? '' }}</td>
                    <td>{{ $user->email ?? '' }}</td>
                    <td>{{ $user->ref_by ?? '' }}</td>
                    <td>{{ $user->status == 1 ? "active" :'Inactive' }}</td>
                    <td>{{ $user->created_at ? $user->created_at->format('Y-m-d '.config('timeformat')) : '' }}</td>
                    <td>{{ $user->updated_at ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
