<?php

namespace App\Http\Controllers;

use App\Models\Conselhospratico;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ConselhospraticoController extends Controller
{
    
    public function index()
    {
        if (Gate::allows('admin-manager')) {
            $consels = Conselhospratico::orderBy('created_at')->get();
            return view('conselhopratico.index')->with('consels',$consels);
         
        }else{
            //abort(403);
            return back()->with('alerta','Sem permisão!');
        } 
    }
 

    public function store(Request $request)
    {
        $consel = new Conselhospratico();  
        
        if($request->imagem) {
            $imagemname = $request->imagem;
            $nameBd=date('Y-m-d H-i-s').'.'.$request->imagem->extension(); 
          $imagemname = $request->imagem->storeAs('conselhopratico',$nameBd); 
          $consel->imagem=$nameBd;
        }   
        if($request->anexo) {
            $imagemname = $request->anexo;
            $nameBd=date('Y-m-d H-i-s').'.'.$request->anexo->extension(); 
          $imagemname = $request->anexo->storeAs('conselhopratico',$nameBd); 
          $consel->anexo=$nameBd;
        }       
        $consel->titulo=$request->titulo; 
        $consel->descricao=$request->descricao; 
        $consel->estado = $request->estado;  
        $consel->created_at=date('Y-m-d H:i:s');
        $consel->save();

        //logs

        $log = new Log;
        $log->user_id = auth()->user()->id;
        $log->user_name = auth()->user()->name;
        $log->id_evento = $request->id;
        $log->nome_evento = $request->titulo;
        $log->action = 'Criar Conselhos Práticos';
        $log->tipo_evento = "Conselhos Práticos";
        $log->ip_address = $request->ip();
        $log->user_agent = $request->userAgent();
        $log->save();

        return redirect('/conselhopratico')->with('message','Conselho prático publicado com sucesso!');
    }

    
   
    public function show($id)
    {
        $consels = Conselhospratico::find($id);
        return view('conselhopratico.show')->with('consels',$consels);
    } 
 
    public function update(Request $request, $id)
    {
        $consels = Conselhospratico::find($id); 
        if($request->imagem) {
            $imagemname = $request->imagem;
            $nameBd=date('Y-m-d H-i-s').'.'.$request->imagem->extension(); 
          $imagemname = $request->imagem->storeAs('conselhopratico',$nameBd); 
          $consels->imagem=$nameBd;
        }   
        if($request->anexo) {
            $imagemname = $request->anexo;
            $nameBd=date('Y-m-d H-i-s').'.'.$request->anexo->extension(); 
          $imagemname = $request->anexo->storeAs('conselhopratico',$nameBd); 
          $consels->anexo=$nameBd;
        }       
        $consels->titulo=$request->titulo;  
        $consels->estado = $request->estado;  
        $consels->descricao=$request->descricao;

        $consels->updated_at=date('Y-m-d H:i:s');  
        $consels->save();
         //logs

         $log = new Log;
         $log->user_id = auth()->user()->id;
         $log->user_name = auth()->user()->name;
         $log->id_evento = $request->id;
         $log->nome_evento = $request->titulo;
         $log->action = 'Atualizar Conselhos Práticos';
         $log->tipo_evento = "Conselhos Práticos";
         $log->ip_address = $request->ip();
         $log->user_agent = $request->userAgent();
         $log->save();

        return back()->with('message','Conselho Prático editado com sucesso!');
    }

    
    public function destroy( Request $request, $id)
    {
        $log = new Log;
        $log->user_id = auth()->user()->id;
        $log->user_name = auth()->user()->name;
        $log->id_evento = $request->id;
        $log->nome_evento = $request->titulo;
        $log->action = 'Apagar Conselhos Práticos';
        $log->tipo_evento = "Conselhos Práticos";
        $log->ip_address = $request->ip();
        $log->user_agent = $request->userAgent();
        $log->save();
        Conselhospratico::destroy($id);  
        return redirect('/conselhopratico')->with('message','Conselho Prático apagado com sucesso!');
    }

    public function unpublish( Request $request, $id)
    {
        $news = Conselhospratico::find($id);
        $news->estado="Despublicado";
        $news->save();
        $log = new Log;
        $log->user_id = auth()->user()->id;
        $log->user_name = auth()->user()->name;
        $log->id_evento = $request->id;
        $log->nome_evento = $request->titulo;
        $log->action = 'Despublicar Conselhos Práticos';
        $log->tipo_evento = "Conselhos Práticos";
        $log->ip_address = $request->ip();
        $log->user_agent = $request->userAgent();
        $log->save();
        return back()->with('message','Conselho Prático despublicado com sucesso!');
    } 
    public function publish($id)
    {
        $news = Conselhospratico::find($id);
        $news->estado="Publicado";
        $news->save();
        return back()->with('message','Conselho Prático publicado com sucesso!');
    } 



    //api para site

    public function ListarTodasApi()//pegar todos os ids
    { 
        $state="Publicado";
        return Conselhospratico::where('estado', $state)->orderBy('id', 'DESC')->get();
    }
    public function listarUltimos5()//pegar ultimos 3 ids
    { 
        $state="Publicado";
        $leis = Conselhospratico::limit(5)->latest()->where('estado', $state)->orderBy('id', 'DESC')->get();
        //$leis = Conselhospratico::limit(5)->latest()->orderBy('id', 'DESC')->get();
        return response($leis,200);
    }
    public function listarApiId($id)//pegar um id
    {
        $leis = Conselhospratico::find($id);
        return response($leis,200);
    } 
}
