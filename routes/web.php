<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\inicio_sesion\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ========================================================================
// ========================================================================

// Route::middleware(['web'])->group(function () {
Route::middleware(['web', 'prevent-back-history'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    })->name('login');
    
    // ========================================================================
    // ========================================================================

    // Rutas públicas
    Route::redirect('/', '/login');
    Route::get('/login', [LoginController::class, 'index'])->name('login');

    // ========================================================================
    // ========================================================================

    // LOGIN
    Route::group(['namespace' => 'App\Http\Controllers\inicio_sesion'], function () {
        Route::resource('login', 'LoginController');
        Route::get('login_usuario', 'LoginController@index')->name('login_usuario');
        Route::get('logout', 'LoginController@logout')->name('logout');
        // CAMBIAR CLAVE
        Route::post('cambiar_clave', 'LoginController@cambiarClave')->name('cambiar_clave');
        Route::post('cambiar_clave_update', 'LoginController@cambiarClaveUpdate')->name('cambiar_clave_update');
        // RECUPERAR CLAVE
        Route::get('recuperar_clave', 'LoginController@recuperarClave')->name('recuperar_clave');
        Route::post('recuperar_clave_email', 'LoginController@recuperarClaveEmail')->name('recuperar_clave_email');
        Route::get('recuperar_clave_link/{usuIdRecuperarClave}', 'LoginController@recuperarClaveLink')->name('recuperar_clave_link');
        Route::post('recuperar_clave_update', 'LoginController@recuperarClaveUpdate')->name('recuperar_clave_update');
    });

    // RUTAS PROTEGIDAS
    Route::middleware(['verificar.sesion', 'check.diasplan.alert'])->group(function () {

        // HOME
        Route::group(['namespace' => 'App\Http\Controllers\home'], function () {
            Route::resource('home', 'HomeController');
            Route::resource('permisos', 'PermisosController');
            Route::post('eliminar', 'PermisosController@eliminar')->name('eliminar');

            // Rutas para manejo de permisos
            Route::get('/permisos', 'PermisosController@index')->name('permisos.index');
            Route::get('/obtener-permisos-usuario/{id}', 'PermisosController@obtenerPermisosUsuario');
            Route::post('/guardar-permisos-usuario', 'PermisosController@guardarPermisosUsuario');
        });

        // ========================================================================
        // ========================================================================

        // USUARIOS
        Route::group(['namespace' => 'App\Http\Controllers\usuarios'], function () {
            Route::resource('usuarios', 'UsuariosController');
            Route::post('email_validator', 'UsuariosController@emailValidator')->name('email_validator');
            Route::post('identification_validator', 'UsuariosController@identificationValidator')->name('identification_validator');
        });

        // ========================================================================
        // ========================================================================

        // PERSONAS
        Route::group(['namespace' => 'App\Http\Controllers\personas'], function () {
            Route::resource('personas', 'PersonasController');
            Route::get('listar_proveedores', 'PersonasController@listarProveedores')->name('listar_proveedores');
            Route::get('listar_clientes', 'PersonasController@listarClientes')->name('listar_clientes');
        });

        // ========================================================================
        // ========================================================================

        // PROVEEDORES
        Route::group(['namespace' => 'App\Http\Controllers\proveedores'], function () {
            Route::resource('proveedores', 'ProveedoresController');
            Route::get('proveedor_edit/{idProveedor}', 'ProveedoresController@edit')->name('proveedor_edit');
        });

        // ========================================================================
        // ========================================================================

        // CATEGORIAS
        Route::group(['namespace' => 'App\Http\Controllers\categorias'], function () {
            Route::resource('categorias', 'CategoriasController');
            Route::get('categoria_edit/{idCategoria}', 'CategoriasController@edit')->name('categoria_edit');
            Route::post('editar_categoria', 'CategoriasController@update')->name('editar_categoria');
            Route::post('cambiar_estado_categoria', 'CategoriasController@destroy')->name('cambiar_estado_categoria');
        });

        // ========================================================================

        // PRODUCTOS
        Route::group(['namespace' => 'App\Http\Controllers\productos'], function () {
            Route::resource('productos', 'ProductosController');
            Route::post('verificar_producto', 'ProductosController@verificarProducto')->name('verificar_producto');
            Route::post('producto_show/{idProducto}', 'ProductosController@show')->name('producto_show');
            Route::post('producto_edit/{idProducto}', 'ProductosController@edit')->name('producto_edit');
            Route::post('producto_update', 'ProductosController@update')->name('producto_update');
            Route::post('cambiar_estado_producto', 'ProductosController@destroy')->name('cambiar_estado_producto');
            Route::post('query_barcode_producto/{idProducto}', 'ProductosController@queryBarCodeProducto')->name('query_barcode_producto');
            Route::post('producto_barcode', 'ProductosController@productoGenerarBarCode')->name('producto_barcode');
            Route::post('query_valores_producto', 'ProductosController@queryValoresProducto')->name('query_valores_producto');
            Route::get('reporte_productos_pdf', 'ProductosController@reporteProductosPdf')->name('reporte_productos_pdf');
            Route::post('verificar_referencia', 'ProductosController@referenceValidator')->name('verificar_referencia');

            //UMD
            // Route::post('umd', 'ProductosController@crearUmd')->name('umd');

            // ========================================================================
            
            // Abre automáticamente el archivo con los códigos QR del producto recién solicitado
            Route::get('/ver-pdf/{archivo}', function ($archivo) {
                $rutaPdf = storage_path("app/public/upfiles/productos/barcodes/{$archivo}");
            
                if (!file_exists($rutaPdf)) {
                    abort(404, "El archivo no existe.");
                }
            
                return response()->file($rutaPdf);
            })->name('ver.pdf');
        });

        // ========================================================================
        // ========================================================================

        // EXISTENCIAS
        Route::group(['namespace' => 'App\Http\Controllers\existencias'], function () {
            Route::resource('existencias', 'ExistenciasController');
            Route::get('bajas_index', 'ExistenciasController@bajasIndex')->name('bajas_index');
            Route::get('baja/{idBaja}', 'ExistenciasController@baja')->name('baja');
            Route::post('baja_store', 'ExistenciasController@bajaStore')->name('baja_store');
            Route::post('reporte_bajas_pdf', 'ExistenciasController@reporteBajasPdf')->name('reporte_bajas_pdf');
            Route::get('stock_minimo', 'ExistenciasController@stockMinimo')->name('stock_minimo');
            Route::post('stock_minimo_pdf', 'ExistenciasController@stockMinimoPdf')->name('stock_minimo_pdf');
            Route::get('alerta_stock_minimo_app', 'ExistenciasController@alertaStockMinimo')->name('alerta_stock_minimo_app');
        });

        // ========================================================================
        // ========================================================================

        // ENTRADAS
        Route::group(['namespace' => 'App\Http\Controllers\entradas'], function () {
            Route::resource('entradas', 'EntradasController');
            Route::get('detalleEntrada/{idEntrada}', 'EntradasController@entrada')->name('detalleEntrada');
            Route::post('anular_compra', 'EntradasController@anularCompra')->name('anular_compra');
            Route::post('reporte_compras_pdf', 'EntradasController@reporteComprasPdf')->name('reporte_compras_pdf');
            Route::get('detalle_compras_pdf/{idCompra}', 'EntradasController@detalleComprasPdf')->name('detalle_compras_pdf');
        });

        // ========================================================================
        // ========================================================================

        // VENTAS
        Route::group(['namespace' => 'App\Http\Controllers\ventas'], function () {
            Route::resource('ventas', 'VentasController');
            Route::post('reporte_ventas_pdf', 'VentasController@reporteVentasPdf')->name('reporte_ventas_pdf');
            Route::get('detalle_ventas_pdf/{idVenta}', 'VentasController@detalleVentasPdf')->name('detalle_ventas_pdf');
            Route::get('detalle_venta/{idVenta}', 'VentasController@detalleVentas')->name('detalle_venta');
            Route::post('recibo_caja_venta', 'VentasController@reciboCajaVenta')->name('recibo_caja_venta');

            Route::get('credito_ventas', 'VentasController@listarCreditoVentas')->name('credito_ventas');
        });

        // ========================================================================
        // ========================================================================

        // PRÉSTAMOS A EMPLEADOS
        Route::group(['namespace' => 'App\Http\Controllers\prestamos'], function () {
            Route::resource('prestamos', 'PrestamosController');
            Route::get('prestamos_vencer', 'PrestamosController@prestamosVencer')->name('prestamos_vencer');
        });

        // ========================================================================
        // ========================================================================

        // PAGO A EMPLEADOS
        Route::group(['namespace' => 'App\Http\Controllers\pago_empleados'], function () {
            Route::resource('pago_empleados', 'PagoEmpleadosController');
        });

        // ========================================================================
        // ========================================================================

        // EMPRESAS
        Route::group(['namespace' => 'App\Http\Controllers\empresas'], function () {
            Route::resource('empresas', 'EmpresasController');
            Route::post('empresa_datos_conexion', 'EmpresasController@empresaDatosConexion')->name('empresa_datos_conexion');
            Route::post('nit_validator', 'EmpresasController@nit_validator')->name('nit_validator');

            // GUARDAR DATOS EN EL .ENV DE LA EMPRESA
            // Route::post('guardar_datos_env', 'EmpresasController@guardarDatosEnv')->name('guardar_datos_env');
        });

        // ========================================================================
        // ========================================================================

        // Rutas roles y permisos
        Route::group(['namespace' => 'App\Http\Controllers\roles_permisos'], function () {
            Route::post('crear_rol', 'RolesPermisosController@guardarRol')->name('crear_rol');
            Route::post('crear_permiso', 'RolesPermisosController@guardarPermiso')->name('crear_permiso');
            Route::post('traer_permisos_usuario', 'RolesPermisosController@consultarPermisosPorUsuario')->name('traer_permisos_usuario');
        });

        // ========================================================================
        // ========================================================================

        // Unidades de Medida
        Route::group(['namespace' => 'App\Http\Controllers\unidades_medida'], function () {
            Route::resource('unidades_medida', 'UnidadesMedidaController');
        });
        
        // ========================================================================
        // ========================================================================

        // SUSCRIPCIONES
        Route::group(['namespace' => 'App\Http\Controllers\suscripciones'], function () {
            Route::resource('suscripciones', 'SuscripcionesController');
        });
        
        // ========================================================================
        // ========================================================================

        // PLANES
        Route::group(['namespace' => 'App\Http\Controllers\planes'], function () {
            Route::resource('planes', 'PlanesController');
        });
    }); // F..IN Route::middleware(['verificar.sesion']) RUTAS PROTEGIDAS
}); // FIN Route::middleware(['web'])

