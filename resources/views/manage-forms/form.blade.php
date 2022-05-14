@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Manage Forms') }}
                    <a href="{{__('create-form')}}" class="btn btn-sm btn-success" style="float: right;">Create Form </a>
                </div>
                <div class="card-body text-center">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                
                                <th scope="col">Form Name</th>
                                <th scope="col">How Many Times Submitted</th>
                                <th scope="col">How Many Times Opened</th>
                                <th scope="col">User Submitted Answers</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($forms_array))
                            @foreach($forms_array as $form)
                            <tr>
                                <td>{{ $form['name'] }}</td>
                                <td>{{ $form['no_of_submit'] }}</td>
                                <td>{{ $form['no_of_view'] }}</td>
                                <td><a href="submitter-form/{{$form['id']}}">{{ $form['no_of_submit'] }}</a></td>
                                <td>
                                    <!-- <a href="" class="btn btn-success btn-sm">Edit</a> -->
                                    <a href="delete-form/{{$form['id']}}" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger btn-sm">Delete</a>
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