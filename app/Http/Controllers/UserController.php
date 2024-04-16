<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Log;
use App\Models\Role_User;


class UserController extends Controller
{

    public function index()
    {
        if (Gate::allows('admin-manager')) {
            
            $users = User::all(); 
            $roles = Role::all();  

            return view('users.index')
            ->with('users',$users) 
            ->with('roles',$roles);
        }else{
            //abort(403);
            return back()->with('alerta','Sem permisão!');
        } 
    }

    

    public function profile($id)
    {   
        $users = User::whereId($id); 
        return view('users.profile')->with('users', $users);
   
    }

    public function show($id)
    { 
            $roles = Role::all(); 
            $user = User::find($id);  
            return view('users.profile')->with('user',$user)->with('roles',$roles);
            
    }

     
    public function alterarPW(Request $request, $id)
    {  
        $user = User::find($id);  
        $passwordBD = $user->password;
        $passwordAntInsert = $request->old_password;

        if (password_verify($passwordAntInsert, $passwordBD)) {
            // A senha antiga inserida  corresponde ao hash criptografado na BD
            if($request->password==$request->password_confirmation){  
                $newpass = $request->password;
                $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/';
                if (!preg_match($regex, $newpass)) {
                    return redirect()->back()->with('error', 'A nova password deve conter pelo menos uma letra maiúscula, uma letra minúscula, um número e ter pelo menos 6 caracteres.');
                }else{
                    $user->password = bcrypt($request->password); 
                    $user->save();  
                    Auth::logout(); // faz o logout 
                    return redirect()->route('login')->with('message', 'Password alterada com sucesso! Faça o login novamente.');

                } 
            }else{ 
                return redirect()->back()->with('error', 'As Passwords não conrespondem. Tente novamente!');
            }
        }else{
            // A senha não corresponde ao hash criptografado
            return redirect()->back()->with('error', 'A Password antiga não conresponde. Tente novamente!');
        }  
    }
 



   


    public function store(Request $request)
    {
        $user= new User();
        $ru= new Role_User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->typeUser=$request->typeUser;
        $user->estado=$request->estado;
        $user->password=Hash::make($request->password);
        if($request->foto) { 
          
        $nameBd= date('Y-m-d H-i-s').'.'.$request->foto->extension(); 
          $capaname = $request->foto->storeAs('users',$nameBd); 
          $user->foto=$nameBd;
        } 
        $ruser = Role::where('name',$request->typeUser)->get();
        foreach($ruser as $ruse){ 
            $ru->role_id=$ruse['id'];
        } 
        $user->typeUser=$request->typeUser;
        $user->save(); 
        
        $ru->user_id=$user->id;  
        $ru->created_at=date('Y-m-d H:i:s');
        $ru->save();

        $log = new Log;
        $log->user_id = auth()->user()->id;
        $log->user_name = auth()->user()->name;
        $log->id_evento = $user->id;
        $log->nome_evento = $user->name;
        $log->action = 'Criar User';
        $log->tipo_evento = "User";
        $log->ip_address = $request->ip();
        $log->user_agent = $request->userAgent();
        $log->save();

        return redirect('/users')->with('message','User registado com sucesso!');
    }
 

 
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $update=$request->all();
        $user->updated_at=date('Y-m-d H:i:s'); 
        $user->name=$request->name;
        $user->email=$request->email;
        $user->estado=$request->estado;
        $user->typeUser=$request->typeUser; 
        if($request->foto) { 
            $nameBd = date('Y-m-d H-i-s').'.'.$request->foto->extension(); 
          $capaname = $request->foto->storeAs('users',$nameBd); 
          $user->foto=$nameBd;
        } 
        $user->save(); 

        $log = new Log;
        $log->user_id = auth()->user()->id;
        $log->user_name = auth()->user()->name;
        $log->id_evento = $user->id;
        $log->nome_evento = $user->name;
        $log->action = 'Atualizar User';
        $log->tipo_evento = "User";
        $log->ip_address = $request->ip();
        $log->user_agent = $request->userAgent();
        $log->save();
        return back()->with('message','User editado com sucesso!');
    }

     
    public function destroy(Request $request, $id)
    {
       
 
        $user = User::find($id);
        $log = new Log; 
        $log->user_id = auth()->user()->id;
        $log->user_name = auth()->user()->name;
        $log->id_evento = $request->id; 
        $log->nome_evento = $user->name;
        $log->action = 'Apagar User';
        $log->tipo_evento = "User";
        $log->ip_address = $request->ip();
        $log->user_agent = $request->userAgent();
        $log->save();

        User::destroy($id);  

        return redirect('/users')->with('message','User removido com sucesso!');
    }

    public function desativar(Request $request,$id)
    {
        $user = User::find( $id);
        $user->estado="Inativo";
        $user->save();

        $log = new Log;
        $log->user_id = auth()->user()->id;
        $log->user_name = auth()->user()->name;
        $log->id_evento = $request->id; 
        $log->nome_evento = $user->name;
        $log->action = 'Desativar User';  
        $log->tipo_evento = "User";
        $log->ip_address = $request->ip();
        $log->user_agent = $request->userAgent();
        $log->save();
        return back()->with('message','User desativado com sucesso!');
    } 
    public function ativar(Request $request, $id)
    {
        $user = User::find($id);
        $user->estado="Ativo";
        $user->save();

        $log = new Log;
        $log->user_id = auth()->user()->id;
        $log->user_name = auth()->user()->name;
        $log->id_evento = $request->id;
        $log->nome_evento = $user->name;
        $log->action = 'Ativar User';  
        $log->tipo_evento = "User";
        $log->ip_address = $request->ip();
        $log->user_agent = $request->userAgent();
        $log->save();
        return back()->with('message','User ativado com sucesso!');
    } 
}