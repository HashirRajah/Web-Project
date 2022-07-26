      
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <?php if(isset($scripts)): ?>
            <?php foreach($scripts as $script): ?>
                <script src="./scripts/<?php echo $script; ?>"></script>
            <?php endforeach; ?>
        <?php endif; ?>
    </body>
</html>