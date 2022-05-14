@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Create Forms') }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-9 pt-2 pb-2" style="background: #f9f9f9;border: solid 1px #b5b5b5;">
                            <form id="sjfb" novalidate>
                                <div class="pb-3">
                                    <label>Form Name</label>
                                    <input type="text" name="form_name" class="form-control form_name">
                                </div>
                                <div id="form-fields">
                                </div>
                                <button type="submit" class="submit">Save Form</button>
                            </form>
                        </div>
                        <div class="col-sm-3">
                            <div class="add-wrap">
                                <h5>Add Field:</h5>
                                <ul class="list-group" id="add-field">
                                    <li class="list-group-item"><a id="add-text" data-type="text" href="#">Text Field</a></li>
                                    <li class="list-group-item"><a id="add-textarea" data-type="textarea" href="#">Text Area</a></li>
                                    <li class="list-group-item"><a id="add-number" data-type="number" href="#">Number</a></li>
                                    <li class="list-group-item"><a id="add-select" data-type="select" href="#">Select Box (Drop down list)</a></li>
                                    <li class="list-group-item"><a id="add-radio" data-type="radio" href="#">Radio Buttons</a></li>
                                    <li class="list-group-item"><a id="add-checkbox" data-type="checkbox" href="#">Checkboxes</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection