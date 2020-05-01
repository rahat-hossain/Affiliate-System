<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\InvoiceDetail;
use PDF;
use App\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        $invoices = Invoice::all();
        $invoiceDetails = InvoiceDetail::all();
        return view('backend.order.index', compact('invoices', 'invoiceDetails'));
    }

    function generateInvoice($id)
    {
        $invoice = InvoiceDetail::find($id);
        $pdf = PDF::loadView('backend.order.invoice', compact('invoice'));
        return $pdf->stream('invoice.pdf');
    }

    function orderDelete($order_id)
    {
        Invoice::findOrFail($order_id)->delete();
        InvoiceDetail::findOrFail($order_id)->delete();
        return back()->with('deletestatus', 'Order deleted successfully!!');
    }
}
