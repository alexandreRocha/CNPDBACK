<?php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.

use App\Models\PedidoInformacao;
use App\Models\Videovigilancia;
use App\Models\Geolocalizacao;
use App\Models\Interconexao;
use App\Models\Noticia;
use App\Models\Geral;
use App\Models\Biometria;
use App\Models\Tic;
use App\Models\Legislacao;
use App\Models\Publicacoes;
use App\Models\Video;
use App\Models\Sidebar;
use App\Models\user;
use App\Models\Conselhospratico;
use App\Models\Role_User;
use App\Models\Log;
use App\Models\Processo;
use App\Models\Inspecao;
use App\Models\AutorizacaoRegisto;
use App\Models\Reuniao;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;




use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

/************************************HOME****************************************** */

// Home
Breadcrumbs::for('Dashboard', function ($trail) {
    $trail->push('Dashboard', route('home'));
});

/************************************PEDIDO INFORMACAO****************************************** */

// Home > LISTAR
Breadcrumbs::for('Pedidos Informação', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Pedidos Informação', route('pedidoInformacao.index'));
}); 
//show id
Breadcrumbs::for('Ver Pedido', function (BreadcrumbTrail $trail, PedidoInformacao $pedido) {
    $trail->parent('Pedidos Informação', route('pedidoInformacao.index'));
    $trail->push("Pedido Nº. ".$pedido->num_p, route('show', $pedido));
});

//editar
Breadcrumbs::for('Responder Pedido', function (BreadcrumbTrail $trail, PedidoInformacao $pedido) {
    $trail->parent('Pedidos Informação', route('pedidoInformacao.index'));
    $trail->push("Responder Pedido Nº. ".$pedido->num_p, route('pedidoInformacao.edit', $pedido));
});

/************************************USERS****************************************** */

// Home > USERS
Breadcrumbs::for('Lista Users', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Lista Users', route('users.index'));
});
 
//MOSTRAR id
Breadcrumbs::for('Ver User', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('Lista Users', route('users.index'));
    $trail->push("User ID - ".$user->id, route('show', $user));
});

/******************************************CCTV****************************************** */
// LISTA TODOS CCTV
Breadcrumbs::for('Formulários CCTV', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Formulários CCTV', route('videovigilancia.index'));
});

//MOSTRAR id
Breadcrumbs::for('Ver CCTV', function (BreadcrumbTrail $trail, Videovigilancia $pedido) {
    $trail->parent('Formulários CCTV', route('videovigilancia.index'));
    $trail->push("Formulário Videovigilância ID - ".$pedido->id, route('show', $pedido));
});


/******************************************GPS****************************************** */
// LISTA TODOS GPS
Breadcrumbs::for('Formulários GPS', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Formulários GPS', route('geolocalizacao.index'));
});

//MOSTRAR id
Breadcrumbs::for('Ver GPS', function (BreadcrumbTrail $trail, Geolocalizacao $pedido) {
    $trail->parent('Formulários GPS', route('geolocalizacao.index'));
    $trail->push("Formulário Geolocalização ID - ".$pedido->id, route('show', $pedido));
});

/******************************************INTERCONEXAO****************************************** */
// LISTA TODOS INTERCONEXAO
Breadcrumbs::for('Formulários Interconexão', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Formulários Interconexão', route('interconexao.index'));
});

//MOSTRAR id
Breadcrumbs::for('Ver Interconexão', function (BreadcrumbTrail $trail, Interconexao $pedido) {
    $trail->parent('Formulários Interconexão', route('interconexao.index'));
    $trail->push("Formulário Interconexão ID - ".$pedido->id, route('show', $pedido));
});


//******************************************Biometria****************************************** */
// LISTA TODOS BIOMETRIA
Breadcrumbs::for('Formulários Biometria', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Formulários Biometria', route('biometria.index'));
});

//MOSTRAR id
Breadcrumbs::for('Ver Biometria', function (BreadcrumbTrail $trail, Biometria $pedido) {
    $trail->parent('Formulários Biometria', route('biometria.index'));
    $trail->push("Formulário Biometria ID - ".$pedido->id, route('show', $pedido));
});

