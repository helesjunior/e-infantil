@if ($crud->hasAccess('update'))
    <div class="btn-group">
        <a class="btn btn-sm btn-link dropdown-toggle text-primary pl-1" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span><i class="la la-cog"></i></span>
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-right">
            <li>
                &nbsp; <a href="/administracao/codigo/{{ $entry->getKey() }}/item">
                    <i class="la la-greater-than"></i> Items
                </a>
            </li>
        </ul>
    </div>
@endif
