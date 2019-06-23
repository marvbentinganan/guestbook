@extends('layouts.app')
@section('page_style')

@endsection

@section('content')
    <div class="text-center p-10">
        <h1>Guests</h1>
    </div>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <table class="table table-striped table-bordered">
        <thead>
            <th class="text-center align-middle">#</th>
            <th class="text-center align-middle">Firstname</th>
            <th class="text-center align-middle">Lastname</th>
            <th class="text-center align-middle">Email</th>
            <th class="text-center align-middle">Phone Number</th>
            <th class="text-center align-middle">Gender</th>
            <th class="text-center align-middle">Address</th>
            <th class="text-center align-middle" style="width:150px;">
                <a href="{{ route('guest.create') }}" class="btn btn-primary btn-sm">Add Guest</a>
            </th>
        </thead>
        <tbody>
            @if($guests->count() == 0)
            <tr>
                <td class="text-center" colspan="8">No Guests Found</td>
            </tr>
            @else
            @foreach ($guests as $key => $guest)
            <tr>
                <td class="text-center">{{ ++$key }}</td>
                <td>{{ $guest->first_name }}</td>
                <td>{{ $guest->last_name }}</td>
                <td>{{ $guest->email }}</td>
                <td class="text-center">{{ $guest->phone_number }}</td>
                <td class="text-center">{{ ucwords($guest->gender) }}</td>
                <td>{{ $guest->address }}</td>
                <td>
                    <a href="{{ route('guest.edit', $guest->id) }}" class="btn btn-info btn-sm">Update</a>
                    <a class="btn btn-danger btn-sm" onclick="confirm({{ $guest->id }})">Delete</a>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
@endsection

@section('page_scripts')
    <script>
        function confirm(id){
            swal.fire({
            title: 'Are you sure?',
            text: 'This will delete guest data',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, delete it!',
            html: false,
            showLoaderOnConfirm: true,
        }).then(result => {
            if (result.value) {
                axios.delete('/guests/' + id + '/delete')
                    .then(response => {
                        swal.fire('Deleted', response.data, 'success');
                        window.location.reload();
                    });
            }
        })
        }
    </script>
@endsection