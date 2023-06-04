@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Categories</h2>
            </div>
            
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            
            <th width="280px">Action</th>
        </tr>
	    @foreach ($categories as $category)
        
	    <tr>
	        <td>{{ ++$i }}</td>
            <td>{{ $category->cat_name }}</td>
	        <td>
            <a class="btn btn-info" href="/orders/{{$category->id}}/edit">Add Order</a>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $categories->links() !!}


<p class="text-center text-primary"><small>Tutorial by edutechsolutions</small></p>
@endsection