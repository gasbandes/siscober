<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificaciones extends Model
{
    use HasFactory;


     protected $table = 'notificaciones';

    protected $fillable = [
        'titulo', 'texto', 'link', 'fecha'
    ];    

    public function usuarios(){
        return $this->belongsToMany(User::class, 'notificacion_usuarios', 'notificacion_id', 'usuario_id');
    }

    public static function crearNotificacion($titulo, $texto, $link, $link_texto){
        $usuario = \Auth::user();

        $notificacion = new Notificaciones();
        $notificacion->titulo = $titulo;
        $notificacion->texto = $texto;
        $notificacion->link = $link;
        $notificacion->link_texto = $link_texto;
        $notificacion->fecha = date("Y-m-d H:i:s");
        $notificacion->save();
       
        $usuario->notificaciones()->attach($notificacion);
        $usuario->save();
        
        Notificaciones::cargarNotificaciones();
    }

    public static function cargarNotificaciones(){
        $usuario = \Auth::user();
        $notificaciones = $usuario->notificaciones()->get();        
        session(['notificaciones' => null]);
        session(['notificaciones' => $notificaciones]);        
    }
} 
