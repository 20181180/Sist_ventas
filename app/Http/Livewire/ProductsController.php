<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Company;

class ProductsController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $name, $barcode, $prove_id, $cost, $price, $price_m, $stock, $alerts, $categoryid, $search, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 10;


    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Productos';
        $this->categoryid = 'Elegir';
        $this->price = 0;
        $this->prove_id = 0;
        // $this->cost = 0;
    }
    public function render()
    {
        $this->price_wholesale_retail();
        if (strlen($this->search) > 0)
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->where('products.name', 'like', '%' . $this->search . '%')
                ->orWhere('products.barcode', 'like', '%' . $this->search . '%')
                ->orWhere('c.name', 'like', '%' . $this->search . '%')
                ->orderBy('products.name', 'asc')
                ->paginate($this->pagination);
        else
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->orderBy('products.name', 'asc')
                ->paginate($this->pagination);


        return view('livewire.products.component', [
            'products' => $products,
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
        //metdo de crear el producto

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
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/products', $customFileName);
            $product->image = $customFileName;
            $product->save();
        }

        $this->resetUI();
        $this->emit('product-added', 'Producto Registrado xd');
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

        $this->resetUI();
        $this->emit('product-added', 'Producto Registrado.');
    }


    public function resetUI()
    {
        $this->name = '';
        $this->cost = '';
        $this->barcode = '';
        $this->price = '';
        $this->stock = '';
        $this->alerts = '';
        $this->category_id = 'Elegir';
        $this->prove_id = 0;
        $this->image = 'null';
        $this->selected_id = 0;
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
}
