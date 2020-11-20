<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Router;
use Redirect, Response;

class RouterInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Router::select('*'))
            ->addColumn('action', 'action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('list');
    }

    /*
     * Store a newly created resource in storage.
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
        return Response::json(array_merge((array) $router, ['status' => 1]));
    }

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $where = ['id' => $id];
        $router  = Router::where($where)->first();
    
        return Response::json($router);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $router = Router::where('id', $id)->delete();
        return Response::json($router);
    }
}
