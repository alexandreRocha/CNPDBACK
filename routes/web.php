<?php

use App\Http\Controllers\GeolocalizacaoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InterconexaoController;
use App\Http\Controllers\PedidoInformacaoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideovigilanciaController; 
use App\Http\Controllers\NoticiaController; 
use App\Http\Controllers\LegislacaoController; 
use App\Http\Controllers\PublicacoesController; 
use App\Http\Controllers\VideoController; 
use App\Http\Controllers\SidebarController;  
use App\Http\Controllers\ConselhospraticoController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\RoleController;  
use App\Http\Controllers\PermissionController;  
use App\Http\Controllers\RoleUserController;   
use App\Http\Controllers\BiometriaController;  
use App\Http\Controllers\GeralController;  
use App\Http\Controllers\TicController;  
use App\Http\Controllers\AutorizacaoRegistoController; 
use App\Http\Controllers\CommentController; 
use App\Http\Controllers\InspecaoController;  
use App\Http\Controllers\ReuniaoController;  
use App\Http\Controllers\FeriaController;
use App\Http\Controllers\ProcessoController;  
use Illuminate\Support\Facades\Auth;


 
//Dados grafico
Route::get('chart', [ChartJSController::class, 'index']);


Route::get('/', [HomeController::class,'login'])->middleware('auth');
Auth::routes();
Route::get('/home', [HomeController::class, 'home'])->name('home');

  
//PEDIDO DE INFORMACAO ROUTES
Route::resource("/pedidoInformacao",PedidoInformacaoController::class)->middleware('auth'); 
Route::get('/pedidosNovos', [PedidoInformacaoController::class, 'novosPedido'])->name('novosPedido');
Route::get('/pedidoInformacao/create', [PedidoInformacaoController::class, 'create'])->name('create');
Route::post('/pedidoInformacao', [PedidoInformacaoController::class, 'store'])->name('index')->middleware('auth');
Route::get('/pedidoInformacao/{id}', [PedidoInformacaoController::class, 'show'])->name('show')->middleware('auth');


//USERS ROUTES
Route::resource("/users",UserController::class)->middleware('auth');
Route::post('/users', [UserController::class, 'store'])->name('index')->middleware('auth');
Route::get('/deleteu/{id}', [UserController::class, 'destroy'])->name('destroy')->middleware('auth');
Route::get('/desativar/{id}', [UserController::class, 'desativar'])->name('index')->middleware('auth');
Route::get('/ativar/{id}', [UserController::class, 'ativar'])->name('index')->middleware('auth');
Route::get('/users/{profile}',[UserController::class, 'profile'])->name('users.profile');
Route::post('/alterarPW/{id}',[UserController::class, 'alterarPW'])->name('alterarPassword');
 
//CCTV ROUTES
Route::resource("/videovigilancia",VideovigilanciaController::class)->middleware('auth'); 
Route::get('/videovigilancia/{id}', [VideovigilanciaController::class, 'show'])->name('show')->middleware('auth');
Route::get('/gerar-pdfcctv/{id}/{idp}', [VideovigilanciaController::class, 'gerarPdfcctv'])->name('gerarPdfcctv');
Route::get('/videonovos', [VideovigilanciaController::class, 'videonovos'])->name('videonovos');


//GPS ROUTES
Route::resource("/geolocalizacao",GeolocalizacaoController::class)->middleware('auth');
Route::get('/geolocalizacao/{id}', [GeolocalizacaoController::class, 'show'])->name('show')->middleware('auth');
Route::get('/gerar-pdfgps/{id}/{idp}', [GeolocalizacaoController::class, 'gerarPdfgps'])->name('gerarPdfgps');
Route::get('/geonovos', [GeolocalizacaoController::class, 'geonovos'])->name('geonovos');

