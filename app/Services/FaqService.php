<?php

namespace App\Services;

use App\Models\Faq;

class FaqService
{
    public function getAllFaqs()
    {
        return Faq::latest()->get();
    }

    public function createFaq(array $data)
    {
        return Faq::create([
            'question' => $data['question'],
            'answer' => $data['answer']
        ]);
    }

    public function updateFaq(Faq $faq, array $data)
    {
        $faq->update([
            'question' => $data['question'],
            'answer' => $data['answer']
        ]);
        
        return $faq;
    }

    public function deleteFaq(Faq $faq)
    {
        return $faq->delete();
    }
}
