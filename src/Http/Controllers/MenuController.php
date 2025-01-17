<?php

namespace Dawnstar\Core\Http\Controllers;

use Dawnstar\Core\Http\Requests\MenuRequest;
use Dawnstar\Core\Models\Menu;

class MenuController extends BaseController
{
    public function index()
    {
        canUser("menu.index");

        $menus = Menu::where('website_id', session('dawnstar.website.id'))->get();

        return view('Core::modules.menu.index', compact('menus'));
    }

    public function create()
    {
        canUser("menu.create");

        return view('Core::modules.menu.create');
    }

    public function store(MenuRequest $request)
    {
        canUser("menu.create");

        $data = $request->all();

        $data['website_id'] = session('dawnstar.website.id');

        $menu = Menu::create($data);

        return redirect()->route('dawnstar.menus.index')->with(['success' => __('Core::menu.success.store')]);
    }

    public function edit(Menu $menu)
    {
        canUser("menu.edit");

        return view('Core::modules.menu.edit', compact('menu'));
    }

    public function update(Menu $menu, MenuRequest $request)
    {
        canUser("menu.edit");

        $data = $request->all();

        $menu->update($data);

        return redirect()->route('dawnstar.menus.index')->with(['success' => __('Core::menu.success.update')]);
    }

    public function destroy(Menu $menu)
    {
        canUser("menu.destroy");

        $menu->delete();

        return redirect()->route('dawnstar.menus.index')->with(['success' => __('Core::menu.success.destroy')]);
    }
}
