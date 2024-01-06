</div>
</div>

<script src="<?php echo BASE_URL; ?>dist/js/scripts.js"></script>
<script src="<?php echo BASE_URL; ?>dist/js/custom.js"></script>

<?php if (isset($error_message)) : ?>
    <script>
        iziToast.show({
            message: '<?php echo $error_message ?>',
            position: 'topRight',
            color: 'red'
        })
    </script>
<?php endif; ?>

<?php if (isset($success_message)) : ?>
    <script>
        iziToast.show({
            message: '<?php echo $success_message ?>',
            position: 'topRight',
            color: 'green'
        })
    </script>
<?php endif; ?>

<?php if (isset($_SESSION['success_message'])) : ?>
    <script>
        iziToast.show({
            message: '<?php echo $_SESSION['success_message'] ?>',
            position: 'topRight',
            color: 'green'
        })
    </script>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>
</body>

</html>