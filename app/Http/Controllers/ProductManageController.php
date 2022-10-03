<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Acces;
use App\Supply;
use App\Product;
use App\Transaction;
use App\Supply_system;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

class ProductManageController extends Controller
{
    // Show View Product
    public function viewProduct()
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)->first();
        if ($check_access->kelola_barang == 1) {
            // $products = DB::table('products')->simplePaginate(15);
            $products = Product::all()->sortBy('nama_barang');

            $supply_system = Supply_system::first();

            return view(
                'manage_product.product',
                compact('products', 'supply_system')
            );
        } else {
            return back();
        }
    }

    // Show View New Product
    public function viewNewProduct()
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)->first();
        if ($check_access->kelola_barang == 1) {
            $supply_system = Supply_system::first();

            return view('manage_product.new_product', compact('supply_system'));
        } else {
            return back();
        }
    }

    // Create New Product
    public function createProduct(Request $req)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)->first();
        if ($check_access->kelola_barang == 1) {
            $check_product = Product::where(
                'kode_barang',
                $req->kode_barang
            )->count();
            $supply_system = Supply_system::first();

            if ($check_product == 0) {
                $product = new Product();
                $product->kode_barang = substr(md5(mt_rand()), 1, 6);
                $product->nama_barang = $req->nama_barang;
                $product->kategori = $req->kategori;
                $product->warna = $req->warna;
                $product->ukuran = $req->ukuran;

                if ($supply_system->status == true) {
                    $product->stok = $req->stok;
                } else {
                    $product->stok = 1;
                }
                $product->harga = $req->harga;
                $product->save();

                Session::flash(
                    'create_success',
                    'Item baru berhasil ditambahkan'
                );

                return redirect('/product');
            } else {
                Session::flash('create_failed', 'Kode Item telah digunakan');

                return back();
            }
        } else {
            return back();
        }
    }

    // Edit Product
    public function editProduct($id)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)->first();
        if ($check_access->kelola_barang == 1) {
            $product = Product::find($id);

            return response()->json(['product' => $product]);
        } else {
            return back();
        }
    }

    // Update Product
    public function updateProduct(Request $req)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)->first();
        if ($check_access->kelola_barang == 1) {
            $check_product = Product::where(
                'kode_barang',
                $req->kode_barang
            )->count();
            $product_data = Product::find($req->id);
            if (
                $check_product == 0 ||
                $product_data->kode_barang == $req->kode_barang
            ) {
                $product = Product::find($req->id);
                $kode_barang = $product->kode_barang;
                $product->kode_barang = $req->kode_barang;

                $product->nama_barang = $req->nama_barang;
                $product->kategori = $req->kategori;
                $product->warna = $req->warna;
                $product->ukuran = $req->ukuran;

                $product->stok = $req->stok;
                $product->harga = $req->harga;
                if ($req->stok <= 0) {
                    $product->keterangan = 'Habis';
                } else {
                    $product->keterangan = 'Tersedia';
                }
                $product->save();

                Supply::where('kode_barang', $kode_barang)->update([
                    'kode_barang' => $req->kode_barang,
                ]);
                Transaction::where('kode_barang', $kode_barang)->update([
                    'kode_barang' => $req->kode_barang,
                ]);

                Session::flash('update_success', 'Data Item berhasil diubah');

                return redirect('/product');
            } else {
                Session::flash('update_failed', 'Kode barang telah digunakan');

                return back();
            }
        } else {
            return back();
        }
    }

    // Delete Product
    public function deleteProduct($id)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)->first();
        if ($check_access->kelola_barang == 1) {
            Product::destroy($id);

            Session::flash('delete_success', 'Item berhasil dihapus');

            return back();
        } else {
            return back();
        }
    }
}