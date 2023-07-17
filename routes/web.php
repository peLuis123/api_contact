<?php
use Illuminate\Http\Request;
use App\Models\Contacto;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/contact', [ContactController::class, 'send']);

Route::get('/verificar-conexion', function () {
    try {
        DB::connection()->getPdo();
        echo "Conexión exitosa a la base de datos.";
    } catch (\Exception $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }
});

Route::get('/contactos', function () {
    $contactos = Contacto::all();
    return response()->json($contactos);
});

Route::post('/contactos', function (Request $request) {
    $contacto = new Contacto();
    $contacto->nombre = $request->input('nombre');
    $contacto->correo = $request->input('correo');
    $contacto->telefono = $request->input('telefono');
    $contacto->mensaje = $request->input('mensaje');
    $contacto->save();

    return response()->json(['message' => 'Contacto agregado correctamente']);
});