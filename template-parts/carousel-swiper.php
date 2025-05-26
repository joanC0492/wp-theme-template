<?php
$data = get_query_var('data_carousel', []);
$hero_title = $data['hero_title'] ?? '';
$image_data = $data['image_data'] ?? [];
$class_suffix = $data['class_suffix'] ?? '';
?>

<div class="swiper mySwiper<?= $class_suffix ?>" id="<?= $class_suffix ?>">
  <div class="swiper-wrapper">
    <?php foreach ($image_data as $slide): ?>
      <div class="swiper-slide">
        <img src="<?= esc_url($slide['url']); ?>" alt="<?= esc_attr($slide['title']); ?>">
      </div>
    <?php endforeach; ?>
  </div>
  <!-- Controles -->
  <div class="swiper-button-next swiper-button-next<?= $class_suffix ?>"></div>
  <div class="swiper-button-prev swiper-button-prev<?= $class_suffix ?>"></div>
  <div class="swiper-pagination swiper-pagination<?= $class_suffix ?>"></div>
</div>
<script>
  (() => {
    document.addEventListener("DOMContentLoaded", () => {
      const swiper = new Swiper(".mySwiper<?= $class_suffix ?>", {
        slidesPerView: 1,
        spaceBetween: 30,
        effect: "fade",
        loop: true,
        navigation: {
          nextEl: ".swiper-button-next<?= $class_suffix ?>",
          prevEl: ".swiper-button-prev<?= $class_suffix ?>",
        },
        pagination: {
          el: ".swiper-pagination<?= $class_suffix ?>",
          clickable: true,
        },
      });
    });
  })();
</script>
<style>
  .swiper {
    width: 100%;
    height: 100%;
  }

  .swiper-slide {
    background-position: center;
    background-size: cover;
  }

  .swiper-slide img {
    display: block;
    width: 100%;
    /* height: 100%; */
    object-fit: cover;
    height: 576px;
  }
</style>