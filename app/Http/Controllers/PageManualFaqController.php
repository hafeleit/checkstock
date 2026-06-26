<?php

namespace App\Http\Controllers;

use App\Models\PageManualFaq;
use Illuminate\Http\Request;

class PageManualFaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:faq view', ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
        $this->middleware('permission:faq create', ['only' => ['create', 'store']]);
        $this->middleware('permission:faq edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:faq delete', ['only' => ['destroy']]);
    }

    const PAGE_LABELS = [
        'product360' => 'Products 360°',
    ];

    public function index()
    {
        $faqs = PageManualFaq::query()
            ->with('updatedBy')
            ->orderBy('page_identifier')
            ->groupBy('page_identifier')
            ->paginate(20);

        return view('pages.page-manual-faq.index', [
            'faqs'       => $faqs,
            'pageLabels' => self::PAGE_LABELS,
        ]);
    }

    public function create()
    {
        return view('pages.page-manual-faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_identifier' => 'required|string|max:255',
            'faqs' => 'required|array|min:1',
            'faqs.*.question' => 'required|string',
            'faqs.*.answer' => 'required|string',
            'faqs.*.sequence' => 'required|integer|min:1',
            'faqs.*.pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        foreach ($request->input('faqs', []) as $key => $item) {
            $pdfPath = null;
            if ($request->hasFile("faqs.$key.pdf")) {
                $pdfPath = $this->storePdf($request->file("faqs.$key.pdf"));
            }

            PageManualFaq::create([
                'page_identifier' => $request->input('page_identifier'),
                'question' => $item['question'],
                'answer' => $item['answer'],
                'sequence' => (int) $item['sequence'],
                'pdf_file_path' => $pdfPath,
                'updated_by' => auth()->id(),
            ]);
        }

        return redirect()->route('page-manual-faqs.index')->with('success', 'FAQ items saved successfully.');
    }

    public function show(string $pageManualFaq)
    {
        $faqs = PageManualFaq::where('page_identifier', $pageManualFaq)
            ->orderBy('sequence')
            ->get();

        abort_if($faqs->isEmpty(), 404);

        $pageLabels = self::PAGE_LABELS;
        $pageLabel = $pageLabels[$pageManualFaq] ?? $pageManualFaq;

        return view('pages.page-manual-faq.show', [
            'faqs' => $faqs,
            'pageManualFaq' => $pageManualFaq,
            'pageLabels' => $pageLabels,
            'pageLabel' => $pageLabel,
        ]);
    }

    public function edit(PageManualFaq $pageManualFaq)
    {
        $faqs = PageManualFaq::where('page_identifier', $pageManualFaq->page_identifier)
            ->orderBy('sequence')
            ->get();

        return view('pages.page-manual-faq.edit', [
            'pageManualFaq' => $pageManualFaq,
            'faqs' => $faqs,
        ]);
    }

    public function update(Request $request, PageManualFaq $pageManualFaq)
    {
        $request->validate([
            'faqs' => 'required|array|min:1',
            'faqs.*.question' => 'required|string',
            'faqs.*.answer' => 'required|string',
            'faqs.*.sequence' => 'required|integer|min:1',
            'faqs.*.pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $pageIdentifier = $pageManualFaq->page_identifier;
        $existingIds = PageManualFaq::where('page_identifier', $pageIdentifier)->pluck('id')->toArray();
        $submittedIds = [];

        foreach ($request->input('faqs', []) as $key => $item) {
            $itemId = !empty($item['id']) ? (int) $item['id'] : null;

            if ($itemId && in_array($itemId, $existingIds)) {
                $faq = PageManualFaq::find($itemId);
                $pdfPath = $faq->pdf_file_path;
                $deletePdf = !empty($item['delete_pdf']) && $item['delete_pdf'] === '1';

                if ($request->hasFile("faqs.$key.pdf")) {
                    $this->deletePdf($pdfPath);
                    $pdfPath = $this->storePdf($request->file("faqs.$key.pdf"));
                } elseif ($deletePdf) {
                    $this->deletePdf($pdfPath);
                    $pdfPath = null;
                }

                $faq->update([
                    'question' => $item['question'],
                    'answer' => $item['answer'],
                    'sequence' => (int) $item['sequence'],
                    'pdf_file_path' => $pdfPath,
                    'updated_by' => auth()->id(),
                ]);
                $submittedIds[] = $itemId;
            } else {
                $pdfPath = null;
                if ($request->hasFile("faqs.$key.pdf")) {
                    $pdfPath = $this->storePdf($request->file("faqs.$key.pdf"));
                }
                $new = PageManualFaq::create([
                    'page_identifier' => $pageIdentifier,
                    'question' => $item['question'],
                    'answer' => $item['answer'],
                    'sequence' => (int) $item['sequence'],
                    'pdf_file_path' => $pdfPath,
                    'updated_by' => auth()->id(),
                ]);
                $submittedIds[] = $new->id;
            }
        }

        $toDelete = array_diff($existingIds, $submittedIds);
        if (!empty($toDelete)) {
            $rows = PageManualFaq::whereIn('id', $toDelete)->get();
            foreach ($rows as $row) {
                $this->deletePdf($row->pdf_file_path);
            }
            PageManualFaq::whereIn('id', $toDelete)->delete();
        }

        return redirect()->route('page-manual-faqs.index')
            ->with('success', 'FAQ items updated successfully.');
    }

    public function destroy(PageManualFaq $pageManualFaq)
    {
        $rows = PageManualFaq::where('page_identifier', $pageManualFaq->page_identifier)->get();
        foreach ($rows as $row) {
            $this->deletePdf($row->pdf_file_path);
        }
        PageManualFaq::where('page_identifier', $pageManualFaq->page_identifier)->delete();

        return redirect()->route('page-manual-faqs.index')->with('success', 'FAQ deleted successfully.');
    }

    private function storePdf($file): string
    {
        $filename = uniqid('', true) . '_' . $file->getClientOriginalName();
        $file->move(public_path('storage/page-manual-faq'), $filename);
        return 'page-manual-faq/' . $filename;
    }

    private function deletePdf(?string $path): void
    {
        if ($path) {
            $full = public_path('storage/' . $path);
            if (file_exists($full)) {
                unlink($full);
            }
        }
    }
}
