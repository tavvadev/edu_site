@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Forgot Question</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="/forgotquestion">
                        @csrf

                       
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end"><?php if(isset($question[0]->name) && $question[0]->name!=""){ echo $question[0]->name;} ?></label>

                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Answer</label>

                            <div class="col-md-6">
                                <input id="user_id" type="hidden" class="form-control" name="user_id" value="<?php if(isset($userAnswers[0]->user_id) && $userAnswers[0]->user_id!=""){ echo $userAnswers[0]->user_id;} ?>"  >
                               
                                <input id="user_answer" type="text" class="form-control @error('user_answer') is-invalid @enderror" name="user_answer" value=""  >

                                @error('user_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
