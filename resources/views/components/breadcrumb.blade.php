@props(['items' => []])

<nav class="text-sm text-gray-500 mb-4" aria-label="Breadcrumb">
    <ol class="flex items-center gap-2 flex-wrap">
        @foreach($items as $item)
            <li class="flex items-center gap-2">
                @if(!empty($item['url']))
                    <a href="{{ $item['url'] }}" class="hover:text-red-600 transition">
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="text-gray-800 font-medium">{{ $item['label'] }}</span>
                @endif

                @unless($loop->last)
                    <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
                @endunless
            </li>
        @endforeach
    </ol>
</nav>