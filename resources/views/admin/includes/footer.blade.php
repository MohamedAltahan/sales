<footer class="main-footer">
    <!-- To the right -->
    @if (request()->is('admin/salesInvoice/details*'))
        <div>
            <strong> شركة : {{ $footerDetails->system_name }}--</strong>
            <strong> موبايل : {{ $footerDetails->phone }}--</strong>
            <strong> العنوان : {{ $footerDetails->address }}</strong>
        </div>
    @endif
    <!-- Default to the left -->
    {{-- <strong>0</strong> --}}
</footer>
