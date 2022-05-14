@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{ __('Answer Forms') }}
                </div>
                <div class="card-body">
                    <?php 
                    //echo "<pre>";
                    //print_r($fields_ans); exit;?>
                <form method="post" action="{{url('store-form')}}">
                        {!! csrf_field() !!}
                        <?php foreach ($fields as $field) {?>
                            @if($field['type'] == "text" && isset($fields_ans[$field['name']]))
                            <div class="form-group ">
                                <label for="inputEmail4">{{$field['label']}} {{$field['req']?"*":""}}</label>
                                <input type="{{$field['email']?'email':'text'}}" value="{{$fields_ans[$field['name']]}}" name="{{$field['name']}}" class="form-control" <?php echo $field['req'] ? "required" : "" ?>>
                            </div>
                            @endif

                            @if($field['type'] == "number" && isset($fields_ans[$field['name']]))
                            <div class="form-group ">
                                <label for="inputEmail4">{{$field['label']}} {{$field['req']?"*":""}}</label>
                                <input type="number" value="{{$fields_ans[$field['name']]}}" class="form-control" name="{{$field['name']}}" min="{{$field['min']}}" max="{{$field['max']}}" <?php echo $field['req'] ? "required" : "" ?>>
                            </div>
                            @endif

                            @if($field['type'] == "textarea" && isset($fields_ans[$field['name']]))
                            <div class="form-group ">
                                <label for="inputEmail4">{{$field['label']}} {{$field['req']?"*":""}}</label>
                                <textarea class="form-control" name="{{$field['name']}}" <?php echo $field['req'] ? "required" : "" ?>>{{$fields_ans[$field['name']]}}</textarea>
                            </div>
                            @endif

                            @if($field['type'] == "select" && isset($fields_ans[$field['name']]))
                            <div class="form-group ">
                                <label for="inputEmail4">{{$field['label']}} {{$field['req']?"*":""}}</label>
                                <select class="form-control" name="{{$field['name']}}">
                                    @foreach($field['choices'] as $choice)
                                    <option <?php echo $fields_ans[$field['name']] == $choice['label'] ? "selected" : ""; ?>>{{$choice['label']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            @if($field['type'] == "radio" && isset($fields_ans[$field['name']]))
                            <div class="form-group ">
                                <label for="inputEmail4">{{$field['label']}} {{$field['req']?"*":""}}</label>
                                @foreach($field['choices'] as $choice)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" <?php echo $fields_ans[$field['name']] == $choice['label'] ? "checked" : ""; ?> name="{{$field['name']}}" value="{{$choice['label']}}">
                                    <label class="form-check-label" for="{{$choice['label']}}">
                                        {{$choice['label']}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @endif

                            @if($field['type'] == "checkbox" && isset($fields_ans[$field['name']]))
                            <div class="form-group ">
                                <label for="inputEmail4">{{$field['label']}} {{$field['req']?"*":""}}</label>
                                @foreach($field['choices'] as $choice)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" <?php echo in_array($choice['label'], $fields_ans[$field['name']]) ? "checked" : ""; ?> name="{{$field['name']}}[]" value="{{$choice['label']}}">
                                    <label class="form-check-label" for="{{$choice['label']}}">
                                        {{$choice['label']}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @endif
                            <input type="hidden" name="id" value="{{$id}}">
                        <?php }?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
