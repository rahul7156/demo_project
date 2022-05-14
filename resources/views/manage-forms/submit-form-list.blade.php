@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Submit Forms') }}
                    <div style="float:right">
                        <a href="{{url('/create-form')}}" class="btn btn-sm btn-success">Create Form</a>
                    </div>
                </div>
                <div class="card-body text-center">
                    @if(session()->has('success') && session()->get('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session()->get('msg') }}
                    </div>
                    @endif
                    @if(session()->has('success') && session()->get('success') == false)
                    <div class="alert alert-danger" role="alert">
                        {{ session()->get('msg') }}
                    </div>
                    @endif
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Action</th>
                                <th scope="col">Form Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($forms))
                            @foreach($forms as $form)
                            <tr>
                                <td>{{ $form->name }}</td>
                                <td>
                                    <!-- <a href="" class="btn btn-success btn-sm">Edit</a> -->
                                    @if(in_array($form->id,$submitted_ids))
                                    <a href="javascript:void(0);" style="cursor: not-allowed;" class="btn btn-secondary btn-sm" disabled>Submit Form</a>
                                    @else
                                    <a href="submit-form/{{$form->id}}" class="btn btn-primary btn-sm">Submit Form</a>
                                    @endif
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
