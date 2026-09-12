<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $meta_data['title'] ?? getMeta($default_meta_data ?? [], 'main_title') ?></title>

    <meta name="description" content="<?= $meta_data['description'] ?? getMeta($default_meta_data ?? [], 'main_description') ?>">
    <meta name="keywords" content="<?= $meta_data['keywords'] ?? getMeta($default_meta_data ?? [], 'keywords') ?>">
    <meta name=”robots” content="index, follow">
    <meta property="og:image" content=""/>
    <meta name="og:title" content="<?= $meta_data['title'] ?? getMeta($default_meta_data ?? [], 'main_title') ?>">
    <meta property="og:description" content="<?= $meta_data['description'] ?? getMeta($default_meta_data ?? [], 'main_description') ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="" />

    <meta property="twitter:title" content="<?= $meta_data['title'] ?? getMeta($default_meta_data ?? [], 'main_title') ?>" />
    <meta property="twitter:description" content="<?= $meta_data['description'] ?? getMeta($default_meta_data ?? [], 'main_description') ?>" />
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:image:src" content="" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.8-dist/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/css/my.css') ?>">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
          rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Summernote   -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

