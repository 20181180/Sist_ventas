<?php

namespace App\Http\Controllers;

use App\Models\Informacion;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public $nombre;
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // $data = Informacion::select('*')->get();
        // //dd($data);
        // $image = $data->image;
        // $this->nombre = $data->empresa;
        return view('home');
    }

    // public function render()
    // {
    //     $data = Informacion::select('*')->get();
    //     //dd($data);
    //     $image = $data->image;

    //     $nombre = $data->empresa;
    //     return view('layouts.header', compact('image', 'nombre'));
    // }
}
