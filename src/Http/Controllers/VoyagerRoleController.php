<?php

namespace TCG\Voyager\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

class VoyagerRoleController extends VoyagerBreadController
{
    // POST BR(E)AD
    public function update(Request $request, $id)
    {

        Voyager::canOrFail('edit_roles');

        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);
        $this->insertUpdateData($request, $slug, $dataType->editRows, $data);

        //delete all the permission against the role
        $permissionRoles = \TCG\Voyager\Models\PermissionRole::whereRoleId($data->id)->get();
        foreach ($permissionRoles as $permissionRole){

            $permissionRole->delete();
        }
        //insert all the permission for the role
        foreach ($request->input('permissions') as $permission){

            \TCG\Voyager\Models\PermissionRole::create([
                'role_id' => $data->id,
                'permission_id' => $permission,
            ]);
        }

        return redirect()
            ->route("voyager.{$dataType->slug}.index")
            ->with([
                'message'    => "Successfully Updated {$dataType->display_name_singular}",
                'alert-type' => 'success',
            ]);
    }

    // POST BRE(A)D
    public function store(Request $request)
    {

        Voyager::canOrFail('add_roles');

        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $data = new $dataType->model_name();
        $this->insertUpdateData($request, $slug, $dataType->addRows, $data);

        foreach ($request->input('permissions') as $permission){

            \TCG\Voyager\Models\PermissionRole::create([
                'role_id' => $data->id,
                'permission_id' => $permission,
            ]);
        }

        return redirect()
            ->route("voyager.{$dataType->slug}.index")
            ->with([
                'message'    => "Successfully Added New {$dataType->display_name_singular}",
                'alert-type' => 'success',
            ]);
    }
}
