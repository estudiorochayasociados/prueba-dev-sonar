<!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
<link rel="stylesheet" href="https://bootswatch.com/4/simplex/bootstrap.min.css" />
-->
<link rel="stylesheet" href="<?= URL_ADMIN ?>/css/style.css" />
<link href="<?= URL_ADMIN ?>/css/jquery.magicsearch.css" rel="stylesheet">
<meta charset="UTF-8" />
<title><?= TITULO_ADMIN ?></title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?= URL_ADMIN ?>/js/bootstrap-input-spinner.js"></script>
<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">
<link href="<?= URL_ADMIN ?>/css/tagify.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/css/loading.css" />
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/css/loading-btn.css" />

<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/theme/app-assets/vendors/css/vendors.min.css">
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/theme/app-assets/vendors/css/charts/apexcharts.css">
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/theme/app-assets/vendors/css/extensions/swiper.min.css">
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/theme/app-assets/vendors/css/forms/select/select2.min.css">
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/theme/app-assets/vendors/css/ui/prism.min.css">
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/theme/app-assets/vendors/css/file-uploaders/dropzone.min.css">
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/theme/app-assets/vendors/css/extensions/toastr.css">
<!-- END: Vendor CSS-->

<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/theme/app-assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/theme/app-assets/css/bootstrap-extended.css">
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/theme/app-assets/css/colors.css">
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/theme/app-assets/css/components.css">
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/theme/app-assets/css/themes/dark-layout.css">
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/theme/app-assets/css/themes/semi-dark-layout.css">
<!-- END: Theme CSS-->

<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/theme/app-assets/css/core/menu/menu-types/vertical-menu.css">
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/theme/app-assets/css/pages/dashboard-ecommerce.css">
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/theme/app-assets/css/plugins/file-uploaders/dropzone.css">
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/theme/app-assets/css/plugins/extensions/swiper.css">
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/theme/app-assets/css/pages/faq.css">
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/theme/app-assets/css/plugins/extensions/toastr.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.structure.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.theme.min.css" />


<!-- END: Page CSS-->

<!-- BEGIN: Custom CSS-->
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/theme/assets/css/style.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous" />
<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

<style>
    @font-face {
        font-family: 'boxicons';
        font-weight: normal;
        font-style: normal;
        src: url('<?= URL_ADMIN ?>/theme/app-assets/fonts/boxicons/fonts/boxicons.eot');
        src: url('<?= URL_ADMIN ?>/theme/app-assets/fonts/boxicons/fonts/boxicons.eot') format('embedded-opentype'),
            url('<?= URL_ADMIN ?>/theme/app-assets/fonts/boxicons/fonts/boxicons.woff2') format('woff2'),
            url('<?= URL_ADMIN ?>/theme/app-assets/fonts/boxicons/fonts/boxicons.woff') format('woff'),
            url('<?= URL_ADMIN ?>/theme/app-assets/fonts/boxicons/fonts/boxicons.ttf') format('truetype'),
            url('<?= URL_ADMIN ?>/theme/app-assets/fonts/boxicons/fonts/boxicons.svg?#boxicons') format('svg');
    }
</style>


<?php
$idioma = new Clases\Idiomas();
$defaultIdoma = $idioma->viewDefault();


?>