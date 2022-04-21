<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\Product;
use App\Models\Vista_stockalerts;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Barryvdh\DomPDF\Facade as PDF;

class ProductsController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public  $direc, $tel, $empresa, $imagecate, $cantAlertas, $names,  $searchAlert, $precioTotal, $name, $Pro_t, $barcode, $precio, $stock_ing, $prove_id, $cost, $price, $price_m, $stock, $alerts, $categoryid, $search, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 10;


    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Productos';
        $this->categoryid = 0;
        $this->price = 0;
        $this->prove_id = 0;
        $this->stock_ing = '';
        // $this->cost = 0;
    }
    public function render()
    {
        $this->price_wholesale_retail();
        $this->datos_p();
        if (strlen($this->search) > 0)
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->where('products.name', 'like', '%' . $this->search . '%')
                ->orWhere('products.barcode', 'like', '%' . $this->search . '%')
                ->orWhere('c.name', 'like', '%' . $this->search . '%')
                ->orderBy('products.stock', 'asc')
                ->paginate($this->pagination);
        else
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->orderBy('products.stock', 'asc')
                ->paginate($this->pagination);

        if (strlen($this->searchAlert) > 0)
            $productsAlert = Product::select('*')->where('name', 'like', '%' . $this->searchAlert . '%')->get();
        else
            $productsAlert = Vista_stockalerts::select('*')->get();
        $this->cantAlertas = count($productsAlert);

        return view('livewire.products.component', [
            'products' => $products,
            'productsA' => $productsAlert,
            'categories' => Category::orderBy('name', 'asc')->get(),
            'prove' => Company::orderBy('name', 'asc')->get()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function price_wholesale_retail()
    {
        #le falta pasarle la operacion real a este metodo pero ya jala
        if (empty($this->cost)) {
            $this->price = 0;
            $this->price_m = 0;
        } else {
            $this->price = number_format(($this->cost / (1 - 0.3)), 2);
            $this->price_m = number_format(($this->cost / (1 - 0.2)), 2);
        }
    }

    public function Store()
    {
        $rules = [
            'name' => 'required|unique:products|min:3',
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alerts' => 'required',
            //'barcode' => 'required',
            'categoryid' => 'required|not_in:Elegir',
            'prove_id' => 'required|not_in:Elegir',

        ];

        $messages = [
            'name.required' => 'Lo sentimos el nombre es obligatorio',
            'name.unique' => '!Ups, el producto ya se encuentra en existencia¡',
            'name.min' => 'Ingrese minimo 3 caracteres para el producto',
            'cost.required' => 'Costo Obligatorio',
            'price.required' => 'Precio requerido',
            'stock.required' => 'Ingrese la cantidad cantidad existente',
            'alerts.required' => 'Ingresa un valor minimo en existencia',
            //'barcode.required' => 'Ingrese un codigo',
            'categoryid.required' => 'Campo obligatorio',
            'categoryid.not_in' => 'Eliga una opcion valido',
            'prove_id.not_in' => 'Eliga una opcion valido',
        ];

        $this->validate($rules, $messages);
        //metdo de crear el producto
        $fined_id = Product::latest('id')->first();
        $id = $fined_id->id + 1;
        //dd($id);
        if (empty($fined_id)) {
            $this->barcode =  "M0000";
        } else {
            $id = $fined_id->id + 1;
            $this->barcode =  'M000' . $id;
        }


        $product = Product::create([
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'price_mayoreo' => $this->price_m,
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->categoryid,
            'provedor_id' => $this->prove_id,
        ]);


        //  $customFileName;
        if ($this->image) {

            $ex = '.' . $this->image->extension();
            // dd($ex);
            if ($ex == '.jpg' || $ex == '.png') {
                $customFileName = uniqid() . '_.' . $this->image->extension();
                $this->image->storeAs('public/products', $customFileName);
                $product->image = $customFileName;
                $product->save();
            } elseif ($ex != 'jpg' || $ex != 'png') {
                // $this->resetUI();
                $this->emit('product-no', 'verifique el formato de la imagen, por el momento se a sustituido por un imagen por defecto');
                return;
            }
        }

        $this->categoryid = 0;
        $this->prove_id = 0;
        $this->resetUI();
        $this->emit('product-added', 'Producto Registrado');
    }


    public function Edit(Product $product)
    {
        $this->selected_id = $product->id;
        $this->name = $product->name;
        $this->barcode = $product->barcode;
        $this->cost = $product->cost;
        $this->price = $product->price;
        $this->price_mayoreo = $product->price_m;
        $this->stock = $product->stock;
        $this->alerts = $product->alerts;
        $this->categoryid = $product->category_id;
        $this->prove_id = $product->provedor_id;
        $this->image = $product->null;

        $this->emit('modal-show', 'Editar Producto');
    }

    public function Stock_New(Product $product)
    {
        $this->selected_id = $product->id;
        $this->name = $product->name;
        $this->stock = $product->stock;
        $this->emit('add_stock', 'Agregar Producto');
    }

    public function goUpdate($id = null, $cant = null)
    {
        if ($id > 0 && $cant > 0) {
            $this->selected_id = $id;
            $this->stock_ing = $cant;
        }
        $rules = [
            'stock_ing' => 'required',
        ];

        $messages = [
            'stock_ing.required' => 'Campo Obligatorio..',
        ];

        $this->validate($rules, $messages);

        //metdo de crear el producto}


        $product = Product::find($this->selected_id);
        $h = $product->stock + $this->stock_ing;
        //  dd($h);
        $product->update([
            'stock' => $h,
        ]);

        $this->resetUI();
        $this->emit('stok_sucess', 'Stock Actualizado.');
    }

    //metod of update ;-)
    public function Update()
    {
        $rules = [
            'name' => "required|min:3|unique:products,name,{$this->selected_id}",
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alerts' => 'required',
            'barcode' => 'required',
            'categoryid' => 'required|not_in:Elegir',
            'prove_id' => 'required|not_in:Elegir',

        ];

        $messages = [
            'name.required' => 'Lo sentimos el nombre es obligatorio',
            'name.unique' => '!Ups, el producto ya se encuentra en existencia¡',
            'name.min' => 'Ingrese minimo 3 caracteres para el producto',
            'cost.required' => 'Costo Obligatorio',
            'price.required' => 'Precio requerido',
            'stock.required' => 'Ingrese la cantidad cantidad existente',
            'alerts.required' => 'Ingresa un valor minimo en existencia',
            'barcode.required' => 'Ingrese un codigo',
            'categoryid.required' => 'Campo obligatorio',
            'categoryid.not_in' => 'Eliga una opcion valido',
            'prove_id.not_in' => 'Eliga una opcion valido',
        ];

        $this->validate($rules, $messages);

        //metdo de crear el producto}

        $product = Product::find($this->selected_id);

        $product->update([
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->categoryid,
            'provedor_id' => $this->prove_id,
        ]);

        //  $customFileName;
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/products', $customFileName);
            $imageTem = $product->image;
            $product->image = $customFileName;
            $product->save();

            if ($imageTem != null) { //comprobamos si la imagen es diferente de null en la bd
                if (file_exists('storage/products' . $imageTem)) {
                    //actualizamos la imagen de nuevo..
                    unlink('storage/products' . $imageTem);
                }
            }
        }
        $this->categoryid = 0;
        $this->prove_id = 0;
        $this->resetUI();
        $this->emit('product-added', 'Producto Registrado.');
    }
    public function datos_p()
    {
        $products = Product::select('stock', 'price')->get();
        $this->Pro_t = $products ? $products->sum('stock') : 0;
        $this->precio = $products ? $products->sum('price') : 0;
        $total = 0;
        foreach ($products as $p) {
            $total += $p->stock * $p->price;
        }

        $this->precioTotal = $total;
    }




    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Product $product)
    {
        //$category = Category::find($id);
        $imageTem = $product->image;
        $product->delete();

        if ($imageTem != null) {
            if (file_exists('storage/products' . $imageTem)) {
                //actualizamos la imagen de nuevo..
                unlink('storage/products' . $imageTem);
            }
        }

        $this->resetUI();
        $this->emit('product-deleted', 'Producto Eliminado');
    }

    public function GeneratePDF()
    {
        $data = [];
        $data = Product::join('categories as c', 'c.id', 'products.category_id')
            ->select('products.*', 'c.name as category')->get();

        $user = 'juan'; //cambiar a auth()
        $fecha = Carbon::now();
        $pdf = PDF::loadView('pdf.inventory', compact('data'));
        return $pdf->stream('salesReport.pdf');
        return $pdf->download('salesReport.pdf');

        //Cart::clear(); //limpiamos e inicializamos las varibles..
    }
    public function Categoria()
    {
        $rules = [
            'name' => 'required|unique:categories|min:3'
        ];

        $messages = [
            'name.required' => 'Categoria Obligatorio',
            'name.unique' => 'Verifique que no exista la categoria',
            'name.min' => 'Ingrese minimo 3 caracteres para el nombre de la categoria'
        ];
        //$hl = $this->namecate;
        // dd($hl);
        $this->validate($rules, $messages);
        $category = Category::create([
            'name' => $this->name,
        ]);

        //  $customFileName;
        if ($this->imagecate) {
            $customFileName = uniqid() . '_.' . $this->imagecate->extension();
            $this->imagecate->storeAs('public/categories', $customFileName);
            $category->image = $customFileName;
            $category->save();
        }
        $idcat = Category::select('id')->orderBy('id', 'desc')->first();
        $this->categoryid = $idcat->id;
        //$this->resetUI();
        $this->emit('category-added', 'Categoria registrado xd');
    }
    public function Proveedor()
    {
        $rules = [
            'name' => 'required',
            'direc' => 'required',
            'tel' => 'required|max:10',
            'empresa' => 'required'
        ];

        $messages = [
            'name.required' => 'El nombre es obligatorio',
            'direc.required' => 'Direccion obligatorio',
            'tel.required' => 'Ingrese un telefono',
            'tel.max' => 'Numero a digitos',
        ];

        $this->validate($rules, $messages);

        $companie = Company::create([
            'name' => $this->name,
            'address' => $this->direc,
            'phone' => $this->tel,
            'taxpayer_id' => $this->empresa,
        ]);
        $idprov = Company::select('id')->orderBy('id', 'desc')->first();
        $this->prove_id = $idprov->id;

        $this->resetUI();
        $this->emit('pro-added', 'Provedor Registrado con Exito.');
    }
    public function resetUI()
    {
        $this->name = '';
        $this->cost = '';
        $this->barcode = '';
        $this->price = '';
        $this->stock = '';
        $this->alerts = '';
        // $this->categoryid = 0;
        //$this->prove_id = 0;
        $this->image = 'null';
        $this->selected_id = 0;
        $this->stock_ing = '';
        $this->direc;
        $this->tel;
        $this->empresa;
    }
}
