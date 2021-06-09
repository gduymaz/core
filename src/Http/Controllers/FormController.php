<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Http\Requests\FormRequest;
use Dawnstar\Models\Form;

class FormController extends BaseController
{

    public function index()
    {
        canUser("form.index");

        $forms = Form::where('website_id', session('dawnstar.website.id'))->get();
        $breadcrumb = [
            [
                'name' => __('DawnstarLang::form.index_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.form.index', compact('forms', 'breadcrumb'));
    }

    public function create()
    {
        canUser("form.create");

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::form.index_title'),
                'url' => route('dawnstar.forms.index')
            ],
            [
                'name' => __('DawnstarLang::form.create_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.form.create', compact('breadcrumb'));
    }

    public function store(FormRequest $request)
    {
        canUser("form.create");

        $data = $request->except('_token');

        $data['receivers'] = explode(',', $data['receivers']);
        $data['website_id'] = session('dawnstar.website.id');

        $key = \Str::slug($data['name']);
        $form = Form::firstOrCreate(
            ['key' => $key],
            $data
        );

        // Admin Action
        addAction($form, 'store');

        return redirect()->route('dawnstar.forms.index')->with('success_message', __('DawnstarLang::form.response_message.store'));
    }

    public function edit(Form $form)
    {
        canUser("form.edit");

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::form.index_title'),
                'url' => route('dawnstar.forms.index')
            ],
            [
                'name' => __('DawnstarLang::form.edit_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.form.edit', compact('form', 'breadcrumb'));
    }

    public function update(FormRequest $request, Form $form)
    {
        canUser("form.edit");

        $data = $request->except('_token');

        $data['recaptcha_site_key'] = $data['recaptcha_status'] == 1 ? $data['recaptcha_site_key'] : null;
        $data['recaptcha_secret_key'] = $data['recaptcha_status'] == 1 ? $data['recaptcha_secret_key'] : null;
        $data['receivers'] = explode(',', $data['receivers']);

        $form->update($data);

        // Admin Action
        addAction($form, 'update');

        return redirect()->route('dawnstar.forms.index')->with('success_message', __('DawnstarLang::form.response_message.update'));
    }

    public function destroy(Form $form)
    {
        canUser("form.destroy");

        $form->delete();

        // Admin Action
        addAction($form, 'delete');

        return redirect()->route('dawnstar.forms.index')->with('success_message', __('DawnstarLang::form.response_message.destroy'));
    }
}
