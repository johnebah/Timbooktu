<?php

namespace App\Http\Controllers;

use App\Models\GuestPost;
use DOMDocument;
use DOMElement;
use DOMNode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuestnetnoPageController extends Controller
{
    public function index()
    {
        return view('pages.guestnetno', [
            'guestPosts' => GuestPost::query()
                ->where('is_approved', true)
                ->latest()
                ->paginate(6)
                ->withQueryString(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'author_name' => ['required', 'string', 'max:255'],
            'author_email' => ['nullable', 'email', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:100000'],
        ]);

        $sanitizedBody = $this->sanitizeRichText($validated['body']);
        $sanitizedBody = trim($sanitizedBody);

        if ($sanitizedBody === '' || Str::length(strip_tags($sanitizedBody)) === 0) {
            return back()
                ->withErrors(['body' => 'The text field is required.'])
                ->withInput();
        }

        GuestPost::query()->create([
            'author_name' => $validated['author_name'],
            'author_email' => $validated['author_email'] ?? null,
            'title' => $validated['title'],
            'body' => $sanitizedBody,
            'is_approved' => false,
        ]);

        return redirect()
            ->route('page.guestnetno')
            ->with('guest_post_submitted', true);
    }

    public function show(GuestPost $guestPost)
    {
        abort_unless($guestPost->is_approved, 404);

        return view('pages.guestnetno-detail', [
            'guestPost' => $guestPost,
        ]);
    }

    private function sanitizeRichText(string $html): string
    {
        $allowedTags = [
            'p',
            'br',
            'strong',
            'em',
            'u',
            's',
            'a',
            'ul',
            'ol',
            'li',
            'blockquote',
            'h1',
            'h2',
            'h3',
        ];

        $html = trim($html);
        if ($html === '') {
            return '';
        }

        $previous = libxml_use_internal_errors(true);

        $doc = new DOMDocument;
        $loaded = $doc->loadHTML('<?xml encoding="utf-8" ?>'.$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        if (! $loaded) {
            return strip_tags($html, '<p><br><strong><em><u><s><a><ul><ol><li><blockquote><h1><h2><h3>');
        }

        $this->sanitizeDomNode($doc, $allowedTags);

        return (string) $doc->saveHTML();
    }

    private function sanitizeDomNode(DOMNode $node, array $allowedTags): void
    {
        if ($node->hasChildNodes()) {
            for ($i = $node->childNodes->length - 1; $i >= 0; $i--) {
                $child = $node->childNodes->item($i);
                if (! $child) {
                    continue;
                }

                if ($child instanceof DOMElement) {
                    $tag = strtolower($child->tagName);
                    if (! in_array($tag, $allowedTags, true)) {
                        while ($child->firstChild) {
                            $node->insertBefore($child->firstChild, $child);
                        }
                        $node->removeChild($child);

                        continue;
                    }

                    $this->sanitizeAttributes($child, $tag);
                }

                $this->sanitizeDomNode($child, $allowedTags);
            }
        }
    }

    private function sanitizeAttributes(DOMElement $element, string $tag): void
    {
        $allowedAttributes = $tag === 'a' ? ['href'] : [];

        if ($element->hasAttributes()) {
            for ($i = $element->attributes->length - 1; $i >= 0; $i--) {
                $attr = $element->attributes->item($i);
                if (! $attr) {
                    continue;
                }
                if (! in_array(strtolower($attr->name), $allowedAttributes, true)) {
                    $element->removeAttributeNode($attr);
                }
            }
        }

        if ($tag === 'a') {
            $href = (string) $element->getAttribute('href');
            $href = trim($href);
            if ($href === '') {
                $element->removeAttribute('href');

                return;
            }

            $lower = strtolower($href);
            $isSafe = str_starts_with($lower, 'http://')
                || str_starts_with($lower, 'https://')
                || str_starts_with($lower, 'mailto:')
                || str_starts_with($lower, '/')
                || str_starts_with($lower, '#');

            if (! $isSafe) {
                $element->removeAttribute('href');
            }
        }
    }
}
