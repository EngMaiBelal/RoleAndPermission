<?php

namespace App\Http\Controllers\admin\permissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:permission-list')->only('index');
        $this->middleware('can:permission-create')->only('create','store');
        $this->middleware('can:permission-edit')->only('edit','update');
        $this->middleware('can:permission-delete')->only('destory','destroyAll');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.permissions.all',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $guards = array_keys(config('auth.guards'));
        return view('admin.permissions.create',compact('guards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name'=>['required','string'],
            'guard_name'=>['nullable']
        ];
        $request->validate($rules);
        $data = $request->except('_token','crud');
        if($request->has('crud')){
            $data = [
                ['name'=>$request->name.'-list',"guard_name"=>"web"],
                ['name'=>$request->name.'-add',"guard_name"=>"web"],
                ['name'=>$request->name.'-edit',"guard_name"=>"web"],
                ['name'=>$request->name.'-delete',"guard_name"=>"web"]
            ];
        }
        // return $data;
        Permission::insert($data);
        return redirect()->route('permissions.index')->with('Success','Permission Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::findById($id);
        $guards = array_keys(config('auth.guards'));
        return view('admin.permissions.edit',compact('permission','guards'));

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
        $rules = [
            'name'=>['required','string'],
            'guard_name'=>['nullable']
        ];
        $request->validate($rules);
        Permission::where('id',$id)->update($request->except('_token','_method'));
        return redirect()->route('permissions.index')->with('Success','Permission Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Permission::destroy($id);
        return redirect()->route('permissions.index')->with('Success','Permission Deleted Successfully');
    }
    // public function destroyAll(Request $request)
    // {
    //     $rules = [
    //         'deleted_ids.*'=>'required','integers','exists:permissions,id'
    //     ];
    //     $request->validate($rules);
    //     $deletedIds = explode(',',$request->deleted_ids[0]);
    //     Permission::destroy($deletedIds);
    //     return redirect()->route('permissions.index')->with('Success','Permissions Deleted Successfully');
    // }
}