//******************************************TIC****************************************** */
// LISTA TODOS TICS
Breadcrumbs::for('Formulários TIC', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Formulários TIC', route('tic.index'));
});

//MOSTRAR id
Breadcrumbs::for('Ver TIC', function (BreadcrumbTrail $trail, Tic $pedido) {
    $trail->parent('Formulários Biometria', route('tic.index'));
    $trail->push("Formulário TIC ID - ".$pedido->id, route('show', $pedido));
});

//******************************************GERAl****************************************** */
// LISTA TODOS Gerals
Breadcrumbs::for('Formulários Geral', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Formulários Geral', route('geral.index'));
});

//MOSTRAR id
Breadcrumbs::for('Ver Geral', function (BreadcrumbTrail $trail, Geral $pedido) {
    $trail->parent('Formulários Geral', route('geral.index'));
    $trail->push("Formulário Geral ID - ".$pedido->id, route('show', $pedido));
});

/******************************************NOTICIAS****************************************** */
// LISTA TODOS AS NOTICIAS
Breadcrumbs::for('Notícias', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Notícias', route('noticia.index'));
});
//MOSTRAR id
Breadcrumbs::for('Ver Notícia', function (BreadcrumbTrail $trail, Noticia $news) {
    $trail->parent('Notícias', route('noticia.index'));
    $trail->push("Notícia ID - ".$news->id, route('show', $news));
});
 /******************************************LEGISLACAO****************************************** */
// LISTA TODOS AS LEGISLACAO
Breadcrumbs::for('Legislação', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Legislação', route('legislacao.index'));
});
//MOSTRAR id
Breadcrumbs::for('Lei ID', function (BreadcrumbTrail $trail, Legislacao $leis) {
    $trail->parent('Legislação', route('legislacao.index'));
    $trail->push("Legislação ID - ".$leis->id, route('show', $leis));
});

 /******************************************PUBLICACOES****************************************** */
// LISTA TODOS AS PUBLICACOES
Breadcrumbs::for('Publicações', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Publicações', route('publicacoes.index'));
});
//MOSTRAR id
Breadcrumbs::for('Publicação ID', function (BreadcrumbTrail $trail, Publicacoes $pubs) {
    $trail->parent('Publicações', route('publicacoes.index'));
    $trail->push("Publicação ID - ".$pubs->id, route('show', $pubs));
});
/******************************************VIDEOS****************************************** */
// LISTA TODOS OS VIDEOS
Breadcrumbs::for('Videos', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Videos', route('video.index'));
});
//MOSTRAR id
Breadcrumbs::for('Ver Video', function (BreadcrumbTrail $trail, Video $vide) {
    $trail->parent('Videos', route('video.index'));
    $trail->push("Video ID - ".$vide->id, route('show', $vide));
});
/******************************************VIDEOS****************************************** */
// LISTA TODOS OS SIDEBARS
Breadcrumbs::for('Menu', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Menu', route('sidebar.index'));
});
//MOSTRAR id
Breadcrumbs::for('Ver Menu', function (BreadcrumbTrail $trail, Sidebar $side) {
    $trail->parent('Menu', route('sidebar.index'));
    $trail->push("Menu ID - ".$side->id, route('show', $side));
});

/******************************************CONSELHOS PRATICOS****************************************** */
 // LISTA TODOS OS CONSELHOS PRATICOS
Breadcrumbs::for('Conselhos Práticos', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Conselhos Práticos', route('conselhopratico.index'));
});
//MOSTRAR id
Breadcrumbs::for('Ver Conselho Prático', function (BreadcrumbTrail $trail, Conselhospratico $consel) {
    $trail->parent('Conselhos Práticos', route('conselhopratico.index'));
    $trail->push("Conselho Prático ID - ".$consel->id, route('show', $consel));
});

 
/******************************************PERMISSION  ****************************************** */
 // LISTA TODOS OS ROLES USERS 
  Breadcrumbs::for('Permissions', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Permissions', route('permission.index'));
});
//MOSTRAR id
Breadcrumbs::for('Ver Permission', function (BreadcrumbTrail $trail, Permission $permission) {
    $trail->parent('Permissions', route('permission.index'));
    $trail->push("Permission ID - ".$permission->id, route('show', $permission));
});

 /******************************************VIDEOS****************************************** */
