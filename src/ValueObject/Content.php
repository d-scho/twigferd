<?php

declare(strict_types=1);

namespace App\ValueObject;

final readonly class Content
{
    /**
     * @param list<string>                           $recipientAddress
     * @param list<string>                           $senderAddress
     * @param array<string, string>|null             $documentIdentifiers
     * @param array<string, \DateTimeImmutable>|null $documentDates
     * @param list<string>                           $itemHeadings
     * @param array<list<string|int>>                $items
     */
    public function __construct(
        public array $recipientAddress,
        public string $senderLogoBase64,
        public array $senderAddress,
        public ?string $title,
        public ?array $documentIdentifiers,
        public ?array $documentDates,
        public ?string $leadInText,
        public array $itemHeadings,
        public array $items,
        public ?string $leadOutText,
    ) {
        assert(!empty($recipientAddress), 'At least one recipient address line must be provided.');
        assert(!empty($senderAddress), 'At least one sender address line must be provided.');
        assert(!empty($itemHeadings), 'At least one heading must be provided.');
        assert(!empty($items), 'At least one item must be provided.');

        $headingsCount = count($itemHeadings);
        foreach ($items as $item) {
            $columnsCount = count($item);

            assert(
                assertion: $columnsCount === $headingsCount,
                description: sprintf(
                    "Each row's number of entries (i.e. columns) must correspond to the number of headings. Failed at \"%s\" (%d items). Headings: \"%s\" (%d items).",
                    json_encode($item),
                    $columnsCount,
                    json_encode($itemHeadings),
                    $headingsCount,
                ),
            );
        }
    }
}
