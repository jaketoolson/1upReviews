<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ elixir('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ elixir('css/layout.css') }}">
    @stack('header-styles')
    @stack('header-scripts')
</head>
<body {!! OneUpReviews\Helpers\HtmlHelper::mapsToAttributes($bodyAttributes ?? ['class' => 'enlarged', 'id' => 'boxed-layout', 'data-keep-enlarged' => 'true']) !!}>
