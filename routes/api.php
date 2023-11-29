<?php

use App\Http\Controllers\Api\Account\AccountController as AccountAccountController;
use App\Http\Controllers\Api\Auth\AuthController as AuthAuthController;
use App\Http\Controllers\Api\Dashboard\Admin\DepartmentController as DashboardAdminDepartmentController;
use App\Http\Controllers\Api\Dashboard\Admin\LabelController as DashboardAdminLabelController;
use App\Http\Controllers\Api\Dashboard\Admin\LanguageController as DashboardAdminLanguageController;
use App\Http\Controllers\Api\Dashboard\Admin\PriorityController as DashboardAdminPriorityController;
use App\Http\Controllers\Api\Dashboard\Admin\SettingController as DashboardAdminSettingController;
use App\Http\Controllers\Api\Dashboard\Admin\StatusController as DashboardAdminStatusController;
use App\Http\Controllers\Api\Dashboard\Admin\UserController as DashboardAdminUserController;
use App\Http\Controllers\Api\Dashboard\Admin\UserRoleController as DashboardAdminUserRoleController;
use App\Http\Controllers\Api\Dashboard\CannedReplyController as DashboardCannedReplyController;
use App\Http\Controllers\Api\Dashboard\ExcelController;
use App\Http\Controllers\Api\Dashboard\StatsController as DashboardStatsController;
use App\Http\Controllers\Api\Dashboard\TicketController as DashboardTicketController;

use App\Http\Controllers\Api\Dashboard\EquiposController as DashboardEquiposController;

use App\Http\Controllers\Api\File\FileController as FileFileController;
use App\Http\Controllers\Api\Language\LanguageController as LanguageLanguageController;
use App\Http\Controllers\Api\Dashboard\Admin\TurnoController as DashboardAdminTurnoController;
use App\Http\Controllers\Api\Dashboard\Admin\CategoriasController as DashboardAdminCategoriasController;

use App\Http\Controllers\Api\Dashboard\ExcelController as DashboardExcelController;


//RUTAS MODIFICACIONES
use App\Http\Controllers\Api\Dashboard\Admin\OficinasController as DashboardAdminOficinasController;
use App\Http\Controllers\Api\Dashboard\Admin\EmpleadosController as DashboardAdminEmpleadosController;
use App\Http\Controllers\Api\Dashboard\Admin\DirectorioController as DashboardAdminDirectorioController;

use App\Http\Controllers\Api\Dashboard\Admin\NominaController as DashboardAdminNominaController;
use App\Http\Controllers\Api\Dashboard\Admin\DirectorioStoreController as DashboardAdminDirectorioStoreController;
use App\Http\Controllers\Api\Dashboard\Admin\DirectorioUpdateController as DashboardAdminDirectorioUpdateControllerPermission;
use App\Http\Controllers\Api\Dashboard\Admin\DirectorioController as DashboardAdminDirectorioUpdateController;


use App\Http\Controllers\Api\Dashboard\Admin\ActivityController as DashboardAdminActivityController;

use App\Http\Controllers\Api\Dashboard\Admin\DelegacionesController as DashboardAdminDelegaciones;
use App\Http\Controllers\Api\Dashboard\Admin\PersonalController as DashboardAdminPersonalController;
use App\Http\Controllers\Api\Dashboard\Admin\CalendarioController as DashboardAdminCalendarioController;

///////
Route::group(['prefix' => 'lang'], static function () {
    Route::get('/', [LanguageLanguageController::class, 'list'])->name('language.list');
    Route::get('/{lang}', [LanguageLanguageController::class, 'get'])->name('language.get');
});

Route::group(['prefix' => 'auth'], static function () {
    Route::post('login', [AuthAuthController::class, 'login'])->name('auth.login');
    Route::post('logout', [AuthAuthController::class, 'logout'])->name('auth.logout');
    Route::post('register', [AuthAuthController::class, 'register'])->name('auth.register');
    Route::post('recover', [AuthAuthController::class, 'recover'])->name('auth.recover');
    Route::post('reset', [AuthAuthController::class, 'reset'])->name('auth.reset');
    Route::get('user', [AuthAuthController::class, 'user'])->name('auth.user');
    Route::post('check', [AuthAuthController::class, 'check'])->name('auth.check');
});

