@php
$style = "background-color: ".$category->background_color."; color: ".$category->font_color;
if (isset($reverse) && $reverse) {
    $style = "border: 1px solid ".$category->font_color."; color: ".$category->font_color;
}
@endphp
<span class="badge" style="{{ $style }}">
    {{ $category->name }}
</span>
