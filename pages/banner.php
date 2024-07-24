<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Banner Rotativo</title>
<style>
    body {
    font-family: Arial, sans-serif;
}

.banner-container {
    position: relative;
    width: 100%;
    height: 300px; /* Ajuste conforme necessário */
    overflow: hidden;
}

.banner {
    position: absolute;
    top: 0;
    left: 100%;
    width: 100%;
    height: 100%;
    background-color: #ddd;
    text-align: center;
    line-height: 300px; /* Alinhar verticalmente, ajuste conforme necessário */
    font-size: 24px;
    transition: left 1s ease-in-out;
}

.banner.active {
    left: 0;
}

.banner.inactive {
    left: -100%;
}

#video-frame {
    width: 100%;
    height: 100%;
}

</style>
    
</head>
<body>
    <div class="banner-container">
        <div class="banner" id="banner1">
            <iframe width="560" height="315" 
            id="video-frame" src="" frameborder="0" 
            allowfullscreenframeborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen
            ></iframe></div>
        <div class="banner" id="banner2">Banner 2</div>
        <div class="banner" id="banner3">
            banner 3 
        </div>
    </div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const banners = document.querySelectorAll(".banner");
    let currentIndex = 0;

    // URL do vídeo do YouTube
    const videoURL = "https://www.youtube.com/embed/Nu52xAFV2Ms?si=_3p5yY9NNhsMDKQD"; // Substitua pela URL externa real

    // Configura o iframe do vídeo
    const videoFrame = document.getElementById("video-frame");
    videoFrame.src = videoURL;

    function showNextBanner() {
        banners[currentIndex].classList.remove("active");
        banners[currentIndex].classList.add("inactive");

        currentIndex = (currentIndex + 1) % banners.length;

        banners[currentIndex].classList.remove("inactive");
        banners[currentIndex].classList.add("active");
    }

    // Inicializa o primeiro banner
    banners[currentIndex].classList.add("active");

    // Muda o banner a cada 3 minutos (180000 milissegundos)
    setInterval(showNextBanner, 118000);
});

</script>
</body>
</html>