Route::group(['prefix' => 'account'], static function () {
    Route::post('update', [AccountAccountController::class, 'update'])->name('account.update');
    Route::post('password', [AccountAccountController::class, 'password'])->name('account.password');
});

Route::get('files/download/{uuid}', [FileFileController::class, 'download'])->name('files.download');
Route::apiResource('files', FileFileController::class)->only(['store', 'show']);

Route::group(['prefix' => 'dashboard'], static function () {

    Route::get('exportar-equipos',[ExcelController::class, 'export']);
    Route::get('exportar-equiposTicket',[ExcelController::class, 'export']);

    Route::group(['prefix' => 'stats'], static function () {
        Route::get('count', [DashboardStatsController::class, 'count'])->name('dashboard.stats-count');
        Route::get('registered-users', [DashboardStatsController::class, 'registeredUsers'])->name('dashboard.stats.registered-users');
        Route::get('opened-tickets', [DashboardStatsController::class, 'openedTickets'])->name('dashboard.stats.opened-tickets');
    });

    Route::get('tickets/filters', [DashboardTicketController::class, 'filters'])->name('dashboard.tickets.filters');
    Route::get('tickets/canned-replies', [DashboardTicketController::class, 'cannedReplies'])->name('dashboard.tickets.canned-replies');
    Route::post('tickets/quick-actions', [DashboardTicketController::class, 'quickActions'])->name('dashboard.tickets.quick-actions');
    Route::post('tickets/attachments', [DashboardTicketController::class, 'uploadAttachment'])->name('dashboard.tickets.upload-attachment');
    Route::post('tickets/{ticket}/remove-label', [DashboardTicketController::class, 'removeLabel'])->name('dashboard.tickets.remove-label');
    Route::post('tickets/{ticket}/quick-actions', [DashboardTicketController::class, 'ticketQuickActions'])->name('dashboard.tickets.ticket-quick-actions');
    Route::post('tickets/{ticket}/reply', [DashboardTicketController::class, 'reply'])->name('dashboard.tickets.reply');
    Route::apiResource('tickets', DashboardTicketController::class);



    Route::get('equipos/filters',[DashboardEquiposController::class, 'filters'])->name('dashboard.equipos.filters');
    Route::post('equipos/attachments', [DashboardEquiposController::class, 'uploadAttachment'])->name('dashboard.equipos.upload-attachment');
    Route::apiResource('equipos', DashboardEquiposController::class);
    Route::post('equipos/{equipo}/reply',[DashboardEquiposController::class, 'reply'])->name('dashboard.equipos.reply');
    Route::post('equipos/quick-actions',[DashboardEquiposController::class, 'quickActions'])->name('dashboard.equipos.quick-actions');
    Route::post('equipos/{equipo}/quick-actions',[DashboardEquiposController::class, 'quickActions'])->name('dashboard.equipos.equipos-quick-actions');

    Route::apiResource('canned-replies', DashboardCannedReplyController::class);

    Route::group(['prefix' => 'admin'], static function () {

        Route::get('departments/users', [DashboardAdminDepartmentController::class, 'users'])->name('dashboard.departments.users');
        Route::apiResource('departments', DashboardAdminDepartmentController::class);

        Route::apiResource('labels', DashboardAdminLabelController::class);

        Route::apiResource('personal', DashboardAdminPersonalController::class);

        Route::apiResource('calendario',DashboardAdminCalendarioController::class);
        ///MODIFICACIONES DE API

        Route::apiResource('delegaciones',DashboardAdminDelegaciones::class);
        Route::apiResource('oficinas',DashboardAdminOficinasController::class);
        Route::apiResource('turnos', DashboardAdminTurnoController::class);
        Route::apiResource('categorias',DashboardAdminCategoriasController::class);

        Route::get('empleados/filters',[DashboardAdminEmpleadosController::class, 'filters'])->name('empleados.filters');
        Route::apiResource('empleados',DashboardAdminEmpleadosController::class);

        Route::get('directorio/datosEquipo', [DashboardAdminDirectorioController::class, 'datosEquipo'])->name('directorio.datosEquipo');
        Route::get('directorio/getTickets', [DashboardAdminDirectorioController::class, 'getTickets'])->name('directorio.getTickets');
        Route::get('directorio/updateOficinasList/{selectedState}',[DashboardAdminDirectorioController::class, 'updateOficinasList'])->name('directorio.updateOficinasList');
        Route::get('directorio/datosEmpleado',[DashboardAdminDirectorioController::class, 'datosEmpleado'])->name('directorio.datosEmpleado');
        Route::get('directorio/getEmpleados',[DashboardAdminDirectorioController::class, 'getEmpleados'])->name('directorio.getEmpleados');
        Route::get('directorio/getEquipo', [DashboardAdminEquipoDirectorioController::class, 'getEquipo'])->name('directorio.getEquipo');
        Route::apiResource('directorio',DashboardAdminDirectorioController::class)->except([
           'destroy', 'update','show'
         ]);
        Route::post('directorio/store', [DashboardAdminDirectorioStoreController::class, 'store'])->name('directorio.store');
        Route::put('directorio/update/{directorio}', [DashboardAdminDirectorioUpdateController::class, 'update'])->name('directorio.update');
        
        Route::post('directorio/actualizarStatus', [DashboardAdminDirectorioUpdateControllerPermission::class, 'actualizar'])->name('directorio.actualizar');
        /////
        Route::apiResource('statuses', DashboardAdminStatusController::class)->except(['store', 'delete']);
        Route::apiResource('activity', DashboardAdminActivityController::class);

        Route::apiResource('priorities', DashboardAdminPriorityController::class)->except(['store', 'delete']);

        Route::get('users/user-roles', [DashboardAdminUserController::class, 'userRoles'])->name('users.user-roles');
        Route::apiResource('users', DashboardAdminUserController::class);
        Route::apiResource('nomina', DashboardAdminNominaController::class);
        
        Route::get('user-roles/permissions', [DashboardAdminUserRoleController::class, 'permissions'])->name('user-roles.permissions');
        Route::apiResource('user-roles', DashboardAdminUserRoleController::class);

        Route::get('settings/user-roles', [DashboardAdminSettingController::class, 'userRoles'])->name('settings.user-roles');
        Route::get('settings/languages', [DashboardAdminSettingController::class, 'languages'])->name('settings.languages');
        Route::get('settings/general', [DashboardAdminSettingController::class, 'getGeneral'])->name('settings.get.general');
        Route::post('settings/general', [DashboardAdminSettingController::class, 'setGeneral'])->name('settings.set.general');
        Route::get('settings/seo', [DashboardAdminSettingController::class, 'getSeo'])->name('settings.get.seo');
        Route::post('settings/seo', [DashboardAdminSettingController::class, 'setSeo'])->name('settings.set.seo');
        Route::get('settings/appearance', [DashboardAdminSettingController::class, 'getAppearance'])->name('settings.get.appearance');
        Route::post('settings/appearance', [DashboardAdminSettingController::class, 'setAppearance'])->name('settings.set.appearance');
        Route::get('settings/localization', [DashboardAdminSettingController::class, 'getLocalization'])->name('settings.get.localization');
        Route::post('settings/localization', [DashboardAdminSettingController::class, 'setLocalization'])->name('settings.set.localization');
        Route::get('settings/authentication', [DashboardAdminSettingController::class, 'getAuthentication'])->name('settings.get.authentication');
        Route::post('settings/authentication', [DashboardAdminSettingController::class, 'setAuthentication'])->name('settings.set.authentication');
        Route::get('settings/outgoing-mail', [DashboardAdminSettingController::class, 'getOutgoingMail'])->name('settings.get.outgoingMail');
        Route::post('settings/outgoing-mail', [DashboardAdminSettingController::class, 'setOutgoingMail'])->name('settings.set.outgoingMail');
        Route::get('settings/logging', [DashboardAdminSettingController::class, 'getLogging'])->name('settings.get.logging');
        Route::post('settings/logging', [DashboardAdminSettingController::class, 'setLogging'])->name('settings.set.logging');
        Route::get('settings/captcha', [DashboardAdminSettingController::class, 'getCaptcha'])->name('settings.get.captcha');
        Route::post('settings/captcha', [DashboardAdminSettingController::class, 'setCaptcha'])->name('settings.set.captcha');

        Route::post('languages/sync', [DashboardAdminLanguageController::class, 'sync'])->name('language.sync');
        Route::apiResource('languages', DashboardAdminLanguageController::class);
    });
});
