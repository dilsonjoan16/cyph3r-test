<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Report;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\CurrencyRatio;
use Illuminate\Http\RedirectResponse;

class ReportController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        return Inertia::render('Reports/ListReport', [
            'items' => Report::all()->toArray()
        ]);
    }


    /**
     * Show the create report form.
     *
     * @return \Inertia\Response
     */
    public function create(): Response
    {
        return Inertia::render('Reports/CreateReport');
    }

    /**
     * Store a new report with associated transactions.
     *
     * Validates the request and creates a new report with the provided title and date range.
     * Attaches all transactions created within the date range to the new report.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing the report data.
     * @return \Illuminate\Http\RedirectResponse A redirect to the reports index page.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'begin_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:begin_date',
        ]);

        $report = Report::create([
            'title' => $request->input('title'),
            'begin_date' => $request->input('begin_date'),
            'end_date' => $request->input('end_date'),
        ]);

        $transactionIds = Transaction::whereBetween('created_at', [$request->input('begin_date'), $request->input('end_date')])
        ->pluck('id');

        $report->transactions()->attach($transactionIds);

        return redirect()->route('reports.index');
    }

    /**
     * Show a single report, including its associated transactions.
     *
     * @param \App\Models\Report $report The report to show.
     * @return \Inertia\Response The Inertia response containing the report data.
     */
    public function show(Report $report): Response
    {
        $transactions = $report->transactions()->with('products')->get();

        $totalRevenue = $transactions->sum('amount');
        $totalCost = 0;
        $totalTax = 0;

        foreach ($transactions as $transaction) {
            foreach ($transaction->products as $product) {
                $totalCost += $product->cost_price * $product->quantity;
                $totalTax += $product->tax_amount * $product->quantity;
            }
        }

        $totalProfit = $totalRevenue - ($totalCost + $totalTax);

        return Inertia::render('Reports/ShowReport', [
            'id' => $report->id,
            'title' => $report->title,
            'begin_date' => $report->begin_date,
            'end_date' => $report->end_date,
            'shoppings' => array_map(function ($transaction) {
                $transaction['amount'] = (float) CurrencyRatio::where('currency_id', session('currency'))->first()->ratio * (float) $transaction['amount'];
                return $transaction;
            }, $transactions->toArray()),
            'total_revenue' => $totalRevenue,
            'total_cost' => (float) CurrencyRatio::where('currency_id', session('currency'))->first()->ratio * (float) $totalCost,
            'total_tax' => (float) CurrencyRatio::where('currency_id', session('currency'))->first()->ratio * (float) $totalTax,
            'total_profit' => (float) CurrencyRatio::where('currency_id', session('currency'))->first()->ratio * (float) $totalProfit,
        ]);
    }
}