//INTERCONEXAO ROUTES
Route::resource("/interconexao",InterconexaoController::class)->middleware('auth');
Route::get('/interconexao/{id}', [InterconexaoController::class, 'show'])->name('show')->middleware('auth');
Route::get('/gerar-pdfinter/{id}/{idp}', [InterconexaoController::class, 'gerarPdfinter'])->name('gerarPdfinter');
Route::get('/internovos', [InterconexaoController::class, 'internovos'])->name('internovos');


//BIOMETRIA ROUTES
Route::resource("/biometria",BiometriaController::class)->middleware('auth');
//Route ::get('/download/{id}', [BiometriaController::class, 'download'])->name('download');
Route::get('/biometria/{id}', [BiometriaController::class, 'show'])->name('show')->middleware('auth');
Route::get('/gerar-pdfbio/{id}/{idp}', [BiometriaController::class, 'gerarPdfbio'])->name('gerarPdfbio');
Route::get('/bionovos', [BiometriaController::class, 'bionovos'])->name('bionovos');


//TIC ROUTES
Route::resource("/tic",TicController::class)->middleware('auth');
Route::get('/tic/{id}', [TicController::class, 'show'])->name('show')->middleware('auth');
Route::get('/gerar-pdftic/{id}/{idp}', [TicController::class, 'gerarPdftic'])->name('gerarPdftic');
Route::get('/ticnovos', [TicController::class, 'ticnovos'])->name('ticnovos');


//GERAL ROUTES
Route::resource("/geral",GeralController::class)->middleware('auth');
Route::get('/geral/{id}', [GeralController::class, 'show'])->name('show')->middleware('auth');
Route::get('/gerar-pdfgeral/{id}/{idp}', [GeralController::class, 'gerarPdfgeral'])->name('gerarPdfgeral');
Route::get('/geralnovos', [GeralController::class, 'geralnovos'])->name('geralnovos');


//NOTICIA ROUTES 
Route::resource("/noticia",NoticiaController::class)->middleware('auth'); 
Route::post('/noticia', [NoticiaController::class, 'store'])->name('index')->middleware('auth');
Route::get('/deleten/{id}', [NoticiaController::class, 'destroy'])->name('index')->middleware('auth');
Route::get('/unpublishn/{id}', [NoticiaController::class, 'unpublishn'])->name('index')->middleware('auth');
Route::get('/publishn/{id}', [NoticiaController::class, 'publishn'])->name('index')->middleware('auth');
 


//LEGISLACAO ROUTES 
Route::resource("/legislacao",LegislacaoController::class)->middleware('auth'); 
Route::post('/legislacao', [LegislacaoController::class, 'store'])->name('index')->middleware('auth');
Route::get('/deletel/{id}', [LegislacaoController::class, 'destroy'])->name('index')->middleware('auth');
Route::get('/unpublishl/{id}', [LegislacaoController::class, 'unpublishl'])->name('index')->middleware('auth');
Route::get('/publishl/{id}', [LegislacaoController::class, 'publishl'])->name('index')->middleware('auth');
 
 
//PUBLICACOES ROUTES 
Route::resource("/publicacoes",PublicacoesController::class)->middleware('auth'); 
Route::post('/publicacoes', [PublicacoesController::class, 'store'])->name('index')->middleware('auth');
Route::get('/deletep/{id}', [PublicacoesController::class, 'destroy'])->name('index')->middleware('auth');
Route::get('/unpublishp/{id}', [PublicacoesController::class, 'unpublishp'])->name('index')->middleware('auth');
Route::get('/publishp/{id}', [PublicacoesController::class, 'publishp'])->name('index')->middleware('auth');
 
//VIDEO ROUTES 
Route::resource("/video",VideoController::class)->middleware('auth'); 
Route::post('/video', [VideoController::class, 'store'])->name('index')->middleware('auth');
Route::get('/deletev/{id}', [VideoController::class, 'destroy'])->name('index')->middleware('auth');
Route::get('/unpublishv/{id}', [VideoController::class, 'unpublishv'])->name('index')->middleware('auth');
Route::get('/publishv/{id}', [VideoController::class, 'publishv'])->name('index')->middleware('auth');
 
