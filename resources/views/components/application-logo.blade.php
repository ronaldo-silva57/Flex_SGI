@props(['class' => ''])

<svg {{ $attributes->merge(['class' => 'w-10 h-10 ' . $class]) }}
     viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"
     aria-hidden="true">
    <!-- Escudo (conformidade / ISO) -->
    <path d="M20 3.5 6 9.5v9.2c0 8.6 5.9 15.5 14 17.8 8.1-2.3 14-9.2 14-17.8V9.5L20 3.5Z"
          class="fill-current opacity-10" />
    <path d="M20 3.5 6 9.5v9.2c0 8.6 5.9 15.5 14 17.8 8.1-2.3 14-9.2 14-17.8V9.5L20 3.5Z"
          stroke="currentColor" stroke-width="2" stroke-linejoin="round" />

    <!-- Check (conformidade) -->
    <path d="m13.5 19.8 4.5 4.5 8.5-9"
          stroke="currentColor" stroke-width="2.5"
          stroke-linecap="round" stroke-linejoin="round" />

    <!-- Folha (ESG / ambiental) -->
    <path d="M29.5 6.5c1.6-1.6 4.4-1.8 5.8-.4-1 2.4-3.4 3.9-6.2 3.4.2-1 .4-2 .4-3Z"
          class="fill-current opacity-70" />
</svg>