<?php

namespace App\Http\Controllers\frontend\mainPortal;

use App\Http\Controllers\Controller;
use App\Models\SystemFAQ;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function faq()
    {
        $faqs = SystemFAQ::with('category')->get();

        $groupedFaqs = $faqs->groupBy(fn($faq) => strtolower($faq->category->category_name ?? 'uncategorized'))
            ->map(function ($items) {
                return $items->map(function ($faq) {
                    return [
                        'q' => $faq->faq_question,
                        'a' => $faq->faq_answer,
                        'tag' => $faq->category->category_name ?? '',
                    ];
                })->values();
            });

        $allFaqs = $groupedFaqs->flatten(1)->values();

        $groupedFaqs = collect(['all' => $allFaqs])->merge($groupedFaqs);

        return view('frontend.mainPortal.faq', [
            'groupedFaqs' => $groupedFaqs,
            'faqsJson' => $groupedFaqs->toJson(JSON_UNESCAPED_UNICODE),
        ]);
    }
}
