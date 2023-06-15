</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
<script src="<?php echo SITE_URL; ?>public/assets/app.js"></script>
<script>
    <?php
    $sessionMessage = getSessionMessage();
    if ($sessionMessage): ?>
    Swal.fire({
        position: 'top-end',
        icon: '<?php echo $sessionMessage['alert']; ?>',
        title: '<?php echo $sessionMessage['message']; ?>',
        showConfirmButton: false,
        timer: 1500
    })
    <?php endif; ?>
</script>