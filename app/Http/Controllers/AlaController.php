<?php

namespace App\Http\Controllers;

use App\Models\Bloco;
use App\Models\Pavimento;
use App\Models\Setor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\Types\Boolean;
use Yajra\DataTables\DataTables;

class AlaController extends Controller
{
    protected $evento;
    protected $breadcrumb;

    public function __construct()
    {
        //$this->middleware('auth');
        $this->breadcrumb['icone'] = 'fas fa-list-alt';
        $this->breadcrumb['titulo'] = 'Alas';
        $this->breadcrumb['itens'] = array();

        \Session::put('menu_pai','ala');

        $this->evento = Session::get('evento_id');
    }

    public function index()
    {
        $breadcrumb = $this->breadcrumb;

        return view('ala.index', compact('breadcrumb'));
    }

    public function create()
    {
        $breadcrumb = $this->breadcrumb;

        return view('ala.create', compact('breadcrumb'));
    }

    public function listar(Request $request)
    {
        
    }

    public function novo(Request $request)
    {
    
    }

    public function editar(Request $request, $pavimento)
    {
        
    }
}