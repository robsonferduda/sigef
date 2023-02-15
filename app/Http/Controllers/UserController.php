<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use App\Utils;
use App\User;
use App\Models\Funcao;
use App\Models\Role;
use Laracasts\Flash\Flash;
use App\Models\Departamento;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    protected $evento;
    protected $breadcrumb;

    public function __construct()
    {
        $this->middleware('auth');
        $this->breadcrumb['icone'] = 'fa-user';
        $this->breadcrumb['titulo'] = 'Usuário';
        $this->breadcrumb['itens'] = array();

        $this->evento = Session::get('evento_id');
    }
    
    public function index()
    {
        if(!Auth::user()->hasPermission('perfil-usuario-listar')) {
            return view('auth/unauthorized');
        }
                
        $page_title = 'Usuários';
        $page_description = 'Listagem de Usuários';
        $users = User::all();

        return view('users/index', compact('page_title', 'page_description', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dptos = Departamento::orderBy('ds_departamento_dep')->get();
        $perfis = Role::orderBy('display_name')->get();
        $funcoes = Funcao::orderBy('ds_funcao_fun')->get();

        return view('users/create', compact('dptos','perfis','funcoes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $request->merge(['password' => \Hash::make($request->password)]);
            
            $user = User::create($request->all());

            if($request->role){
                $role = Role::find($request->role);

                if(!$user->hasRole($role->name))
                    $user->attachRole($role);                
            } 

            $retorno = array('flag' => true,
                             'msg' => "Dados inseridos com sucesso");
        } catch (\Illuminate\Database\QueryException $e) {
            $retorno = array('flag' => false,
                             'msg' => Utils::getDatabaseMessageByCode($e->getCode()));
        } catch (Exception $e) {
            $retorno = array('flag' => true,
                             'msg' => "Ocorreu um erro ao inserir o registro");
        }

        if ($retorno['flag']) {
            Flash::success($retorno['msg']);
            return redirect('users')->withInput();
        } else {
            Flash::error($retorno['msg']);
            return redirect('users/create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dptos = Departamento::orderBy('ds_departamento_dep')->get();
        $perfis = Role::orderBy('display_name')->get();
        $funcoes = Funcao::orderBy('ds_funcao_fun')->get();
        $user = User::findOrFail($id);

        return view('users/edit', compact('user','dptos','perfis','funcoes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        if($request->fl_senha)
            $request->merge(['password' => Hash::make($request->password)]);
        else
            unset($request['password']);

        try {
            
            if(!$request->fl_active) $user->fl_active = 'N';
            $user->update($request->all());

            if($request->role){
                $role = Role::find($request->role);

                if(!$user->hasRole($role->name))
                    $user->attachRole($role);                
            }            

            $retorno = array('flag' => true,
                             'msg' => "Dados atualizados com sucesso");
        } catch (\Illuminate\Database\QueryException $e) {
            $retorno = array('flag' => false,
                             'msg' => Utils::getDatabaseMessageByCode($e->getCode()));
        } catch (Exception $e) {
            $retorno = array('flag' => true,
                             'msg' => "Ocorreu um erro ao atualizar o registro");
        }

        if ($retorno['flag']) {
            Flash::success($retorno['msg']);
            if(Auth::user()->hasRole('administrador') or Auth::user()->hasRole('super-user'))
                return redirect('users')->withInput();
            else
                return redirect('meu-perfil')->withInput();
        } else {
            Flash::error($retorno['msg']);
            return redirect()->route('users.edit', $user->id)->withInput();
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd("Entrou na exclusão!");
    }

    public function permissions($id)
    {
        $user = User::findOrFail($id);

        $permissions = Permission::orderBy('display_name')->get();        
        $permissions_role = $user->getPermissionsRole();

        return view('users/permissions', compact('user','permissions','permissions_role'));
    }

    public function perfil()
    {
        Session::put('menu_pai','dashboard');
        
        $this->breadcrumb['itens'] = array(
            array('descricao' => 'Dashboard', 'url' => '/'),
            array('descricao' => 'Usuário', 'url' => '#'),
            array('descricao' => 'Meu Perfil', 'url' => 'meu-perfil')
        );

        $breadcrumb = $this->breadcrumb;
        $user = Auth::user();

        return view('users/perfil', compact('user','breadcrumb'));
    }
}
