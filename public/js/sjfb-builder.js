$(function () {

    //If loading a saved form from your database, put the ID here. Example id is "1".
    var formID = '1';

    //Adds new field with animation
    $("#add-field a").click(function () {
        event.preventDefault();
        $(addField($(this).data('type'))).appendTo('#form-fields').hide().slideDown('fast');
        $('#form-fields').sortable();
    });

    //Removes fields and choices with animation
    $("#sjfb").on("click", ".delete", function () {
        if (confirm('Are you sure?')) {
            var $this = $(this);
            $this.parent().slideUp("slow", function () {
                $this.parent().remove()
            });
        }
    });

    //Makes fields required
    $("#sjfb").on("click", ".toggle-required", function () {
        requiredField($(this));
    });

    //Makes fields email
    $("#sjfb").on("click", ".toggle-email", function () {
        emailField($(this));
    });

    //Makes choices selected
    $("#sjfb").on("click", ".toggle-selected", function () {
        selectedChoice($(this));
    });

    //Adds new choice to field with animation
    $("#sjfb").on("click", ".add-choice", function () {
        $(addChoice()).appendTo($(this).prev()).hide().slideDown('fast');
        $('.choices ul').sortable();
    });

    //Saving form
    $("#sjfb").submit(function (event) {
        event.preventDefault();
        var form_name = $(".form_name").val();
        //Loop through fields and save field data to array
        var fields = [];
        var ts = (new Date()).getTime();
        $('.field').each(function () {

            var $this = $(this);

            //field type
            var fieldType = $this.data('type');

            //field label
            var fieldLabel = $this.find('.field-label').val();

            //min val
            var minVal = $this.find('.min-val').val();

            //max val
            var maxVal = $this.find('.max-val').val();

            //field required
            var fieldReq = $this.hasClass('required') ? 1 : 0;

            //email required
            var fieldEmail = $this.hasClass('email') ? 1 : 0;

            //check if this field has choices
            if ($this.find('.choices li').length >= 1) {

                var choices = [];

                $this.find('.choices li').each(function () {

                    var $thisChoice = $(this);

                    //choice label
                    var choiceLabel = $thisChoice.find('.choice-label').val();

                    //choice selected
                    var choiceSel = $thisChoice.hasClass('selected') ? 1 : 0;

                    choices.push({
                        label: choiceLabel,
                        sel: choiceSel
                    });

                });
            }

            fields.push({
                type: fieldType,
                name: fieldType + "_" + ts++,
                min: minVal,
                max: maxVal,
                label: fieldLabel,
                req: fieldReq,
                choices: choices,
                email: fieldEmail
            });

        });

        var frontEndFormHTML = '';

        //Save form to database
        //Demo doesn't actually save. Download project files for save
        var data = JSON.stringify({ "name": form_name, "value": fields });
        console.log(data);
        $.ajax({
            method: "POST",
            url: "save-form",
            data: data,
            dataType: 'json',
            success: function (response) {
                //var returnedData = JSON.parse(response);
                var url = response['redirect_url'];
                console.log(response);
                if (response['success']) {
                    window.location = url;
                } else {
                    alert("something went wrong");
                }

            }
        });
    });

    //load saved form
    //loadForm(formID);

});

