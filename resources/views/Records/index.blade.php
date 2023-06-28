@extends('records.layout')
     
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
        
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('records.create') }}"> Create New records</a>
            </div>
        </div>
    </div>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
     
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Image</th>
            <th>Name</th>
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($records as $records)
        <tr>
            <td>{{ ++$i }}</td>
            <td><img src="/image/{{ $records->image }}" width="100px"></td>
            <td>{{ $records->name }}</td>
            <td>{{ $records->email }}</td>
            <td>
                <form action="{{ route('records.destroy',$records->id) }}" method="POST">
     
                    <a class="btn btn-info" href="{{ route('records.show',$records->id) }}">Show</a>
      
                    <a class="btn btn-primary" href="{{ route('records.edit',$records->id) }}">Edit</a>
     
                    @csrf
                    @method('DELETE')
        
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    
  
        
@endsection