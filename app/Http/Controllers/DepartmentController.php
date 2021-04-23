<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use DataTables;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Department::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/department/all/edit/'.$row->id.'"  class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition"> <i class="fas fa-pencil-alt"></i> &nbsp;Edit</a> &nbsp;  <a href="javascript:void(0)" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition btn-submit-Del idattr-'.$row->id.' " atrr-id="'.$row->id.'"  data-id='.$row->id.' onclick="return Del_department('.$row->id.')"  > <i class="fas fa-trash"></i> &nbsp; Delete</a>';
                        return $btn;
                    })
                    ->addColumn('created_at', function($row){
                        return $row->created_at->diffForHumans();
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $data = [
            'Edit'=>0,
            'Departmentcount'=> Department::latest()->get()
        ];        
        return view('admin.department.index',$data);
    }

    public function Edit(Request $request ,$id)
    {
        if ($request->ajax()) {
            $data = Department::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/department/all/edit/'.$row->id.'"   class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition"> <i class="fas fa-pencil-alt"></i> &nbsp;Edit</a> &nbsp;  <a href="javascript:void(0):" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition btn-submit-Del idattr-'.$row->id.'  "  atrr-id="'.$row->id.'"  data-id='.$row->id.' onclick="return Del_department('.$row->id.')"  > <i class="fas fa-trash"></i> &nbsp; Delete</a>';
                        return $btn;
                    })
                    ->addColumn('created_at', function($row){
                        return $row->created_at->diffForHumans();
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        //data Edit
        $Departmentre = Department::where('id','=',$id)->first();
        $data = [
            'Department' => $Departmentre,
            'Edit'=>1,
            'Departmentcount'=> Department::latest()->get()
        ];

        return view('admin.department.index',$data);
    }


    public function Savedepartment(Request $request )
    {        
        //data Request
         $request->validate([
            'departments_name' => 'required'
        ]);

        if ($request) {
            
            $userQuery = Department::where('id', $request->id)
            ->update(
                ['departments_name' => $request->departments_name]
            );
            if($userQuery){

            return response()->json(['success'=>'update  records.']);

            }else{

            return response()->json(['error'=>'update  records error.']); 

            }
        }else{
            return response()->json(['error'=>'update  records error.']); 
        }

        return response()->json(['error'=>'update  records error.']);
    }
    


    public function Deldepartment(Request $request )
    {

        //data Request
        $request->validate([
            '_token' => 'required',
            '_thisid' => 'required'
        ]);
        
        $query = Department::where('id',$request->_thisid)->delete();

        if($query){

            return response()->json(['success'=>'del new records.']);

            }else{

            return response()->json(['error'=>'del new records error.']); 

        }
    }

    public function Adddepartment(Request $request )
    {

        //data Request
        $request->validate([
            'departments_name' => 'required'
        ]);
        
        $user = new Department;
        $user->name = $request->departments_name;
        $query = $user->save();
        if($query){

            return response()->json(['success'=>'Add new records.']);

            }else{

            return response()->json(['error'=>'Add new records error.']); 

        }
    }
}