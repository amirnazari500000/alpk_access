<?php

namespace Amir\Access\Controllers;

use Amir\Access\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function getRoles($status = -1)
    {
        if ($status < 0) {
            return json_encode(['roles' => Role::all()]);
        }

        return json_encode(['roles' => Role::whereStatus($status)->get()]);

    }

    public function loadRole($id)
    {

        return json_encode(['role' => Role::find($id)]);
    }

    public function updateRole(Request $request, $id)
    {

        try {

            $role = Role::find($id);
            $role->name = $request->input('name');
            $role->nick_name = $request->input('nick_name');
            $role->status = $request->input('status');
            $role->save();

            return json_encode(['message' => trans('global.success_attempt')]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
