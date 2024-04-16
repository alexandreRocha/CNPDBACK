<?php

namespace App\Http\Controllers;
 
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;
use App\Models\Log;

class PermissionController extends Controller
{
     
    public function index()
    { 
        if (Gate::allows('admin-manager')) {
            $permissions = Permission::orderBy('created_at')->get();
            return view('permission.index')->with('permissions',$permissions);
         }else{
            //abort(403);
            return back()->with('alerta','Sem permisão!');
        }  
    } 
     
    public function store(Request $request)
    {
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->guard_name = "web"; 
        $permission->created_at = date('Y-m-d H:i:s');
        $permission->save(); 
        return back()->with('message','Permissão criado com sucesso!');
        // logs

        $log = new Log;
        $log->user_id = auth()->user()->id;
        $log->user_name = auth()->user()->name;
        $log->id_evento = $request->id;
        $log->nome_evento = $request->name;
        $log->action = 'Criar Permissao';
        $log->tipo_evento = "Permissao";
        $log->ip_address = $request->ip();
        $log->user_agent = $request->userAgent();
        $log->save();
    }

     
    public function show($id)
    {
         
            $permission = Permission::find($id);
            return view('permission.show')->with('permission',$permission);    
        
    } 
    
    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        $update=$request->all();
        $permission->updated_at=date('Y-m-d H:i:s'); 
        $permission->name=$request->name;
        $permission->guard_name = "web"; 
        
        $permission->save();

        //logs

        $log = new Log;
        $log->user_id = auth()->user()->id;
        $log->user_name = auth()->user()->name;
        $log->id_evento = $request->id;
        $log->nome_evento = $request->name;
        $log->action = 'Atualizar Permissao';
        $log->tipo_evento = "Permissao";
        $log->ip_address = $request->ip();
        $log->user_agent = $request->userAgent();
        $log->save();
        
        return back()->with('message','Permissão editado com sucesso!');
    }
 
     public function destroy($id)
    {
        Permission::destroy($id);  
        return redirect('/permission')->with('message','Permissão eliminado com sucesso!');
    }
 
}
