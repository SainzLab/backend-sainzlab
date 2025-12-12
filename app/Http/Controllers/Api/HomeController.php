<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Faq;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil data Services
        $services = Service::where('is_active', true)->get()->map(function($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'category' => $item->category,
                'desc' => $item->description,
                'price' => $item->price_label,
                // Pastikan setup storage:link sudah dijalankan
                'image' => $item->image ? asset('storage/' . $item->image) : null,
            ];
        });

        // Mengambil data Portfolio
        $portfolios = Portfolio::where('is_active', true)->latest()->take(6)->get()->map(function($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'category' => $item->category,
                'image' => asset('storage/' . $item->image),
                'link' => $item->link
            ];
        });

        // Mengambil data FAQ
        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'services' => $services,
                'portfolios' => $portfolios,
                'faqs' => $faqs
            ]
        ]);
    }
}
