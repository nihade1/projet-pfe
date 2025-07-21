<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#005C59] focus:bg-[#005C59] active:bg-[#004441] focus:outline-none focus:ring-2 focus:ring-[#007A75] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
