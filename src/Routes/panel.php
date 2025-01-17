<?php

use Dawnstar\Core\Http\Controllers\LoginController;

use Dawnstar\Core\Http\Controllers\DashboardController;

use Dawnstar\Core\Http\Controllers\WebsiteController;
use Dawnstar\Core\Http\Controllers\StructureController;
use Dawnstar\Core\Http\Controllers\ContainerController;
use Dawnstar\Core\Http\Controllers\PageController;
use Dawnstar\Core\Http\Controllers\CategoryController;
use Dawnstar\Core\Http\Controllers\PropertyController;
use Dawnstar\Core\Http\Controllers\PropertyOptionController;

use Dawnstar\Core\Http\Controllers\AdminController;
use Dawnstar\Core\Http\Controllers\RoleController;
use Dawnstar\Core\Http\Controllers\AdminActionController;
use Dawnstar\Core\Http\Controllers\ProfileController;

use Dawnstar\Core\Http\Controllers\MenuController;
use Dawnstar\Core\Http\Controllers\MenuItemController;

use Dawnstar\Core\Http\Controllers\FormController;
use Dawnstar\Core\Http\Controllers\FormMessageController;

use Dawnstar\Core\Http\Controllers\CustomTranslationController;
use Dawnstar\Core\Http\Controllers\SettingController;

use Dawnstar\Core\Http\Controllers\UrlController;
use Dawnstar\Core\Http\Controllers\PanelController;

Route::middleware(['dawnstar_guest'])->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login.index');
    Route::post('login', [LoginController::class, 'login'])->name('login');
});

Route::middleware(['dawnstar_auth'])->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/getReport', [DashboardController::class, 'getReport'])->name('dashboard.getReport');

    Route::resource('websites', WebsiteController::class)->except(['show']);

    Route::middleware(['default_website'])->group(function () {
        Route::resource('structures', StructureController::class)->except(['show']);
        Route::resource('structures.containers', ContainerController::class)->only(['edit', 'update']);

        Route::get('structures/{structure}/pages/getCategoryProperties', [PageController::class, 'getCategoryProperties'])->name('structures.pages.getCategoryProperties');
        Route::get('structures/{structure}/pages/datatable', [PageController::class, 'datatable'])->name('structures.pages.datatable');
        Route::resource('structures.pages', PageController::class)->except(['show']);

        Route::post('structures/{structure}/categories/saveOrder', [CategoryController::class, 'saveOrder'])->name('structures.categories.saveOrder');
        Route::resource('structures.categories', CategoryController::class)->except(['create', 'show']);

        Route::post('structures/{structure}/properties/saveOrder', [PropertyController::class, 'saveOrder'])->name('structures.properties.saveOrder');
        Route::resource('structures.properties', PropertyController::class)->except(['create', 'show']);

        Route::post('structures/{structure}/properties/{property}/saveOrder', [PropertyOptionController::class, 'saveOrder'])->name('structures.properties.options.saveOrder');
        Route::resource('structures.properties.options', PropertyOptionController::class)->except(['create', 'show']);

        Route::resource('admins', AdminController::class)->except(['show']);
        Route::get('admin-actions', [AdminActionController::class, 'index'])->name('admin_actions.index');

        Route::resource('roles', RoleController::class)->except(['show']);

        Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::resource('menus', MenuController::class)->except(['show']);
        Route::get('menus/{menu}/items/getUrls', [MenuItemController::class, 'getUrls'])->name('menus.items.getUrls');
        Route::post('menus/{menu}/items/saveOrder', [MenuItemController::class, 'saveOrder'])->name('menus.items.saveOrder');
        Route::resource('menus.items', MenuItemController::class)->except(['create', 'show']);

        Route::resource('forms', FormController::class)->except(['show']);
        Route::resource('forms.messages', FormMessageController::class)->only(['index', 'show', 'destroy']);

        Route::prefix('custom-translations')->as('custom_translations.')->group(function () {
            Route::get('/', [CustomTranslationController::class, 'index'])->name('index');
            Route::get('/search', [CustomTranslationController::class, 'search'])->name('search');
            Route::put('/', [CustomTranslationController::class, 'update'])->name('update');
            Route::delete('/', [CustomTranslationController::class, 'destroy'])->name('destroy');
        });


        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::get('settings/modal', [SettingController::class, 'modal'])->name('settings.modal');
        Route::put('settings/update', [SettingController::class, 'update'])->name('settings.update');
        Route::get('settings/image-quality', [SettingController::class, 'imageQuality'])->name('settings.image_quality');
    });

    Route::get('getUrl', [UrlController::class, 'getUrl'])->name('getUrl');

    Route::prefix('panel')->as('panel.')->group(function () {
        Route::get('changeLanguage/{code}', [PanelController::class, 'changeLanguage'])->name('changeLanguage');
    });
});
