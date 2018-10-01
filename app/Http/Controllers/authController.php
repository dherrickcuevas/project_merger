<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use DB;
use App\Authentication;
use App\AuthenticationItems;
use Carbon\Carbon;

	
class authController extends Controller
{
	 public function index(){
		$auths = Authentication::where('deleted_at', '=', NULL )->get();
		return view('pages.auth.index',compact('auths'));
	 }
	 public function create(){

        $auths = Authentication::all();
	 	return view('pages.auth.form',compact('auths'));
	 }
	 public function store(Request $request){
	 	$authenticate = new Authentication;

	 	$authenticate->name=$request['auth_name'];
	 	$authenticate->order_id=$request['auth_order'];
	 	$authenticate->icon=$request['auth_icon'];
	 	$authenticate->parent_id=$request['auth_parent'];
	 	$authenticate->path=$request['auth_path'];
	 	$authenticate->save();
	 	$authsID = Authentication::orderby('id','DESC')->pluck('id')->first();
	 	$auth_items =  new AuthenticationItems;
	 	$auth_items->auth_id = $authsID;
	 	$auth_items->save();
	 	 $auths = Authentication::where('deleted_at', '=', NULL )->get();
		return view('pages.auth.index',compact('auths'));
	 }
	 public function edit($authId){
	 	 $auths_edit = Authentication::where('id', $authId)->get();
	 	 $auths = Authentication::all();
	 	return view('pages.auth.edit',compact('auths','auths_edit'));
	 }
	 public function delete($authId){
	 	 $delete_auths = Authentication::where('id', $authId)->update([
           'deleted_at' =>  Carbon::now()
        ]);
	 	$auths = Authentication::where('deleted_at', '=', NULL )->get();
		return view('pages.auth.index',compact('auths'));
	 }
	  public function update(Request $request, $authId){
	 	 $update_auths = Authentication::where('id', $authId)->update([
         'name'  => $request['auth_name_edit'],
         'order_id' =>  $request['auth_order_edit'],
         'icon' => $request['auth_icon_edit'],
         'parent_id' =>  $request['auth_parent_edit'],
         'path' =>  $request['auth_path_edit']
       ]);
	 	 $auths = Authentication::where('deleted_at', '=', NULL )->get();
		return view('pages.auth.index',compact('auths'));
	}
}
?>