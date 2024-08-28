<?php

namespace App\Http\Controllers;

use App\Enums\TransactionStatus;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\CurrencyRatio;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{

    /**
     * Display a list of products.
     *
     * Retrieves all products from the database and returns them to the
     * 'Shop/ListProduct' Inertia view, along with their prices converted
     * to the user's selected currency.
     *
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        $products = Product::all()->toArray();

        return Inertia::render('Shop/ListProduct', [
            'items' => array_map(function ($product) {
                $product['price'] = (float) CurrencyRatio::where('currency_id', session('currency'))->first()->ratio * (float) $product['price'];
                return $product;
            }, $products)
        ]);
    }

    /**
     * Buy a product.
     *
     * Create a transaction from the user's wallet to the product's price.
     * If the user's wallet has insufficient funds, throw an exception.
     *
     * @param Product $product the product to be bought
     * @return \Inertia\Response the Inertia view for the shopping cart
     * @throws \Exception if the user's wallet has insufficient funds
     */
    public function buy(Product $product): Response
    {
        $user = auth()->user();

        $userWallet = $user->wallets()->where('currency_id', session('currency'))->firstOrFail();
        if ($userWallet->balance < $product->price) {
            throw new \Exception('Insufficient funds');
        }

        DB::transaction(function () use ($product, $userWallet) {
            $transaction = Transaction::create([
                'wallet_id' =>$userWallet->id,
                'amount' => $product->price,
                'status' => TransactionStatus::PENDING->value,
            ]);

            $transaction->products()->attach($product->id);
        });

        return Inertia::render('Shopping/ShowShoppingCart', [
            'id' => $product->id,
            'date' => now()->format('Y-m-d H:i:s'),
            'user' => auth()->user()->name,
            'products' => [$product->toArray()],
            'total' => $product->price
        ]);
    }


    /**
     * Show a product's details.
     *
     * Retrieves the product's details from the database and returns them to the
     * 'Shop/ViewProduct' Inertia view.
     *
     * @param Product $product the product to be shown
     * @return \Inertia\Response the Inertia view for the product's details
     */
    public function show(Product $product): Response
    {
        return Inertia::render('Shop/ViewProduct', [
            'id' => $product->id,
            'title' => $product->name,
            'image' => $product->image,
            'price' => $product->price,
            'tax' => $product->tax_amount,
            'description' => $product->description,
        ]);
    }

    /**
     * Create a new product.
     *
     * Render the 'Shop/CreateProduct' Inertia view, passing an array of all
     * brands and categories to the view.
     *
     * @return \Inertia\Response the Inertia view for creating a product
     */
    public function create(): Response
    {
        return Inertia::render('Shop/CreateProduct', [
            'brands' => Brand::all()->toArray(),
            'categories' => Category::all()->toArray()
        ]);
    }

    /**
     * Store a new product.
     *
     * Validate the request data and create a new product in the database.
     * If successful, redirect to the product index page with a success
     * message. If an error occurs, log the error and redirect back to the
     * previous page with an error message.
     *
     * @param Request $request the request data for creating a product
     * @return \Illuminate\Http\RedirectResponse the redirect response
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'cost' => 'required|numeric',
                'price' => 'required|numeric',
                'tax' => 'required|numeric',
                'quantity' => 'required|integer',
                'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', // Validar la imagen
                'category' => 'required|integer',
                'brand' => 'required|integer',
                'status' => 'required|boolean',
            ]);

            $profitRate = $request->input('price');
            $taxRate = $request->input('tax');
            $costPrice = $request->input('cost');

            $price = $costPrice + ($profitRate / 100) * $costPrice;
            $tax = ($taxRate / 100) * $price;

            $imagePath = $request->file('image')->store('images', 'public');

            Product::create([
                'name' => $request->input('title'),
                'description' => $request->input('description'),
                'price' => $price + $tax,
                'quantity' => $request->input('quantity'),
                'image' => basename($imagePath),
                'category_id' => $request->input('category'),
                'brand_id' => $request->input('brand'),
                'tax_rate' => $taxRate,
                'tax_amount' => $tax,
                'cost_price' => $costPrice,
                'status' => $request->input('status'),
            ]);

            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } catch (\Throwable $th) {
            Log::error('Error al almacenar el producto: ' . $th->getMessage(), [
                'exception' => $th,
            ]);

            return redirect()->back()->with('error', 'An error occurred while creating the product.');
        }
    }


    /**
     * Edit a product.
     *
     * Retrieve the product from the database and return it to the 'Shop/EditProduct'
     * Inertia view, along with its ID, title, price, tax, description, quantity,
     * status, and cost price.
     *
     * @param Product $product the product to be edited
     * @return \Inertia\Response the Inertia view for editing the product
     */
    public function edit(Product $product): Response
    {
        return Inertia::render('Shop/EditProduct', [
            'id' => $product->id,
            'title' => $product->name,
            'price' => $product->price,
            'tax' => $product->tax_amount,
            'description' => $product->description,
            'quantity' => $product->quantity,
            'status' => $product->status,
            'cost' => $product->cost_price,
        ]);
    }

    /**
     * Update a product.
     *
     * Validate the request data, update the product in the database, and redirect to the product index page with a success message.
     *
     * @param Request $request the request data for updating a product, including the product ID, title, description, cost, price,
     *                         tax, quantity, image, category, brand, and status
     * @param Product $product the product to be updated
     * @return \Illuminate\Http\RedirectResponse the redirect response to the product index page with a success message
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'tax' => 'required|numeric',
            'quantity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validar la imagen
            'category' => 'required|integer',
            'brand' => 'required|integer',
            'status' => 'required|boolean',
        ]);

        $profitRate = $request->input('price');
        $taxRate = $request->input('tax');
        $costPrice = $request->input('cost');

        $price = ($profitRate / 100) * $costPrice;
        $tax = ($taxRate / 100) * $price;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $product->image = basename($imagePath);
        }

        $product->name = $request->input('title');
        $product->description = $request->input('description');
        $product->price = $price + $tax;
        $product->quantity = $request->input('quantity');
        $product->category_id = $request->input('category');
        $product->brand_id = $request->input('brand');
        $product->tax_rate = $taxRate;
        $product->tax_amount = $tax;
        $product->cost_price = $costPrice;
        $product->status = $request->input('status');
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }


    /**
     * Delete a product.
     *
     * Delete a product from the database and redirect to the product index page.
     *
     * @param Product $product the product to be deleted
     * @return \Illuminate\Http\RedirectResponse the redirect response to the product index page
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index');
    }
}
