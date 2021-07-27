@extends('DawnstarView::layouts.app')

@section('content')
    <main id="main-container">

        <div class="content content-max-width">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('DawnstarLang::container.index_title') }}</h1>
                @include('DawnstarView::layouts.breadcrumb')
            </div>
        </div>

        <div class="content">
            <div class="block block-rounded">
                <div class="block-content">
                    @include('DawnstarView::layouts.alerts')

                    <div class="row items-push justify-content-end text-right">
                        <div class="mr-2">
                            <a href="{{ route('dawnstar.containers.structures.create') }}" class="btn btn-sm btn-primary" data-toggle="click-ripple">
                                <i class="fa fa-fw fa-plus mr-1"></i>
                                {{ __('DawnstarLang::general.add_new') }}
                            </a>
                        </div>
                    </div>

                    <table class="table table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th class="text-center">{{ __('DawnstarLang::container.labels.status') }}</th>
                            <th>{{ __('DawnstarLang::container.labels.name') }}</th>
                            <th>{{ __('DawnstarLang::container.labels.key') }}</th>
                            <th class="text-center">{{ __('DawnstarLang::container.labels.type') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('DawnstarLang::general.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($containers as $container)
                            <tr>
                                <th class="text-center" scope="row">
                                    {{ $container->id }}
                                </th>
                                <td class="text-center">
                                    <span class="badge badge-{{ getStatusColorClass($container->status) }} fa-1x p-2">
                                        {{ getStatusText($container->status) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $container->detail->name }}
                                </td>
                                <td>
                                    <strong>{{ $container->key }}</strong>
                                </td>
                                <td class="text-center">
                                    {{ $container->type }}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('dawnstar.containers.structures.edit', $container) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="bottom"
                                           title="{{ __('DawnstarLang::general.edit') }}">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>


                                        <form action="{{ route('dawnstar.containers.structures.destroy', $container) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="button"
                                                    data-toggle="tooltip"
                                                    class="btn btn-sm btn-danger deleteBtn"
                                                    data-placement="bottom"
                                                    title="{{ __('DawnstarLang::general.delete') }}">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ dawnstarAsset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ dawnstarAsset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $('.deleteBtn').on('click', function () {
            var self = $(this);
            swal.fire({
                title: '{{ __('DawnstarLang::general.swal.title') }}',
                text: '{{ __('DawnstarLang::general.swal.subtitle') }}',
                icon: 'warning',
                showCancelButton: true,
                customClass: {
                    confirmButton: 'btn btn-danger m-1',
                    cancelButton: 'btn btn-secondary m-1'
                },
                confirmButtonText: '{{ __('DawnstarLang::general.swal.confirm_btn') }}',
                cancelButtonText: '{{ __('DawnstarLang::general.swal.cancel_btn') }}',
                html: false,
                preConfirm: e => {
                    return new Promise(resolve => {
                        setTimeout(() => {
                            resolve();
                        }, 50);
                    });
                }
            }).then(result => {
                if (result.value) {
                    self.closest('form').submit();
                }
            });
        });
    </script>
@endpush
