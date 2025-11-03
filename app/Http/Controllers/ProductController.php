<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\View;

class ProductController extends Controller
{
      public function index(Request $request)
    {   //search
        $query = Product::query();
        if($request->has('search') && $request->search != ''){
            $search = $request->search;
            $query->where(function ($q) use ($search){
                $q->where('product_name', 'like', '%'.$search.'%');
            });
        }

        // return view('home');
        $data = Product::paginate (2);
        return view("master-data.product-master.index-product", compact('data'));
        //return view("master-data.product-master.index-product", compact('data'));
    }

    public function create()
    {
        return view("master-data.product-master.create-product");
    }

    public function store(Request $request)
    {
        $validasi_data = $request->validate([
            'product_name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'information' => 'nullable|string',
            'qty' => 'required|integer',
            'producer' => 'required|string|max:255',
        ]);


        Product::create($validasi_data);


        return redirect()->back()->with('success', 'product created successfully');
    }

    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('master-data.product-master.detail-product', compact('data'));
      //  return view('master-data.product-master.edit-product', compact('product'));
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('master-data.product-master.edit-product', compact('product'));
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'information' => 'nullable|string',
            'qty' => 'required|integer|min:1',
            'producer' => 'required|string|max:255',
        ]);


        $product = Product::findOrFail($id);
        $product->update([
            'product_name' => $request->product_name,
            'unit' => $request->unit,
            'type' => $request->type,
            'information' => $request->information,
            'qty' => $request->qty,
            'producer' => $request->producer,
        ]);


        return redirect()->back()->with('success', 'Product Update Successfully!');


    }

    public function destroy(string $id)
    {
        $product = Product::find($id);
        if($product){
            $product->delete();
            return redirect()->back()->with('success', 'Product berhasil dihapus.');

        }
        return redirect()->back()->with('error', 'Product tidak ditemukan.');
    }

    //fungsi baru
    public function exportExcel(): BinaryFileResponse{
       $periode = now()->format('F Y');

       return Excel::download(new ProductsExport($periode), 'product.xlsx');
       // return Excel::download(new ProductsExport, 'product.xlsx');

    }

    public function exportPDF(Request $request){
        $search = $request->input('search');
        $dataProduk = Product::query()
        ->when($search, function($query, $search){
            return $query->where('product_name', 'like', '%'.$search.'%');
        })
        ->get();

        $dataLaporan = [
            'data' =>$dataProduk,
            'periode' => now()->format('d F Y'),
            'judul' => 'Laporan Stok Produk'
        ];
        $pdf = Pdf::loadView('master-data.product-master.report-product', $dataLaporan);
        $pdf->setPaper('a4', 'potrait');

        return $pdf->download('laporan-product.pdf');
    }

    public function exportJPG(Request $request){
        $search = $request->input('search');
        $dataProduk = Product::query()
        ->when($search, function($query, $search){
            return $query->where('product_name', 'like', '%'.$search. '%');
        })
        ->get();

        $dataLaporan = [
            'data' => $dataProduk,
            'periode' => now()->format('d F Y'),
            'judul' => 'Laporan Stok Produk'
        ];
        // 3. Render view Blade menjadi string HTML
        $html = View::make('master-data.product-master.report-product', $dataLaporan)->render();

        // Path untuk menyimpan file sementara
        $path = storage_path('app/public/laporan-produk.jpg');

        Browsershot::html($html)
        ->windowSize(1200, 1000)
        ->fullPage()
        ->save($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }



}