//Add field to builder
function addField(fieldType) {

    var hasRequired, hasChoices;
    var includeRequiredHTML = '';
    var includeChoicesHTML = '';
    var includeEmailHTML = '';
    var includeMinHTML = '';
    var includeMaxHTML = '';
    var field_name;

    switch (fieldType) {
        case 'text':
            hasRequired = true;
            hasChoices = false;
            hasMin = false;
            hasMax = false;
            hasEmail = true;
            field_name = "Textbox";
            break;
        case 'textarea':
            hasRequired = true;
            hasChoices = false;
            hasMin = false;
            hasMax = false;
            hasEmail = false;
            field_name = "Textarea";
            break;
        case 'select':
            hasRequired = true;
            hasChoices = true;
            hasMin = false;
            hasMax = false;
            hasEmail = false;
            field_name = "Drop Down List";
            break;
        case 'radio':
            hasRequired = true;
            hasChoices = true;
            hasMin = false;
            hasMax = false;
            hasEmail = false;
            field_name = "Radio Button";
            break;
        case 'checkbox':
            hasRequired = false;
            hasChoices = true;
            hasMin = false;
            hasMax = false;
            hasEmail = false;
            field_name = "Checkbox";
            break;
        case 'number':
            //required "agree to terms" checkbox
            hasRequired = false;
            hasChoices = false;
            hasMin = true;
            hasMax = true;
            hasEmail = false;
            field_name = "Number";
            break;
    }

    if (hasRequired) {
        includeRequiredHTML = '' +
            '<label class="p-2">Required? ' +
            '<input class="toggle-required" type="checkbox">' +
            '</label>'
    }

    if (hasChoices) {
        includeChoicesHTML = '' +
            '<div class="choices">' +
            '<ul></ul>' +
            '<button type="button" class="add-choice">Add Choice</button>' +
            '</div>'
    }

    if (hasMin) {
        includeMinHTML = '' +
            '<label>Min ' +
            '<input class="min-val" type="number">' +
            '</label>'
    }

    if (hasMax) {
        includeMaxHTML = '' +
            '<label>Max ' +
            '<input class="max-val" type="number">' +
            '</label>'
    }
    if (hasEmail) {
        includeEmailHTML = '' +
            '<label class="p-2">Email? ' +
            '<input class="toggle-email" type="checkbox">' +
            '</label>'
    }

    return '' +
        '<div class="field" data-type="' + fieldType + '">' +
        '<button type="button"  class="delete">Delete Field</button>' +
        '<h4 style="background: #efefef;">' + field_name + '</h4>' +
        '<label>Label:' +
        '<input type="text" class="field-label">' +
        '</label>' +
        includeRequiredHTML +
        includeEmailHTML +
        includeMinHTML +
        includeMaxHTML +
        includeChoicesHTML +
        '</div>'
}

//Make builder field required
function requiredField($this) {
    if (!$this.parents('.field').hasClass('required')) {
        //Field required
        $this.parents('.field').addClass('required');
        $this.attr('checked', 'checked');
    } else {
        //Field not required
        $this.parents('.field').removeClass('required');
        $this.removeAttr('checked');
    }
}

//Make builder field email
function emailField($this) {
    if (!$this.parents('.field').hasClass('email')) {
        //Field required
        $this.parents('.field').addClass('email');
        $this.attr('checked', 'checked');
    } else {
        //Field not required
        $this.parents('.field').removeClass('email');
        $this.removeAttr('checked');
    }
}

function selectedChoice($this) {
    if (!$this.parents('li').hasClass('selected')) {

        //Only checkboxes can have more than one item selected at a time
        //If this is not a checkbox group, unselect the choices before selecting
        if ($this.parents('.field').data('type') != 'checkbox') {
            $this.parents('.choices').find('li').removeClass('selected');
            $this.parents('.choices').find('.toggle-selected').not($this).removeAttr('checked');
        }

        //Make selected
        $this.parents('li').addClass('selected');
        $this.attr('checked', 'checked');

    } else {

        //Unselect
        $this.parents('li').removeClass('selected');
        $this.removeAttr('checked');

    }
}

//Builder HTML for select, radio, and checkbox choices
function addChoice() {
    return '' +
        '<li>' +
        '<label>Choice: ' +
        '<input type="text" class="choice-label">' +
        '</label>' +
        '<label>Selected? ' +
        '<input class="toggle-selected" type="checkbox">' +
        '</label>' +
        '<button type="button" class="delete">Delete Choice</button>' +
        '</li>'
}

//Loads a saved form from your database into the builder
// function loadForm(formID) {
//     $.getJSON('sjfb-load.php?form_id=' + formID, function(data) {
//         if (data) {
//             //go through each saved field object and render the builder
//             $.each( data, function( k, v ) {
//                 //Add the field
//                 $(addField(v['type'])).appendTo('#form-fields').hide().slideDown('fast');
//                 var $currentField = $('#form-fields .field').last();

//                 //Add the label
//                 $currentField.find('.field-label').val(v['label']);

//                 //Is it required?
//                 if (v['req']) {
//                     requiredField($currentField.find('.toggle-required'));
//                 }

//                 //Any choices?
//                 if (v['choices']) {
//                     $.each( v['choices'], function( k, v ) {
//                         //add the choices
//                         $currentField.find('.choices ul').append(addChoice());

//                         //Add the label
//                         $currentField.find('.choice-label').last().val(v['label']);

//                         //Is it selected?
//                         if (v['sel']) {
//                             selectedChoice($currentField.find('.toggle-selected').last());
//                         }
//                     });
//                 }

//             });

//             $('#form-fields').sortable();
//             $('.choices ul').sortable();
//         }
//     });
// }