//SIDEBAR ROUTES 
Route::resource("/sidebar",SidebarController::class)->middleware('auth'); 
Route::post('/sidebar', [SidebarController::class, 'store'])->name('index')->middleware('auth');
Route::get('/sidebardestroy/{id}', [SidebarController::class, 'destroy'])->name('sidebardestroy')->middleware('auth'); 
Route::get('/desabilitar/{id}', [SidebarController::class, 'desabilitar'])->name('index')->middleware('auth');
Route::get('/habilitar/{id}', [SidebarController::class, 'habilitar'])->name('index')->middleware('auth');
 
 //CONSELHOS PRATICOS ROUTES 
Route::resource("/conselhopratico",ConselhospraticoController::class)->middleware('auth'); 
Route::post('/conselhopratico', [ConselhospraticoController::class, 'store'])->name('index')->middleware('auth');
Route::get('/delete/{id}', [ConselhospraticoController::class, 'destroy'])->name('index')->middleware('auth');
Route::get('/unpublish/{id}', [ConselhospraticoController::class, 'unpublish'])->name('index')->middleware('auth');
Route::get('/publish/{id}', [ConselhospraticoController::class, 'publish'])->name('index')->middleware('auth');
 
 //ROLES ROUTES 
Route::resource("/roles",RoleController::class)->middleware('auth'); 
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store')->middleware('auth');
Route::get('/delete/{id}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('auth'); 
 
 

 //PERMISSIONS ROUTES 
 Route::resource("/permission",PermissionController::class)->middleware('auth'); 
 Route::post('/permission', [PermissionController::class, 'store'])->name('permission.index')->middleware('auth');
 Route::get('/delete/{id}', [PermissionController::class, 'destroy'])->name('permission.delete')->middleware('auth');
 
  //PERMISSIONS de users 
 Route::resource("/userpermissions",RoleUserController::class)->middleware('auth'); 
 Route::post('/userpermissions', [RoleUserController::class, 'store'])->name('userpermissions.index')->middleware('auth');
 Route::get('/delete/{id}', [PermissionController::class, 'destroy'])->name('userpermissions.delete')->middleware('auth');
 
  //LOGS ROUTES 
 Route::resource("/logssystem",LogsController::class)->middleware('auth'); 
 Route::post('/logssystem', [LogsController::class, 'store'])->name('logssystem.index')->middleware('auth');
 


//PROCESSOS ROUTES
Route::resource("/processos",ProcessoController::class)->middleware('auth');
Route::post('/processo/{id}', [ProcessoController::class, 'create'])->name('createProcesso');
Route::get('/processos/{id}', [ProcessoController::class, 'show'])->name('show')->middleware('auth');
Route::post('/gerarDuc', [ProcessoController::class, 'gerarDuc'])->name('gerarDuc');
Route::post('/gerarDucM', [ProcessoController::class, 'gerarDucM'])->name('gerarDucMultiplo');
Route::post('/submeterNovoDoc', [ProcessoController::class, 'submeterNovoDoc'])->name('submeterDoc');
Route::post('/enviarDucEmail', [ProcessoController::class, 'enviarDucEmail'])->name('sendDucEmail');
Route::post('/processoUrg', [ProcessoController::class, 'processoUrg'])->name('processoUrgente');
Route::post('/atribuirProcessoT', [ProcessoController::class, 'atribuirProcessoT'])->name('atribuirProcessoTecnicos'); 
Route::post('/atribuirProcessoM', [ProcessoController::class, 'atribuirProcessoM'])->name('atribuirProcessoMembros');
Route::post('/gerarAuto', [ProcessoController::class, 'gerarAuto'])->name('gerarAutomatico'); 
Route::get('/meusProcessos', [ProcessoController::class, 'meusProcessos'])->name('meusProcessos');
Route::get('/enviadosaMim', [ProcessoController::class, 'enviadosaMim'])->name('enviadosaMim');
Route::get('/paProvacao', [ProcessoController::class, 'paProvacao'])->name('paprovacao');
Route::post('/notificarSec', [ProcessoController::class, 'notificarSec'])->name('notificarSecretario');
Route::get('/notificarSecPaprov', [ProcessoController::class, 'notificarSecPaprov'])->name('notificarSecPaprov');
Route::get('/gerarNota/{idp}', [ProcessoController::class, 'gerarNota'])->name('gerarNota');  
Route::get('/aguardarNotaD', [ProcessoController::class, 'aguardarNotaD'])->name('aguardarNotas');
Route::get('/prontoEnvioAN', [ProcessoController::class, 'prontoEnvioAN'])->name('prontoEnvio');
Route::get('/enviarNotaAutoEmail/{idp}', [ProcessoController::class, 'enviarNotaAutoEmail'])->name('enviarNotaAuto');
Route::get('/qr-code', [ProcessoController::class, 'generateQrCode']);


//AUTORIZACOES ROUTES
Route::resource("/autorizacaoregisto",AutorizacaoRegistoController::class)->middleware('auth'); 
Route::get('/autorizacaoregisto/{id}', [AutorizacaoRegistoController::class, 'show'])->name('show')->middleware('auth'); 
Route::get('/minhasAuto', [AutorizacaoRegistoController::class, 'minhasAuto'])->name('minhasAuto');
Route::post('/anexarAuto', [AutorizacaoRegistoController::class, 'anexarAuto'])->name('anexarAuto');


//INSPECOES ROUTES
Route::resource("/inspecoes",InspecaoController::class)->middleware('auth'); 
Route::get('/inspecoes/{id}', [InspecaoController::class, 'show'])->name('show')->middleware('auth');  
Route::post('/realizarInspecoes', [InspecaoController::class, 'realizarInspecoes'])->name('realizarInspecoes');
Route::get('/minhasInspecoes', [InspecaoController::class, 'minhasInspecoes'])->name('minhasInspecoes');
Route::get('/gerarReportInsp/{id}', [InspecaoController::class, 'gerarReportInsp'])->name('gerarReportInsp');
Route::post('/addFotografia/{id}', [InspecaoController::class, 'addFotografia'])->name('addFotos');
 

//COMMENTS ROUTES
Route::post('/fazerObs', [CommentController::class, 'fazerObs'])->name('fazerObservacao');


//REUNIOES ROUTES
Route::resource("/reunioes",ReuniaoController::class)->middleware('auth'); 
Route::get('/reunioes/{id}', [ReuniaoController::class, 'show'])->name('show')->middleware('auth');  
Route::post('/agendarR', [ReuniaoController::class, 'agendarR'])->name('agendarReuniao');
Route::get('/gerarPdfOrdem/{id}', [ReuniaoController::class, 'gerarPdfOrdem'])->name('ordemPdf');
Route::get('/reunioesAgenda', [ReuniaoController::class, 'reunioesAgenda'])->name('reunioesAgenda');
Route::post('/confirmarR/{id}', [ReuniaoController::class, 'confirmarR'])->name('confirmarReuniao');
Route::get('/gerarAutoFinalPdf/{idp}', [ReuniaoController::class, 'gerarAutoFinalPdf'])->name('aprovarPdf');  
Route::post('/gerarAutoFinalWord/{idp}', [ReuniaoController::class, 'gerarAutoFinalWord'])->name('aprovarWord');
Route::post('/anexarAtaReuniao/{id}', [ReuniaoController::class, 'anexarAtaReuniao'])->name('anexarAta');  
Route::post('/processoNaoAprovado/{idr}/{idp}/{idRp}', [ReuniaoController::class, 'processoNaoAprovado'])->name('processonaoaprovado');  





/*
Route::get('/public/{any}', function () {
   abort(403, 'Forbidden');
})->where('any', '.*');
*/
Route::get('/public', function () {
   abort(403, 'Forbidden');
});

 Route::fallback(function () {
    return view('404');
    abort(404, 'Forbidden');
 });
  