{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i
            class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
@if(backpack_user()->can('cadastro_acesso'))
    <x-backpack::menu-dropdown title="Cadastro" icon="la la-folder">
        @if(backpack_user()->can('cadastro_prestadores_acesso'))
            <x-backpack::menu-dropdown-item title="Prestadores" icon="la la-first-aid"
                                            :link="url('/cadastro/prestador')"/>
        @endif
        @if(backpack_user()->can('cadastro_contratos_acesso'))
            <x-backpack::menu-dropdown-item title="Contratos" icon="la la-file-alt"
                                            :link="backpack_url('/cadastro/contrato')"/>
        @endif
    </x-backpack::menu-dropdown>
@endif
@if(backpack_user()->can('administracao_acesso'))
    <x-backpack::menu-dropdown title="Administração" icon="la la-puzzle-piece">
        @if(backpack_user()->can('administracao_habilitacao_acesso'))
            <x-backpack::menu-dropdown title="Habilitação" icon="la la-lock" nested="true">
                @if(backpack_user()->can('administracao_habilitacao_usuario_acesso'))
                    <x-backpack::menu-dropdown-item title="Usuários" icon="la la-user"
                                                    :link="url('/administracao/usuario')"/>
                @endif
                @if(backpack_user()->can('administracao_habilitacao_grupo_acesso'))
                    <x-backpack::menu-dropdown-item title="Grupos" icon="la la-group"
                                                    :link="url('/administracao/grupo')"/>
                @endif
                @if(backpack_user()->can('administracao_habilitacao_permissao_acesso'))
                    <x-backpack::menu-dropdown-item title="Permissões" icon="la la-key"
                                                    :link="url('/administracao/permissao')"/>
                @endif
            </x-backpack::menu-dropdown>
        @endif
        @if(backpack_user()->can('administracao_outros_acesso'))
            <x-backpack::menu-dropdown title="Outros" icon="la la-cogs" nested="true">
                @if(backpack_user()->can('administracao_outros_codigo_acesso'))
                    <x-backpack::menu-dropdown-item title="Código e Itens" icon="la la-list"
                                                    :link="url('/administracao/codigo')"/>
                @endif
                @if(backpack_user()->can('administracao_outros_estrutura_acesso'))
                    <x-backpack::menu-dropdown-item title="Estrutura" icon="la la-building"
                                                    :link="backpack_url('/administracao/estrutura')"/>
                @endif
                @if(backpack_user()->can('administracao_outros_igreja_acesso'))
                    <x-backpack::menu-dropdown-item title="Igreja" icon="la la-church"
                                                    :link="backpack_url('/administracao/igreja')"/>
                @endif
{{--                @if(backpack_user()->can('administracao_outros_cbo_acesso'))--}}
{{--                    <x-backpack::menu-dropdown-item title="Cbo" icon="la la-hard-hat"--}}
{{--                                                    :link="backpack_url('/administracao/cbo')"/>--}}
{{--                @endif--}}
            </x-backpack::menu-dropdown>
        @endif
    </x-backpack::menu-dropdown>
@endif
