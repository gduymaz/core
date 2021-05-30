<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Contracts\Services\ModelStoreService;
use Dawnstar\Http\Requests\AdminRequest;
use Dawnstar\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminController extends BaseController
{
    public function callAction($method, $parameters)
    {
        $temp = ['store' => 'create', 'update' => 'edit'];

        $permissionType = $temp[$method] ?? $method;
        $key = "admin.{$permissionType}";

        if(auth()->user()->can($key)) {
            return parent::callAction($method, $parameters);
        }

        return view('DawnstarView::pages.permission.error');
    }

    public function index()
    {
        $admins = Admin::all();
        $breadcrumb = [
            [
                'name' => __('DawnstarLang::admin.index_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.admin.index', compact('admins', 'breadcrumb'));
    }

    public function create()
    {
        $breadcrumb = [
            [
                'name' => __('DawnstarLang::admin.index_title'),
                'url' => route('dawnstar.admins.index')
            ],
            [
                'name' => __('DawnstarLang::admin.create_title'),
                'url' => '#'
            ]
        ];

        $roles = Role::all();

        return view('DawnstarView::pages.admin.create', compact('breadcrumb', 'roles'));
    }

    public function store(AdminRequest $request)
    {
        $data = $request->except('_token', 'role_id');

        $data['password'] = Hash::make($data['password']);

        $image = $data['image'] ?? null;
        unset($data['image']);

        $admin = Admin::firstOrCreate($data);

        $role = Role::findById($request->get('role_id'));
        $admin->assignRole($role->name);

        $storeDevice = new ModelStoreService();
        $storeDevice->storeMedias($admin, ['image' => $image]);

        // Admin Action
        addAction($admin, 'store');

        return redirect()->route('dawnstar.admins.index')->with('success_message', __('DawnstarLang::admin.response_message.store'));
    }

    public function edit(Admin $admin)
    {
        $breadcrumb = [
            [
                'name' => __('DawnstarLang::admin.index_title'),
                'url' => route('dawnstar.admins.index')
            ],
            [
                'name' => __('DawnstarLang::admin.edit_title'),
                'url' => '#'
            ]
        ];

        $roles = Role::all();

        return view('DawnstarView::pages.admin.edit', compact('admin', 'roles', 'breadcrumb'));
    }

    public function update(AdminRequest $request, Admin $admin)
    {
        $data = $request->except('_token', 'image', 'role_id');

        if(is_null($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $admin->update($data);

        $role = Role::findById($request->get('role_id'));
        $admin->assignRole($role->name);

        $storeDevice = new ModelStoreService();
        $storeDevice->storeMedias($admin, ['image' => $request->get('image')]);

        // Admin Action
        addAction($admin, 'update');

        return redirect()->route('dawnstar.admins.index')->with('success_message', __('DawnstarLang::admin.response_message.update'));
    }

    public function destroy(Admin $admin)
    {
        if (auth('admin')->id() == $admin->id) {
            return back()->withErrors(__('DawnstarLang::general.swal.error.title'));
        }

        $admin->delete();

        // Admin Action
        addAction($admin, 'delete');

        return redirect()->route('dawnstar.admins.index')->with('success_message', __('DawnstarLang::admin.response_message.delete'));
    }
}
