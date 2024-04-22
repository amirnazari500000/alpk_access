<?php

namespace Amir\Access\Controllers;

use Amir\Access\Models\Access;
use Amir\Access\Models\Role;
use Amir\Access\Models\UserAccess;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Route;

class AccessController extends Controller
{
    //

    public static function accessUserList(User $user)
    {

        self::updateAccessRoutes();

        $access_items = Access::where('role_id', $user->role_id)->get();
        $access_list = [];
        foreach ($access_items as $key => $access_item) {
            $user_access = UserAccess::where('user_id', $user->id)->where('access_id', $access_item->id)->exists();
            if ($access_item->def_access && $user_access) {
                $access_list[$key]['access'] = 0;
            } else if (!$access_item->def_access && !$user_access) {
                $access_list[$key]['access'] = 0;
            }else{
                $access_list[$key]['access'] = 1;
            }
            $access_list[$key]['name'] = $access_item->title;
            $access_list[$key]['id'] = $access_item->id;
        }

        return $access_list;
    }

    public static function accessUserUpdate(User $user, $access_list)
    {


        foreach ($access_list as $access) {

            $access_item = Access::find($access->id);
            if (!$access_item) continue;

            $user_access = UserAccess::where('user_id', $user->id)->where('access_id', $access_item->id)->exists();
            if ($access_item->def_access && $user_access) {
                $access_old = 0;
            } else if (!$access_item->def_access && !$user_access) {
                $access_old = 0;
            }else{
                $access_old = 1;
            }

            if ($access_old == $access->access) continue;

            if (!$user_access){
                UserAccess::create([
                    'user_id' => $user->id,
                    'access_id' => $access_item->id,
                ]);
            }else if ($user_access){
                UserAccess::where('user_id', $user->id)->where('access_id', $access_item->id)->delete();
            }

        }

    }

    public static function updateAccessRoutes()
    {
        $routes = Route::getRoutes();

        foreach ($routes as $route) {
            $role = $route->getAction('role');
            if ($role) {
                $role_data = Role::where('nick_name', $role)->first();
                if ($role_data) {

                    $role_id = $role_data->id;
                    $route_name = $route->getName();
                    if (!Access::where('route', $route_name)->exists()) {

                        $title = $route->getAction('title');
                        $status = $route->getAction('status');
                        $def_access = $route->getAction('def_access');

                        $access = [
                            'route' => $route_name,
                            'role_id' => $role_id,
                        ];

                        if ($title) $access['title'] = $title;
                        if ($status != null) $access['status'] = $status;
                        if ($def_access != null) $access['def_access'] = $def_access;


                        Access::create($access);

                    } else {

                        $title = $route->getAction('title');
                        $status = $route->getAction('status');
                        $def_access = $route->getAction('def_access');

                        $access = [
                            'role_id' => $role_id,
                        ];

                        if ($title) $access['title'] = $title;
                        if ($status != null) $access['status'] = $status;
                        if ($def_access != null) $access['def_access'] = $def_access;


                        Access::where('route', $route_name)->update($access);

                    }
                }
            } else {
                $route_name = $route->getName();
                Access::where('route', $route_name)->delete();
            }
        }
    }

}
