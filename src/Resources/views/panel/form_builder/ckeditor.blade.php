@php
    $name = $input['name'];
    $id = str_replace('.', '_', $name);

    $parentClass = $input['parent_class'] ?? 'col-md-6';
    $labelText = $input['label']['text'][$languageCode] ?? array_shift($input['label']['text']);

    $input['input']['attributes']['type'] = $input['attributes']['type'] ?? 'text';

    $inputAttributes = '';
    foreach ($input['input']['attributes'] as $tag => $value) {
        $inputAttributes .= $tag.'="'.$value.'" ';
    }
@endphp

<div class="{{ $parentClass }}">
    <div class="form-group">
        <label for="{{ $id }}">{{ $labelText }}</label>
        <textarea {!! $inputAttributes !!} } id="{{ $id }}" name="{{ $name }}"></textarea>
    </div>
</div>

@push('scripts')
    <script src="{{ dawnstarAsset('plugins/ckeditor/build/ckeditor.js') }}"></script>
    <script>
        ClassicEditor.create(document.querySelector('.ckeditor'));
    </script>
@endpush