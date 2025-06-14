<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TekomDonate</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon-tekom.png') }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('node_modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/owl.carousel/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/owl.carousel/dist/assets/owl.theme.default.min.css') }}">

    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <script src="{{ asset('node_modules/chart.js/dist/Chart.min.js') }}"></script>

    <style>
        .bukti-thumbnail {
            width: 120px; /* Lebar gambar */
            height: 80px;  /* Tinggi gambar */
            object-fit: cover; /* Memastikan gambar terpotong rapi, tidak gepeng */
            border-radius: 5px; /* Sedikit lengkungan di sudut */
            cursor: pointer; /* Mengubah kursor menjadi tangan saat di atas gambar */
            transition: transform 0.2s; /* Efek transisi saat hover */
        }

        .bukti-thumbnail:hover {
            transform: scale(1.05); /* Sedikit memperbesar gambar saat disentuh kursor */
        }
    </style>
    </head>

<body>