<?php

namespace App\Http\Controllers;

use Auth;
use App\user;
use App\Models\Sistema;
use Carbon\Carbon;
use App\Models\Audits;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AuditoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        //dd($request);
        $data     = $request->get('data');
        $sistema  = $request->sistema;
        $operacao = $request->operacao;
        $usuario  = $request->usuario;

        $page_title = 'Auditoria';
        $page_description = 'Registros de Atividade';

        $users = User::orderBy('name')->get();
        $sistemas = Sistema::orderBy('ds_sistema_sis')->get();

        if ($request->ajax()) {
           // dd($operacao);
            $auditorias = Audits::with('sistema')
                          ->with('user')
                          ->with('evento')
                          ->when($data, function ($query) use ($data) {
                              return $query->whereDate('created_at', $data);
                          })
                          ->when($sistema, function ($query) use ($sistema) {
                              return $query->where('cd_sistema_sis', $sistema);
                          })
                          ->when($operacao, function ($query) use ($operacao) {
                              return $query->where('event', $operacao);
                          })
                          ->when($usuario, function ($query) use ($usuario) {
                              return $query->where('user_id', $usuario);
                          })
                          ->select('id', 'created_at', 'user_id', 'cd_sistema_sis', 'auditable_type', 'event')
                          ->orderBy('created_at', 'DESC')
                          ->get();

            return DataTables::of($auditorias)
            ->addColumn('data', function ($auditoria) {
                return date('d/m/Y H:i', strtotime($auditoria->created_at));
            })
            ->addColumn('sistema', function ($auditoria) {
                return ($auditoria->sistema) ? $auditoria->sistema->ds_sistema_sis : 'Não definido';
            })
            ->addColumn('usuario', function ($auditoria) {
                return ($auditoria->user) ? $auditoria->user->name : 'Não identificado' ;
            })
            ->addColumn('operacao', function ($auditoria) {
                return array('evento' => (($auditoria->evento) ? $auditoria->evento->ds_evento_eva : 'Não definido '.$auditoria->event), 'tipo' => $auditoria->auditable_type);
            })
            ->addColumn('acoes', function ($auditoria) {
                return  '<a href="auditoria/'.$auditoria->id.'">Ver</a>';
            })
            ->rawColumns(['acoes'])
            ->make(true);
        }
        
        return view('auditoria.index', compact('page_title', 'page_description', 'users', 'sistemas'));
    }

    public function show($id)
    {
        $page_title = 'Auditoria';
        $page_description = 'Detalhes da Atividade';
        $auditoria = Audits::find($id);

        return view('auditoria.detalhes', compact('page_title', 'page_description', 'auditoria'));
    }

    public function getTotais()
    {
        if(Auth::user()->hasRole('administrador') or Auth::user()->hasRole('super-user'))
            return response()->json((new Audits())->getTotais());
        else
            return response()->json((new Audits())->getTotaisUsuario(Auth::user()->id));
    }
}
