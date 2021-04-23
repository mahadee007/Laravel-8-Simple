<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/Edit/'.$row->id.'"  class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition"> <i class="fas fa-pencil-alt"></i> &nbsp;Edit</a> &nbsp;  <a href="javascript:void(0)" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition btn-submit-Del idattr-'.$row->id.' " atrr-id="'.$row->id.'"  data-id='.$row->id.' onclick="return Del('.$row->id.')"  > <i class="fas fa-trash"></i> &nbsp; Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $data = [
            'Edit'=>0
        ];
        return view('user',$data);
    }

    public function Edit(Request $request ,$id)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/Edit/'.$row->id.'"   class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition"> <i class="fas fa-pencil-alt"></i> &nbsp;Edit</a> &nbsp;  <a href="javascript:void(0):" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition btn-submit-Del idattr-'.$row->id.'  "  atrr-id="'.$row->id.'"  data-id='.$row->id.' onclick="return Del('.$row->id.')"  > <i class="fas fa-trash"></i> &nbsp; Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        //data Edit
        $userEdit = User::where('id','=',$id)->first();
        $data = [
            'EditUser' => $userEdit,
            'Edit'=>1
        ];

        return view('user',$data);
    }


    public function Save(Request $request )
    {        
        //data Request
         $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        if ($request) {
            
            $userQuery = User::where('id', $request->id)
            ->update(
                ['name' => $request->name],
                ['email' => $request->email],
            );
            if($userQuery){

            return response()->json(['success'=>'Added new records.']);

            }else{

            return response()->json(['error'=>'Added new records error.']); 

            }
        }else{
            return response()->json(['error'=>'121']); 
        }

        return response()->json(['error'=>'121']);
        // return view('user',$data);
    }
    


    public function Del(Request $request )
    {

        //data Request
        $request->validate([
            '_token' => 'required',
            '_thisid' => 'required'
        ]);
        
        $query = User::where('id',$request->_thisid)->delete();

        if($query){

            return response()->json(['success'=>'del new records.']);

            }else{

            return response()->json(['error'=>'del new records error.']); 

        }
    }
}
?>