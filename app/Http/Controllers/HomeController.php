<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    protected $evento;
    protected $breadcrumb;

    public function __construct()
    {
        $this->middleware('auth');
        $this->breadcrumb['icone'] = 'fa-chart-pie';
        $this->breadcrumb['titulo'] = 'Dashboard';
        $this->breadcrumb['itens'] = array();

        Session::forget('menu_item');
        Session::forget('menu_subitem');

        $this->evento = Session::get('evento_id');
    }

    public function index()
    {
        Session::put('menu_pai','dashboard');
        $breadcrumb = $this->breadcrumb;

        $total_locais = null;
        $total_setores = null;
        $evento = Evento::find($this->evento);

        if($evento){
            $total_locais = ($evento->locais) ? $evento->locais->count() : 0;
            $total_setores = ($evento->setores) ? $evento->setores->count() : 0;
        }
        
        $total_grupos = Grupo::where('cd_evento_eef', $this->evento)->count();

        return view('home', compact('breadcrumb','total_locais','total_setores','total_grupos'));
    }

}
