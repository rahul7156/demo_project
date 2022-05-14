@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{ __('Submit Forms') }} : {{$name}}
                </div>
                <?php //echo "<pre>";
                //print_r($fields);
                //echo "</pre>"; 
                ?>
                <div class="card-body">
                    <form method="post" action="{{url('store-form')}}">
                        {!! csrf_field() !!}
                        <?php foreach ($fields as $field) { ?>
                            @if($field['type'] == "text")
                            <div class="form-group ">
                                <label for="inputEmail4">{{$field['label']}} {{$field['req']?"*":""}}</label>
                                <input type="{{$field['email']?'email':'text'}}" name="{{$field['name']}}" class="form-control" <?php echo $field['req'] ? "required" : "" ?>>
                            </div>
                            @endif

                            @if($field['type'] == "number")
                            <div class="form-group ">
                                <label for="inputEmail4">{{$field['label']}} {{$field['req']?"*":""}}</label>
                                <input type="number" class="form-control" name="{{$field['name']}}" min="{{$field['min']}}" max="{{$field['max']}}" <?php echo $field['req'] ? "required" : "" ?>>
                            </div>
                            @endif

                            @if($field['type'] == "textarea")
                            <div class="form-group ">
                                <label for="inputEmail4">{{$field['label']}} {{$field['req']?"*":""}}</label>
                                <textarea class="form-control" name="{{$field['name']}}" <?php echo $field['req'] ? "required" : "" ?>></textarea>
                            </div>
                            @endif

                            @if($field['type'] == "select")
                            <div class="form-group ">
                                <label for="inputEmail4">{{$field['label']}} {{$field['req']?"*":""}}</label>
                                <select class="form-control" name="{{$field['name']}}">
                                    @foreach($field['choices'] as $choice)
                                    <option>{{$choice['label']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            @if($field['type'] == "radio")
                            <div class="form-group ">
                                <label for="inputEmail4">{{$field['label']}} {{$field['req']?"*":""}}</label>
                                @foreach($field['choices'] as $choice)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="{{$field['name']}}" value="{{$choice['label']}}">
                                    <label class="form-check-label" for="{{$choice['label']}}">
                                        {{$choice['label']}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @endif

                            @if($field['type'] == "checkbox")
                            <div class="form-group ">
                                <label for="inputEmail4">{{$field['label']}} {{$field['req']?"*":""}}</label>
                                @foreach($field['choices'] as $choice)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="{{$field['name']}}[]" value="{{$choice['label']}}">
                                    <label class="form-check-label" for="{{$choice['label']}}">
                                        {{$choice['label']}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @endif
                            <input type="hidden" name="id" value="{{$id}}">
                        <?php } ?>
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<style>
    select.form-control {
        -webkit-appearance: menulist;
    }
</style>