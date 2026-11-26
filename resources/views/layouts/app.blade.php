@php
    $userRole = strtolower(
        is_object(auth()->user()->role ?? null)
            ? (auth()->user()->role->slug ?? auth()->user()->role->name ?? '')
            : (auth()->user()->role ?? '')
    );
@endphp

@if($userRole === 'admin')
    <a href="{{ route('admin.kategori-satuan.index') }}"
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.kategori-satuan.*') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
        <span>Kategori Satuan</span>
    </a>
@endif

@if(in_array($userRole, ['pemilik', 'pemilik_toko', 'karyawan']))
    <a href="{{ route('barang.index') }}"
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('barang.*') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
        <span>Data Barang</span>
    </a>
@endif