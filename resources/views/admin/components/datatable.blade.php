<table id="{{ $id }}" class="table table-striped table-bordered dt-responsive"
       role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;" width="100%" cellspacing="0">
    <thead>
    <tr>
        @forelse($columns as $key => $column) @php $props = ''; $col = '';
        @endphp @if (is_array($column)) @php $col = $key;
        @endphp
        @foreach($column as $k => $v) @php $props .= $k.'="'.$v.'"';
        @endphp @endforeach @else @php $col = $column;
        @endphp
        @endif
        <th {!! $props !!}>{!! $col !!}</th>
        @empty
            <th>Sin datos</th>
        @endforelse
    </tr>
    </thead>
    <tfoot>
    <tr>
        @forelse($columns as $key => $column) @php $props = ''; $col = '';
        @endphp @if (is_array($column)) @php $col = $key;
        @endphp
        @foreach($column as $k => $v) @php $props .= $k.'="'.$v.'"';
        @endphp @endforeach @else @php $col = $column;
        @endphp
        @endif
        <th {{ $props }}>{!! $col !!}</th>
        @empty
            <th>Sin datos</th>
        @endforelse
    </tr>
    </tfoot>
</table>