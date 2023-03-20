<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Utils;
use App\User;
use App\Models\Local;
use App\Models\Evento;
use App\Models\TipoEvento;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class EventoController extends Controller
{
    protected $breadcrumb;

    public function __construct()
    {
        $this->middleware('auth');
        $this->breadcrumb['icone'] = 'fa-ticket-alt';
        $this->breadcrumb['titulo'] = 'Eventos';
        \Session::put('menu_pai','eventos');
    }

    public function index(Request $request)
    {
         /* Marcação de Menus */
         Session::put('menu_item','eventos');

         $this->breadcrumb['itens'] = array(
             array('descricao' => 'Dashboard', 'url' => '/'),
             array('descricao' => 'Eventos', 'url' => '#')
         );        
        $breadcrumb = $this->breadcrumb;

        $eventos = Evento::all();
            
        return view('evento/index', compact('breadcrumb','eventos'));
    }

    public function listar()
    {
        $eventos = Evento::all();

        return response()->json($eventos);
    }

    public function alterar(Request $request)
    {
        $evento = Evento::find($request->evento);
        \Session::put('evento_id', $evento->cd_evento_eef);
        \Session::put('evento_cod', $evento->cd_evento_eve);
        \Session::put('evento_nome', $evento->nm_evento_eef);
    }

    public function create()
    {
        /* Marcação de Menus */
        Session::put('menu_item','eventos');

        $this->breadcrumb['itens'] = array(
            array('descricao' => 'Dashboard', 'url' => '/'),
            array('descricao' => 'Eventos', 'url' => '#')
        );        
        $breadcrumb = $this->breadcrumb;

        $tipos = TipoEvento::all();

        return view('evento/create', compact('breadcrumb','tipos'));
    }

    public function edit($id)
    {
        /* Marcação de Menus */
        Session::put('menu_item','eventos');

        $this->breadcrumb['itens'] = array(
            array('descricao' => 'Dashboard', 'url' => '/'),
            array('descricao' => 'Eventos', 'url' => '#')
        );        
        $breadcrumb = $this->breadcrumb;

        $tipos = TipoEvento::all();
        $evento = Evento::find($id);

        return view('evento/edit', compact('breadcrumb','evento','tipos'));
    }

    public function store(Request $request)
    {
        try {

            $evento = Evento::create($request->all());
            Flash::success("Dados inseridos com sucesso");

        } catch (\Illuminate\Database\QueryException $e) {

            Flash::warning(Utils::getDatabaseMessageByCode($e->getCode()));

        } catch (Exception $e) {

            Flash::error("Ocorreu um erro ao inserir o registro");
        }

        return redirect('eventos')->withInput();
    }

    public function update(Request $request, Evento $evento)
    {

        try {

            $evento->update($request->all());
            Flash::success("Dados atualizados com sucesso");
            return redirect('eventos')->withInput();

        } catch (\Illuminate\Database\QueryException $e) {

            Flash::warning(Utils::getDatabaseMessageByCode($e->getCode()));

        } catch (Exception $e) {

            Flash::error("Ocorreu um erro ao inserir o registro");
        }

        return redirect()->back()->withInput();
    }

    public function destroy($id)
    {
        $evento = Evento::find($id);

        if($evento->locais->isEmpty()){
            $evento->delete();
            Flash::success('<i class="fas fa-check text-white mr-2"></i> Evento excluído com sucesso.');
        }else{
            Flash::warning('<i class="fas fa-exclamation text-white mr-2"></i> Não é possível excluir este evento, ele possui locais vinculados.');
        }

        return redirect('eventos')->withInput();
    }

    public function locais()
    {
        /* Marcação de Menus */
        Session::put('menu_item','eventos');

        $this->breadcrumb['icone'] = 'fas fa-map-marker';
        $this->breadcrumb['titulo'] = 'Locais Selecionados';
        $this->breadcrumb['itens'] = array(
            array('descricao' => 'Dashboard', 'url' => '/'),
            array('descricao' => 'Eventos', 'url' => 'eventos'),
            array('descricao' => 'Locais', 'url' => 'locais'),
            array('descricao' => 'Locais Selecionados', 'url' => '#')
        );        
        $breadcrumb = $this->breadcrumb;

        $evento = Evento::find(10);
        $locais_disponiveis = Local::whereNotIn('cd_local_prova_lop', $evento->locais->map->only('cd_local_prova_lop')->toArray())->orderBy('nm_local_prova_lop')->get();
        $locais_selecionados = $evento->locais;

        return view('evento/locais', compact('breadcrumb','locais_disponiveis','locais_selecionados'));
    }

    public function setores()
    {
        /* Marcação de Menus */
        Session::put('menu_item','eventos');

        $this->breadcrumb['icone'] = 'fas fa-building';
        $this->breadcrumb['titulo'] = 'Setores Selecionados';
        $this->breadcrumb['itens'] = array(
            array('descricao' => 'Dashboard', 'url' => '/'),
            array('descricao' => 'Eventos', 'url' => 'eventos'),
            array('descricao' => 'Locais', 'url' => 'locais'),
            array('descricao' => 'Setores', 'url' => 'setores'),
            array('descricao' => 'Setores Selecionados', 'url' => '#')
        );        
        $breadcrumb = $this->breadcrumb;

        $evento = Evento::find(10);
        $locais_disponiveis = $evento->locais;
        $locais_selecionados = $evento->locais;

        return view('evento/setores', compact('breadcrumb','locais_disponiveis','locais_selecionados'));
    }

    public function adicionarLocal($id)
    {
        $evento = Evento::find(10);
        $local = Local::find($id);

        $evento->locais()->attach($local);

        Flash::success('<i class="fas fa-check text-white mr-2"></i> Local <strong>'.$local->nm_local_prova_lop.'</strong> adicionado com sucesso.');
        return redirect('evento/locais')->withInput();
    }

    public function removerLocal($id)
    {
        $evento = Evento::find(10);
        $local = Local::find($id);

        $evento->locais()->detach($local);

        Flash::success('<i class="fas fa-check text-white mr-2"></i> Local <strong>'.$local->nm_local_prova_lop.'</strong> removido com sucesso.');
        return redirect('evento/locais')->withInput();
    }

}