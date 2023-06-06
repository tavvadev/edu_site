@extends('layouts.master')




@section('content')
<div class="main-bg">
<div class="container pt-5 pb-4">
    <div class="row">
                <h2 class="fw-bold fs-3 pb-3 title-clr ">Categories</h2>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif

    <div class="row">
    @foreach ($categories as $category)
        <div class="col-md-3">
<div class="card cat-crd ">
    <div class="circle">
        F
    </div>
<h2 class="pt-4">{{ $category->cat_name }}</h2>



<a class="btn btn-primary " role="button"  href="/orders/{{$category->id}}/edit">Add Order</a>

</div>
        </div>
        @endforeach
    </div>
    {!! $categories->links() !!}
<p class="text-center text-primary"><small>Tutorial by edutechsolutions</small></p>
</div>
</div>
@endsection
