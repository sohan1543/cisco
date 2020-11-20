<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Router;
use Illuminate\Support\Facades\Auth;

class RouterInfoController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $listBy = $request->list_by;
        $list = [];
        if($listBy == 'type') {
            $type = $request->type;
            $list = Router::where('type', '=', $type)->get();
        }
        if($listBy == 'sap_id') {
            $sap_id = $request->sap_id;
            $list = Router::where('sap_id', '=', $sap_id)->get();
        }
        if($listBy == 'range') {
            $starting_range = $request->starting_range;
            $ending_range = $request->ending_range;
            $list = Router::whereBetween('loopback', [$starting_range, $ending_range])->get();
        }
        return response()->json(['data'=>$list], $this->successStatus);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $routerId = $request->router_id;
        $data = [
            'sap_id' => $request->sap_id,
            'host_name' => $request->host_name,
            'type' => $request->type,
            'loopback' => $request->loopback,
            'mac_address' => $request->mac_address
        ];
        
        if (Router::where('sap_id', '=', $request->sap_id)->where('id', '<>', $routerId)->where('deleted_at', NULL)->first() !== null) {
            return Response::json([ 'status' => 0, 'msg' => 'SAP ID Already Exists' ]);
        }
        if (Router::where('host_name', '=', $request->host_name)->where('id', '<>', $routerId)->where('deleted_at', NULL)->first() !== null) {
            return Response::json([ 'status' => 0, 'msg' => 'HostName Already Exists' ]);
        }
        if (Router::where('loopback', '=', $request->loopback)->where('id', '<>', $routerId)->where('deleted_at', NULL)->first() !== null) {
            return Response::json([ 'status' => 0, 'msg' => 'Loopback Address Already Exists' ]);
        }
        if (Router::where('sap_id', '=', $request->mac_address)->where('id', '<>', $routerId)->where('deleted_at', NULL)->first() !== null) {
            return Response::json([ 'status' => 0, 'msg' => 'Mac Address Already Exists' ]);
        }
        $router = Router::updateOrCreate(['id' => $routerId], $data);
        // $router = is_object($router) ? json_
        return response()->json(['success'=>$router], $this->successStatus);
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
        $where = ['id' => $id];
        $router  = Router::where($where)->first();
    
        return Response::json($router);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $ip = $request->loopback;
        $routerInfo = Router::where('loopback', '<>', $ip)->where('deleted_at', NULL)->first();
        if(!isset($routerInfo)) {
            return response()->json(['failed'=> 'No Router Found in System'], $this->successStatus);
        }
        $routerId = $routerInfo->id;
        $data = [
            'sap_id' => $request->sap_id,
            'host_name' => $request->host_name,
            'type' => $request->type,
            'loopback' => $request->loopback,
            'mac_address' => $request->mac_address
        ];
        
        if (Router::where('sap_id', '=', $request->sap_id)->where('loopback', '<>', $ip)->where('deleted_at', NULL)->first() !== null) {
            return Response::json([ 'status' => 0, 'msg' => 'SAP ID Already Exists' ]);
        }
        if (Router::where('host_name', '=', $request->host_name)->where('loopback', '<>', $ip)->where('deleted_at', NULL)->first() !== null) {
            return Response::json([ 'status' => 0, 'msg' => 'HostName Already Exists' ]);
        }
        if (Router::where('loopback', '=', $request->loopback)->where('loopback', '<>', $ip)->where('deleted_at', NULL)->first() !== null) {
            return Response::json([ 'status' => 0, 'msg' => 'Loopback Address Already Exists' ]);
        }
        if (Router::where('sap_id', '=', $request->mac_address)->where('loopback', '<>', $ip)->where('deleted_at', NULL)->first() !== null) {
            return Response::json([ 'status' => 0, 'msg' => 'Mac Address Already Exists' ]);
        }
        $router = Router::updateOrCreate(['id' => $routerId], $data);
        // $router = is_object($router) ? json_
        return response()->json(['success'=>$router], $this->successStatus);
    }

    public function destroy(Request $request)
    {
        $ip = $request->loopback;
        $router = Router::where('loopback', '=', $ip)->delete();
        return response()->json(['success'=>$router], $this->successStatus);
    }
}
