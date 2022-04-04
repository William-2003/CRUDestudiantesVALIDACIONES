<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\estudiante;

class Crud extends Component
{
    public $estudiantes, $id_estudiante,  $codigo, $nombre, $direccion, $telefono, $email;
    
    public $modal = 0 ;



    protected $rules = [
        'codigo' => 'required|min:2',
        'nombre' => 'required|min:2',
        'direccion' => 'required|min:2',
        'telefono' => 'required|min:2',
        'email' => 'required|email|unique:collaborator',
    ];


    public function render()
    {
        $this -> estudiantes = estudiante::all();
        return view('livewire.crud');
    }

    public function crear(){
        $this -> limpiarCampos();
        $this -> abrirModal();
    }

    public function limpiarCampos(){

        $this -> codigo = "";
        $this -> nombre = "";
        $this -> direccion = "";
        $this -> telefono = "";
        $this -> email = "";
        $this -> id = "";
        

    }
    public function abrirModal(){
        $this -> modal = true;
    }

    public function cerrarModal(){
        $this -> modal = false;
    }
    
    public function edit($id){
        $estudiante = estudiante::findOrFail($id);
        $this -> id_estudiante = $id;
        $this -> codigo = $estudiante -> codigo;
        $this -> nombre = $estudiante -> nombre;
        $this -> direccion = $estudiante -> direccion;
        $this -> telefono = $estudiante -> telefono;
        $this -> email = $estudiante -> email;
        $this->abrirModal();
    }
    public function eliminar($id){
        estudiante::find($id)->delete();
    }

    public function guardar(){

        
        $validatedData = $this->validate();
 
        estudiante::create($validatedData);
        estudiante::updateOrCreate(['id'=> $this -> id_estudiante],
        [
            'codigo' => $this-> codigo,
            'nombre' => $this -> nombre,
            'direccion' => $this -> direccion,
            'telefono' => $this -> telefono,
            'email' => $this -> email
        ]);
        $this->cerrarModal();
        $this->limpiarCampos();

    }
}