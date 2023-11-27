<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->can('manage permission'))
        {
            $permissions = Permission::all();
            return view('permission.index')->with('permissions', $permissions);
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role=Role::where('created_by', '=', \Auth::user()->creatorId())->get();
        return view('permission.create')->with('roles', $role);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Auth::user()->can('create permission'))
        {
            $this->validate(
                $request, [
                            'name' => 'required|max:40',
                        ]
            );

            $name             = $request['name'];
            $permission       = new Permission();
            $permission->name = $name;

            
            $roles = $request['roles'];
            $permission->save();

            if(!empty($request['roles']))
            {
                foreach($roles as $role)
                {
                    $r          = Role::where('id', '=', $role)->firstOrFail(); 
                    $permission = Permission::where('name', '=', $name)->first(); 
                    $r->givePermissionTo($permission);
                }
            }

            return redirect()->route('permissions.index')->with('success', 'Permission ' . $permission->name . ' added!');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::where('id', '=', $id)->first();
        $roles = Role::where('created_by', '=', \Auth::user()->creatorId())->get();
        return view('permission.edit', compact('roles', 'permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(\Auth::user()->can('edit permission'))
        {
            $permission = Permission::findOrFail($id);
                $this->validate(
                    $request, [
                                'name' => 'required|max:40',
                            ]
                );
                $input = $request->all();
                $permission->fill($input)->save();

                return redirect()->route('permissions.index')->with('success', 'Permission ' . $permission->name . ' updated!');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\Auth::user()->can('delete permission'))
        {
            $permission = Permission::findOrFail($id);
            $permission->delete();

            return redirect()->route('permissions.index')->with('success', 'Permission deleted!');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
