@extends('layouts.master')
@section('header-css')
@endsection

@section('content')
    <div id="content">
        <table class="table table-condensed">
            <!-- On rows -->
            <tr class="active">...</tr>
            <tr class="success">...</tr>
            <tr class="warning">...</tr>
            <tr class="danger">...</tr>
            <tr class="info">...</tr>

            <!-- On cells (`td` or `th`) -->
            <tr>
                <td class="active">...</td>
                <td class="success">...</td>
                <td class="warning">...</td>
                <td class="danger">...</td>
                <td class="info">...</td>
            </tr>
        </table>
    </div>
@endsection

@section('footer-js')
@endsection
