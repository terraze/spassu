<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                @foreach($headers as $header)
                    <th scope="col" class="sortable" data-sort="{{ $header['field'] ?? '' }}">
                        {{ $header['label'] }}
                        <i class="bi bi-arrow-down-up sort-icon"></i>
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody id="{{ $tableId }}">
            <!-- Data will be inserted here by JavaScript -->
        </tbody>
    </table>
</div>

<style>
.sortable {
    cursor: pointer;
}
.sort-icon {
    font-size: 0.8em;
    margin-left: 5px;
}
th[data-sort].asc .sort-icon::before {
    content: "\F12C"; /* Bootstrap Icons: arrow-down */
}
th[data-sort].desc .sort-icon::before {
    content: "\F12B"; /* Bootstrap Icons: arrow-up */
}
</style> 