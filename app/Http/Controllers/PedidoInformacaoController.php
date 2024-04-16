<?php

namespace App\Http\Controllers;

use App\Models\PedidoInformacao;
use Illuminate\Database\DBAL\TimestampType; 
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Mail;


class PedidoInformacaoController extends Controller
{

    public function index()
    {
        if (Gate::allows('pedidos-informacao')) { 
            $pedidos = PedidoInformacao::all();
            return view('pedidoInformacao.index')->with('pedidos',$pedidos);
        }else{
            //abort(403);
            return back()->with('alerta','Sem permisão!');
        } 
    }

    
    public function novosPedido()
    {
        if (Gate::allows('pedidos-informacao')) {  
            $pedidos = PedidoInformacao::where('estado', 'Novo')->get();
            return view('pedidoInformacao.novos')->with('pedidos',$pedidos);
        }else{
            //abort(403);
            return back()->with('alerta','Sem permisão!');
        } 
    }


    public function create()
    {
        return view('pedidoInformacao.create');
    }
    

    public function store(Request $request)
    {
        $pedidos= new PedidoInformacao();

        $pedidos->nome=$request->nome;
        $pedidos->morada=$request->morada;
        $pedidos->telefone=$request->telefone;
        $pedidos->email=$request->email;
        $pedidos->assunto=$request->assunto;
        $pedidos->duvida=$request->duvida; 
        $pedidos->estado="Novo";   
        $pedidos->created_at=date('Y-m-d H:i:s');
        $pedidos->save();
        $pedidos->num_p=$pedidos->id ."_".date('Y'); 
        $pedidos->save();
        return response()->json([
            "message" => "Sua mensagem foi enviada para o Central de Apoio da CNPD!"
        ], 201);
       // return redirect('/pedidoInformacao')->with('message','Registo efetuado com sucesso!');
    }

    public function show($id)
    {
        $pedido = PedidoInformacao::find($id);
        return view('pedidoInformacao.show')->with('pedido',$pedido);
    }

    public function edit($id)
    {
        $pedido = PedidoInformacao::find($id);
        return view('pedidoInformacao.edit')->with('pedido',$pedido);
    }


    public function update(Request $request, $id)
    {
        $pedido = PedidoInformacao::find($id);
        $update=$request->all();
        $pedido->data_r=date('Y-m-d H:i:s');
        $pedido->estado="Respondido";   
        $pedido->update($update);

        //EMAIL AO REQUERENTE
        $data["email"] = $pedido->email;  
 
        $data["title"] = "Resposta CNPD - ".$pedido->assunto; 
        $data["body"] = "
        Bom dia,
        <br>
        Segue a resposta à sua dúvida:  <br> $pedido->assunto.
        <br><br>
        <b>$pedido->resposta.</b>
        <br>  <br>   
        Cmprts<br>  
        Comissão Nacional de Protecção de Dados - CNPD<br> 
        Av. da China, Rampa Terra Branca, Apartado 1002 - C.P. 7600<br> 
        Tel: 5340390   https://www.cnpd.cv  cnpd@cnpd.cv";
      
     
        Mail::send('mail.Test_mail', $data, function ($message) use ($data) {
            $message->to($data["email"])
            ->subject($data["title"]);
        });
         

        return redirect('pedidoInformacao')->with('message','Pedido respondido com sucesso!'); 
    }

    public function destroy($id)
    {

    }
}
