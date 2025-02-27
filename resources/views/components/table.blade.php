<div id="{{ $tableId }}-wrapper" class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                @foreach($headers as $header)
                    <th scope="col" @if($header['field']) class="sortable" data-sort="{{ $header['field'] }}" @endif>
                        {{ $header['label'] }}
                        @if($header['field'])
                            <i class="bi bi-arrow-down-up sort-icon"></i>
                        @endif
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody id="{{ $tableId }}">
            <!-- Data will be inserted here by JavaScript -->
        </tbody>
    </table>
</div>

@if(isset($row_template))
    <template id="{{ $tableId }}-row-template">
        {{ $row_template }}
    </template>
@endif

<style>
.sortable {
    cursor: pointer;
}
.sort-icon {
    font-size: 0.8em;
    margin-left: 5px;
}
th[data-sort].asc .sort-icon::before {
    content: "\F146"; /* Bootstrap Icons: arrow-up */
}
th[data-sort].desc .sort-icon::before {
    content: "\F125"; /* Bootstrap Icons: arrow-down */
}
</style> 