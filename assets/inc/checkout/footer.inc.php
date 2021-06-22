<!--Footer section start-->
<footer class="footer-section section bg-gray">
    <div class="footer-bottom section">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-12 ft-border">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="copyright text-left">
                                <p class="text-center">Copyright &copy;2021 <a href="https://www.estudiorochayasoc.com/">Estudio Rocha y Asociados</a>. All rights reserved.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script src="<?= URL ?>/assets/js/services/lang.js"></script>
<script src="<?= URL ?>/assets/js/select2.min.js"></script>
<script src="<?= URL ?>/assets/js/bootstrap-notify.min.js"></script>
<script src="<?= URL ?>/assets/js/bootstrap.min.js"></script>
<script src="<?= URL ?>/assets/js/services/services.js"></script>
<script src="<?= URL ?>/assets/js/services/cart.js"></script>
<script src="<?= URL ?>/assets/js/services/user.js"></script>

<script>
    viewCart('<?= URL ?>');
    $("price").removeClass("hidden");
    $.validate({
        lang: 'es'
    });
</script>