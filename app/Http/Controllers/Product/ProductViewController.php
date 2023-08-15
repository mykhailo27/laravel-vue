<?php

namespace App\Http\Controllers\Product;

use App\Constants\Ability;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProductViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        /** @var User $user */
        $user = Auth::user();

        $products = Product::query()
            ->when($request->get('search'), static function (Builder $query, string $search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('sku', 'like', "%$search%");
            })
            ->paginate($request->get('per_page', 10))
            ->through(fn($product) => [ // todo user resource
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'desc' => $product->desc,
                'price' => $product->price,
                'created_at' => $product->created_at,
                'can' => [
                    Ability::DELETE => $user->can(Ability::DELETE, $product)
                ]
            ])
            ->withQueryString()
            ->onEachSide(0);

        return Inertia::render('Product/Index', [
            'products' => $products,
            'filters' => $request->only(['search']),
            'can' => [
                Ability::CREATE => $user->can(Ability::CREATE, Product::class),
                Ability::DELETE_ANY => $user->can(Ability::DELETE_ANY, Product::class)
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function details(Product $product): Response
    {
        return Inertia::render('Product/Details', [
            'product' => $product,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->authorize(Ability::CREATE, Product::class);

        return is_null($product = Product::create($request->validated()))
            ? back()->withErrors(['error' => 'fail to create product'])
            : Redirect::route('products.details', ['product' => $product->id])->with('message', 'product created');
    }

    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize(Ability::CREATE, Product::class);

        return Inertia::render('Product/Details', [
            'product' => null,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return Redirect::route('products.index')
            ->with('message', "$product->name is deleted");
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $this->authorize(Ability::UPDATE, $product);

        return $product->update($request->validated())
            ? Redirect::route('products.details', ['product' => $product->id])
                ->with('message', 'product-updated')
            : back()->withErrors(['error' => 'fail to update product']);
    }
}
