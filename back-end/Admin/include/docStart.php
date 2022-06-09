<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!---->
    <meta name="robots" content="noindex, nofollow, noarchive" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" />
    <?php if($moreStyle): ?>
      <?php foreach($styleSheetNames as $styleSheetName): ?>
        <link rel="stylesheet" href="./stylesheets/<?php echo $styleSheetName; ?>">
      <?php endforeach; ?>
    <?php endif; ?>
    <title><?php echo $title; ?></title>
  </head>
  <body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="100">