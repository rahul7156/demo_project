<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormAnswers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class FormController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $forms = Form::all();
        $forms_array = array();
        foreach ($forms as $key => $form) {
            $form_ans = FormAnswers::where(['form_id' => $form->id])->get();
            $no_of_submit = $form_ans->count();
            $forms_array[$key]['id'] = $form->id;
            $forms_array[$key]['name'] = $form->name;
            $forms_array[$key]['no_of_submit'] = $no_of_submit;
            $forms_array[$key]['no_of_view'] = $form->no_of_time_open;
            $forms_array[$key]['submitte_ans'] = $no_of_submit;
        }

        return view('manage-forms/form', ["forms_array" => $forms_array]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('manage-forms/create-form');
    }

    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function save(Request $request)
    {
        $form_data = json_decode(file_get_contents('php://input'), true);
        $userId = Auth::id();
        $form_model = new Form();
        $form_model->name = $form_data['name'];
        $form_model->fields = json_encode($form_data['value']);
        $form_model->logged_id = $userId;
        if ($form_model->save()) {
            return response()->json(['success' => true, 'msg' => 'Form Created Successfully', "redirect_url" => url("manage-forms")]);
        } else {
            return response()->json(['success' => false, 'msg' => 'Something went wrong']);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function delete($id)
    {
        $form = Form::where("id", $id)->delete();
        return Redirect::back();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function submit_forms_list()
    {

        $forms = Form::all();
        $userId = Auth::id();
        $submitted_forms = FormAnswers::where(['submitter_id' => $userId])->select("form_id")->get();
        $submitted_ids = array();
        if ($submitted_forms) {
            foreach ($submitted_forms as $form) {
                array_push($submitted_ids, $form->form_id);
            }
        }
        return view('manage-forms/submit-form-list', ["forms" => $forms, "submitted_ids" => $submitted_ids]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function submit_form($id)
    {
        $forms = Form::where("id", $id)->first();
        $name = $forms['name'];
        Form::where('id', $id)
            ->increment('no_of_time_open', 1);
        $fields = json_decode($forms['fields'], true);
        return view('manage-forms/submit-form', ["name" => $name, "id" => $id, "fields" => $fields]);
    }

    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store_form(Request $request)
    {
        $form_data = $request->all();
        $userId = Auth::id();
        $form_ans_model = new FormAnswers();
        $form_ans_model->form_id = $form_data['id'];
        $form_ans_model->answers = json_encode($form_data);
        $form_ans_model->submitter_id = $userId;
        if ($form_ans_model->save()) {
            return Redirect::route("submit-forms-list")->with('success', true)->with('msg', 'Form Submitted Successfully');
        } else {
            return Redirect::route("submit-forms-list")->with('success', false)->with('msg', 'Something went wrong');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function submitter_form($id)
    {
        $forms_ans = FormAnswers::where(["form_id" => $id])->get();
        $forms = Form::where(["id" => $id])->first();
        $submitter_form = array();
        foreach ($forms_ans as $key => $form) {
            $user = User::where(['id' => $form->submitter_id])->first();
            $submitter_form[$key]['form_id'] = $id;
            $submitter_form[$key]['user_id'] = $form->submitter_id;
            $submitter_form[$key]['form_name'] = $forms->name;
            $submitter_form[$key]['submiiter_name'] = $user->name;
        }
        return view('manage-forms/submitter-form', ["submitter_form" => $submitter_form]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function answer_form($id, $user_id)
    {
        $forms = Form::where("id", $id)->first();
        $name = $forms['name'];
        $fields = json_decode($forms['fields'], true);
        $forms_ans = FormAnswers::where(["form_id" => $id, 'submitter_id' => $user_id])->first();
        $fields_ans = json_decode($forms_ans['answers'], true);
        return view('manage-forms/answer-form', ["name" => $name, "id" => $id, "fields" => $fields, 'fields_ans' => $fields_ans]);
    }

}
