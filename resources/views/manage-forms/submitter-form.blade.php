@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Submit Forms') }}
                </div>
                <div class="card-body text-center">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">User</th>
                                <th scope="col">Form Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($submitter_form))
                            @foreach($submitter_form as $form)
                            <tr>
                                <td>{{ $form['submiiter_name'] }}</td>
                                <td>{{ $form['form_name'] }}</td>
                                <td>
                                    <a href="{{route('answer-form', ['id' => $form['form_id'],'user_id'=>$form['user_id']])}}" class="btn btn-primary btn-sm">See Answer</a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="2">
                                    No Records Found
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
