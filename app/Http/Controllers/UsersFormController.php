<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UsersForm;
use App\Rules\WordsCountRule;
use Illuminate\Http\Request;

class UsersFormController extends Controller
{
    public function index()
    {
        return redirect()->route('step1');
    }

    public function step1()
    {
        $user = User::findOrFail(1);
        return view('users_forms.step1', compact('user'));
    }

    public function step1_data(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'dateOfBirth' => 'required|date',
            'country' => 'required'
        ]);
        settings()->set($request->user_id . '_name', $request->name);
        settings()->set($request->user_id . '_dateOfBirth', $request->dateOfBirth);
        settings()->set($request->user_id . '_country', $request->country);
        settings()->save();
        return redirect()->route('step2');
    }

    public function step2()
    {
        $user = User::findOrFail(1);
        if (
            settings()->get($user->id . '_name') == null ||
            settings()->get($user->id . '_dateOfBirth') == null ||
            settings()->get($user->id . '_country') == null
        ) {
            return redirect()->route('step1')->with(['msg' => 'Please complete all the required fields (*) to proceed.']);
        }
        return view('users_forms.step2', compact('user'));
    }

    public function step2_data(Request $request)
    {
        if (
            settings()->get($request->user_id . '_name') == null ||
            settings()->get($request->user_id . '_dateOfBirth') == null ||
            settings()->get($request->user_id . '_country') == null
        ) {
            return redirect()->route('step1')->with(['msg' => 'Please complete all the required fields (*) to proceed.']);
        }
        $request->validate([
            'gender' => 'nullable',
            'moreInfo' => ['nullable', new WordsCountRule()],
        ]);
        settings()->set($request->user_id . '_gender', $request->gender);
        settings()->set($request->user_id . '_moreInfo', $request->moreInfo);
        settings()->save();
        $form_data = json_encode([
            'name' => settings()->get($request->user_id . '_name', $request->name),
            'dateOfBirth' => settings()->get($request->user_id . '_dateOfBirth', $request->dateOfBirth),
            'country' => settings()->get($request->user_id . '_country', $request->country),
            'gender' => settings()->get($request->user_id . '_gender', $request->gender),
            'moreInfo' => settings()->get($request->user_id . '_moreInfo', $request->moreInfo)
        ]);
        UsersForm::create([
            'user_id' => $request->user_id,
            'form_data' => $form_data
        ]);
        settings()->set($request->user_id . '_name', null);
        settings()->set($request->user_id . '_dateOfBirth', null);
        settings()->set($request->user_id . '_country', null);
        settings()->set($request->user_id . '_gender', null);
        settings()->set($request->user_id . '_moreInfo', null);
        settings()->save();
        return redirect()->route('form-submitted-successfully');
    }

    public function form_submitted_successfully()
    {
        return 'Your form was submitted successfully! Thank you. <a href="step1">Submit a new form</a>';
    }
}