// LISTA TODOS OS ROLESIDEBARS
Breadcrumbs::for('Roles', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Roles', route('roles.index'));
});
//MOSTRAR id
Breadcrumbs::for('Ver Role', function (BreadcrumbTrail $trail, Role $role) {
    $trail->parent('Roles', route('roles.index'));
    $trail->push("Role ID - ".$role->id, route('show', $role));
});


// LISTA TODAS AS PERMISSOES DE UM USER
Breadcrumbs::for('Permissões de Users', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Permissões de Users', route('userpermissions.index'));
});
//MOSTRAR id
Breadcrumbs::for('Ver Permissão', function (BreadcrumbTrail $trail, Role_User $upermission) {
    $trail->parent('Permissões de Users', route('userpermissions.index'));
    $trail->push("Permissão ID - ".$upermission->id, route('show', $upermission));
});



// LISTA TODOS OS LOGS
Breadcrumbs::for('Logs', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Logs', route('logssystem.index'));
});
//MOSTRAR id
Breadcrumbs::for('Ver Logs', function (BreadcrumbTrail $trail, Log $log) {
    $trail->parent('Logs', route('logssystem.index'));
    $trail->push("Log ID - ".$log->id, route('show', $log));
});

// LISTA TODOS OS PROCESSOS
Breadcrumbs::for('Processos', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Processos', route('processos.index'));
});
//MOSTRAR id
Breadcrumbs::for('Ver Processo', function (BreadcrumbTrail $trail, Processo $processo) {
    $trail->parent('Processos', route('processos.index'));
    $trail->push("Processo ID - ".$processo->id, route('show', $processo));
});

// LISTA TODOS OS PROCESSOS DE UM USER

Breadcrumbs::for('Meus Processos', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Meus Processos', route('processos.index'));
});

// LISTA TODOS OS PROCESSOS PARA APROVAR 
Breadcrumbs::for('Processos Aprovados', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Processos Aprovados', route('processos.index'));
});

// LISTA TODOS OS PROCESSOS PRONTOS PARA ENVIAR AO REQUERENTE
Breadcrumbs::for('Processos Prontos', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Processos Prontos', route('processos.index'));
});
// LISTA TODOS OS PROCESSOS PARA GERAR NOTA DESPACHO

Breadcrumbs::for('Processos para Aprovação', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Processos para Aprovação', route('processos.index'));
});

// LISTA TODOS OS AUTORIZACAOS
Breadcrumbs::for('Autorização', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Autorização', route('autorizacaoregisto.index'));
});
//MOSTRAR id
Breadcrumbs::for('Ver Autorização', function (BreadcrumbTrail $trail, AutorizacaoRegisto $autoid) {
    $trail->parent('Autorização', route('autorizacaoregisto.index'));
    $trail->push("Autorização ID - ".$autoid->id, route('show', $autoid));
});

// LISTA TODOS AS AUTOS DE UM USER

Breadcrumbs::for('Minhas Autorizações', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Minhas Autorizações', route('autorizacaoregisto.index'));
});


// LISTA TODOS AS INSPECOES
Breadcrumbs::for('Inspeções', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Inspeções', route('autorizacaoregisto.index'));
});
//MOSTRAR id
Breadcrumbs::for('Ver Inspeção', function (BreadcrumbTrail $trail, Inspecao $autoid) {
    $trail->parent('Inspeções', route('inspecoes.index'));
    $trail->push("Inspeção ID - ".$autoid->id, route('show', $autoid));
});
// LISTA TODOS AS INSPECOES DE UM USER

Breadcrumbs::for('Minhas Inspeções', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Minhas Inspeções', route('inspecoes.index'));
});




// LISTA TODOS AS REUNIOES
Breadcrumbs::for('Reuniões', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Reuniões', route('reunioes.index'));
});
//MOSTRAR id
Breadcrumbs::for('Ver Reunião', function (BreadcrumbTrail $trail, Reuniao $reuniao) {
    $trail->parent('Reuniões', route('reunioes.index'));
    $trail->push("Reunião ID - ".$reuniao->id, route('show', $reuniao));
});
 
?> 